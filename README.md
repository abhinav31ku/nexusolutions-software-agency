```text
======================================================================================================================
NEXUSOLUTIONS  -  SOFTWARE AGENCY WEBSITE
======================================================================================================================

  A website for a small software agency, developed as a college project. Visitors can explore services, create an
  account, submit project inquiries and complete a demo payment by scanning a QR code. An admin dashboard allows
  administrators to manage clients, view inquiries and update their status.

  Built with: HTML, CSS, JavaScript, PHP (no framework) and MySQL / MariaDB


----------------------------------------------------------------------------------------------------------------------
  TEAM
----------------------------------------------------------------------------------------------------------------------

  FRONTEND
    - Abhinav Kumar ........................ 2025KUEC2015
    - Yogesh ............................... 2025KUEC2014
    - Kanika Chaudhary ..................... 2025KUEC2018

  DATABASE AND BACKEND
    - Vansh Jain ........................... 2025KUEC2016
    - Aaditya Raj Sharma ................... 2025KUEC2017
    - Anurag Rathore ....................... 2025KUEC2013


----------------------------------------------------------------------------------------------------------------------
  FEATURES
----------------------------------------------------------------------------------------------------------------------

  * Home, Services, About, Projects and Contact pages
  * Projects page with category filters
  * User registration and login using username or email
  * Secure password storage using bcrypt password hashing
  * PHP session-based authentication
  * CSRF protection for forms
  * Login protection: 5 failed attempts result in a 10-minute lockout
  * Project inquiry system with four services
  * Inquiry message limit of 2,000 characters
  * Maximum of 3 unpaid inquiries per user
  * Demo QR payment system with automatic payment status updates
  * Client dashboard to view inquiries, amounts, statuses and payment details
  * Pay Now option for unpaid inquiries
  * Admin dashboard with statistics and inquiry management
  * Admin client management and inquiry status updates
  * Inquiry cannot be marked Completed unless payment is received
  * Responsive design and user-friendly interface


----------------------------------------------------------------------------------------------------------------------
  HOW TO RUN  (Windows + XAMPP)
----------------------------------------------------------------------------------------------------------------------

  1. Copy the project folder to:
     C:\xampp\htdocs\software_agency_project

  2. Open XAMPP Control Panel and start Apache and MySQL.

  3. Copy config/config.example.php to config/config.php.

  4. Update the database credentials in config/config.php if required.
     Default XAMPP credentials (root with no password) work locally.

  5. Open phpMyAdmin:
     http://localhost/phpmyadmin

  6. Import database/schema.sql.
     This creates the nexusolutions_db database and required tables.

  7. Open the website:
     http://localhost/software_agency_project/public/

  NOTE:
  If you already have an existing database, back it up first and run
  database/migration.sql instead of importing schema.sql.


----------------------------------------------------------------------------------------------------------------------
  LOGIN DETAILS
----------------------------------------------------------------------------------------------------------------------

  ADMIN
    Username : admin
    Password : ChangeMe#2026

  CLIENT
    Register your own account from the website.
    Login using your username or email and your chosen password.

  IMPORTANT:
  The admin password is temporary. Change it after the first login.
  There is currently no change-password page.

  To generate a new password hash using PHP:

    php -r "echo password_hash('your new password', PASSWORD_DEFAULT);"

  Update the admin password in the database:

    UPDATE users SET password = 'paste the hash here' WHERE username = 'admin';


----------------------------------------------------------------------------------------------------------------------
  TRYING THE QR PAYMENT  (DEMO)
----------------------------------------------------------------------------------------------------------------------

  1. Register a client account and log in.

  2. Submit a project inquiry using one of the available services.

  3. Open the payment page generated for the inquiry.

  4. Scan the QR code using a phone connected to the SAME Wi-Fi
     network as the computer.

  5. Complete the demo payment by tapping "Pay now" on the phone.

  6. The computer payment page automatically updates to show
     "Payment received".

  7. Log in as admin to view the inquiry and its updated payment status.

  NOTE:
  This is a demo payment system. No real money is transferred.

  To test payment using a phone:
  Update BASE_URL in config/config.php to your computer's
  local network IP address, for example:

     http://192.168.1.5/software_agency_project

  If the phone cannot access the website, allow Apache through
  Windows Firewall on Private networks.


----------------------------------------------------------------------------------------------------------------------
  FOLDER STRUCTURE
----------------------------------------------------------------------------------------------------------------------

  software_agency_project/
  |
  |-- config/
  |   |-- config.php              (local configuration, not in Git)
  |   |-- config.example.php       (configuration template)
  |
  |-- includes/
  |   |-- db.php                  (database connection)
  |   |-- session.php              (session management)
  |   |-- auth.php                 (authentication and CSRF)
  |   |-- pricing.php              (inquiry pricing)
  |   |-- inquiries.php             (inquiry operations)
  |   |-- header.php
  |   |-- footer.php
  |
  |-- public/                      (website pages)
  |
  |-- admin/                       (admin dashboard and management)
  |
  |-- assets/
  |   |-- css/
  |   |-- js/
  |   |-- img/
  |
  |-- database/
  |   |-- schema.sql
  |   |-- migration.sql
  |
  |-- docs/
  |   |-- screenshots/
  |
  |-- LICENSE
  |-- README.md


----------------------------------------------------------------------------------------------------------------------
  IMPORTANT NOTES
----------------------------------------------------------------------------------------------------------------------

  * PHP runs through Apache. Do not open PHP files directly in the browser.
  * config/config.php contains local database configuration and should not be committed.
  * Passwords are stored using bcrypt password hashing.
  * The admin account should use a strong password.
  * Demo payments do not involve real money or a payment gateway.
  * Real payments require integration with a payment gateway such as Razorpay.
  * Screenshots in docs/screenshots/ belong to the older website design
    and should be updated for the current version.
  * This is a learning project released under the MIT License.

======================================================================================================================
```
