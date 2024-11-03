<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $issue = $_POST['issue'];

    // כתובת המייל שאליה יישלחו הנתונים
    $to = "your-outlook-email@example.com"; // החלף במייל האמיתי שלך
    $subject = "בעיה חדשה מהאתר";
    $message = "שם פרטי: $firstName\nשם משפחה: $lastName\nאימייל: $email\nטלפון: $phone\nתיאור הבעיה:\n$issue";

    // הגדרת הכותרות של המייל
    $headers = "From: $email";
    $file = $_FILES['attachment'];

    // בדיקה אם יש קובץ מצורף
    if ($file['size'] > 0) {
        // הגדרת המידע עבור הקובץ המצורף
        $boundary = md5(time());
        $headers .= "\nMIME-Version: 1.0\nContent-Type: multipart/mixed; boundary=\"$boundary\"";

        // תוכן המייל עם הקובץ המצורף
        $message = "--$boundary\nContent-Type: text/plain; charset=UTF-8\n\n$message\n";
        $fileContent = file_get_contents($file['tmp_name']);
        $fileName = $file['name'];
        $fileEncoded = chunk_split(base64_encode($fileContent));

        // הוספת הקובץ המצורף להודעה
        $message .= "--$boundary\nContent-Type: application/octet-stream; name=\"$fileName\"\nContent-Transfer-Encoding: base64\nContent-Disposition: attachment; filename=\"$fileName\"\n\n$fileEncoded\n--$boundary--";
    }

    // שליחת המייל
    if (mail($to, $subject, $message, $headers)) {
        echo "<p>ההודעה נשלחה בהצלחה!</p>";
    } else {
        echo "<p>שגיאה בשליחת ההודעה.</p>";
    }
}
?>
