# שלב 1: משיכת דימוי של Apache עם תמיכה ב-PHP
FROM php:7.4-apache

# שלב 2: העתקת כל הקבצים של הפרויקט לתיקייה בשרת
COPY . /var/www/html/

# שלב 3: מתן הרשאות לשרת Apache לגשת לקבצים
RUN chown -R www-data:www-data /var/www/html

# הפעלת השרת Apache
CMD ["apache2-foreground"]
