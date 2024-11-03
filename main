<!DOCTYPE html>
<html lang="he">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>טופס שליחת בעיה</title>
</head>
<body>

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
        echo "<p>ההודעה נשלחה בהצלחה!</p>";
    } else {
        echo "<p>שגיאה בשליחת ההודעה.</p>";
    }
}
?>

<h1>טופס שליחת בעיה</h1>
<form action="" method="post" enctype="multipart/form-data">
    <label for="firstName">שם פרטי:</label>
    <input type="text" id="firstName" name="firstName" required><br><br>

    <label for="lastName">שם משפחה:</label>
    <input type="text" id="lastName" name="lastName" required><br><br>

    <label for="email">אימייל:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="phone">טלפון משרדי:</label>
    <input type="tel" id="phone" name="phone"><br><br>

    <label for="issue">הסבר הבעיה:</label>
    <textarea id="issue" name="issue" required></textarea><br><br>

    <label for="attachment">צרף תמונה:</label>
    <input type="file" id="attachment" name="attachment" accept="image/*"><br><br>

    <button type="submit">שלח</button>
</form>

</body>
</html>
