<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $issue = $_POST['issue'];

    // הגדרות שליחת מייל
    $to = "shlomi@barorian.co.il"; // עדכן כאן את המייל שלך באוטלוק
    $subject = "בעיה חדשה מהאתר";
    $message = "שם פרטי: $firstName\nשם משפחה: $lastName\nאימייל: $email\nטלפון: $phone\nתיאור הבעיה:\n$issue";

    // הגדרות קבצים מצורפים
    $headers = "From: $email";
    $file = $_FILES['attachment'];

    if ($file['size'] > 0) {
        $boundary = md5(time());
        $headers .= "\nMIME-Version: 1.0\nContent-Type: multipart/mixed; boundary=\"$boundary\"";

        $message = "--$boundary\nContent-Type: text/plain; charset=UTF-8\n\n$message\n";
        $fileContent = file_get_contents($file['tmp_name']);
        $fileName = $file['name'];
        $fileEncoded = chunk_split(base64_encode($fileContent));

        $message .= "--$boundary\nContent-Type: application/octet-stream; name=\"$fileName\"\nContent-Transfer-Encoding: base64\nContent-Disposition: attachment; filename=\"$fileName\"\n\n$fileEncoded\n--$boundary--";
    }

    // שליחת המייל
    if (mail($to, $subject, $message, $headers)) {
        echo "ההודעה נשלחה בהצלחה!";
    } else {
        echo "שגיאה בשליחת ההודעה.";
    }
}
?>
