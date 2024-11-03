from flask import Flask, request, render_template_string
from flask_mail import Mail, Message
import os

app = Flask(__name__)

# הגדרות של Flask-Mail
app.config['MAIL_SERVER'] = 'smtp.office365.com'
app.config['MAIL_PORT'] = 587
app.config['MAIL_USE_TLS'] = True
app.config['MAIL_USERNAME'] = os.environ.get('EMAIL_USER')  # הכנס את האימייל שלך
app.config['MAIL_PASSWORD'] = os.environ.get('EMAIL_PASS')  # הכנס את הסיסמא שלך
app.config['MAIL_DEFAULT_SENDER'] = os.environ.get('EMAIL_USER')  # הכנס את האימייל שלך

mail = Mail(app)

# HTML של הטופס
form_html = '''
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>טופס פנייה</title>
</head>
<body>
    <h1>טופס פנייה</h1>
    <form method="post">
        <label for="first_name">שם פרטי:</label>
        <input type="text" id="first_name" name="first_name" required><br><br>
        
        <label for="last_name">שם משפחה:</label>
        <input type="text" id="last_name" name="last_name" required><br><br>
        
        <label for="email">אימייל:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="phone">טלפון במשרד:</label>
        <input type="text" id="phone" name="phone" required><br><br>
        
        <label for="issue">תיאור בעיה:</label><br>
        <textarea id="issue" name="issue" required></textarea><br><br>
        
        <input type="submit" value="שלח">
    </form>
</body>
</html>
'''

@app.route('/', methods=['GET', 'POST'])
def index():
    if request.method == 'POST':
        first_name = request.form['first_name']
        last_name = request.form['last_name']
        email = request.form['email']
        phone = request.form['phone']
        issue = request.form['issue']

        # הכנת ההודעה
        msg = Message('פנייה חדשה',
                      recipients=['your_email@example.com'])  # הכנס את האימייל שלך
        msg.body = f'''
        שם פרטי: {first_name}
        שם משפחה: {last_name}
        אימייל: {email}
        טלפון במשרד: {phone}
        תיאור בעיה: {issue}
        '''
        mail.send(msg)
        return '<h1>הפנייה נשלחה בהצלחה!</h1>'

    return render_template_string(form_html)

if __name__ == '__main__':
    app.run(debug=True)
