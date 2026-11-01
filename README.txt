Nexusolutions - Software Agency (HTML/CSS/JS frontend + PHP/MySQL backend)

SETUP (XAMPP)
1. Copy this folder to C:\xampp\htdocs\software_agency_project
2. Start Apache and MySQL. In phpMyAdmin create database "nexusolutions_db", then import database/software_agency.sql
3. Open http://localhost/software_agency_project/frontend/
4. Login with admin / admin123 (or any account you register). You can log in with username or email.

CHANGES TO YOUR BACKEND
- frontend/login.php: the query is now "WHERE username = ? OR email = ?" so the login form can use an email. Nothing else was changed.

NOTES
- Open pages through http://localhost, not by double-clicking the files.
- backend/db.php uses root with no password (XAMPP default). admin123 is plaintext in the SQL file; hash it before real use.

DEMO PAYMENT (QR CODE)
1. After importing software_agency.sql, open phpMyAdmin > nexusolutions_db > SQL tab, paste database/add_payment.sql and click Go (run it once).
2. Log in, submit an inquiry. A payment page with a QR code opens.
3. Scan it with a phone on the SAME Wi-Fi, tap "Pay now". The laptop page updates by itself and the inquiry becomes "In Progress".
4. If the phone can't open the link, allow Apache through Windows Firewall (Private networks), or open the link shown under the QR code.
This is a demo: no real money is used. Real payments need a payment gateway such as Razorpay.
