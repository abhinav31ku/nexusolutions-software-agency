======================================================================================================================
  NEXUSOLUTIONS  -  SOFTWARE AGENCY WEBSITE
======================================================================================================================

  A beginner-friendly website for a small software agency. Visitors can browse the services, create an account, send a
  project inquiry and
  pay for it by scanning a QR code (demo). An admin dashboard shows every inquiry and lets the admin update its
  status.

  Built with: HTML, CSS, JavaScript, PHP and MySQL (no frameworks)


----------------------------------------------------------------------------------------------------------------------
  TEAM
----------------------------------------------------------------------------------------------------------------------

  FRONTEND
    - Abhinav Kumar ....................... 2025KUEC2015
    - Rajpurohit Yogesh Kumar ............. 2025KUEC2014
    - Kanika Chaudhary .................... 2025KUEC2018

  DATABASE AND BACKEND
    - Vansh Jain .......................... 2025KUEC2016
    - Aaditya Raj Sharma .................. 2025KUEC2017
    - Anurag Rathore ...................... 2025KUEC2013


----------------------------------------------------------------------------------------------------------------------
  FEATURES
----------------------------------------------------------------------------------------------------------------------

  * 5 pages: Home, Services, About, Projects and Login, with project category filters (Websites, Software, Mobile)
  * Register and log in with a username OR an email, using PHP sessions
  * Inquiry forms for Web Development, Logo Design and Video Editing, plus a general contact form
  * Demo QR payment: scan with a phone, tap "Pay now", and the computer page updates by itself
  * Admin dashboard: totals, inquiry table, status control (Pending / In Progress / Completed) and a payment column
  * Form validation, show/hide password, friendly error messages and a mobile menu


----------------------------------------------------------------------------------------------------------------------
  HOW TO RUN  (Windows + XAMPP)
----------------------------------------------------------------------------------------------------------------------

  1. Copy this folder to  C:\xampp\htdocs\software_agency_project
  2. Open XAMPP Control Panel and click Start next to Apache and MySQL (both turn green).
  3. Open http://localhost/phpmyadmin, click "New" and create a database named  nexusolutions_db
  4. Select nexusolutions_db, open the "Import" tab and import  database/software_agency.sql
  5. Open the "SQL" tab, paste the contents of  database/add_payment.sql  and click "Go"  (run this only once).
  6. Open the website:  http://localhost/software_agency_project/frontend/

  NOTE: Always open the site through http://localhost. Double-clicking the HTML files will not run the PHP code.


----------------------------------------------------------------------------------------------------------------------
  LOGIN DETAILS
----------------------------------------------------------------------------------------------------------------------

  ADMIN     username or email : admin   or   admin@nexusolutions.com
            password          : admin123

  CLIENT    Register your own account from the Login page, then log in with your username or your email.


----------------------------------------------------------------------------------------------------------------------
  TRYING THE QR PAYMENT  (DEMO)
----------------------------------------------------------------------------------------------------------------------

  1. Log in as a client and submit an inquiry. A payment page with a QR code opens.
  2. Scan the QR with a phone on the SAME Wi-Fi as the computer, then tap "Pay now".
  3. The computer page shows "Payment received" by itself.
  4. Log in as admin: the inquiry now shows Paid and In Progress.

  If the phone cannot open the link, allow Apache through Windows Firewall (Private networks),
  or open the link shown under the QR code.

  This is a demo only. No real money is used. Real payments need a payment gateway such as Razorpay.


----------------------------------------------------------------------------------------------------------------------
  FOLDER STRUCTURE
----------------------------------------------------------------------------------------------------------------------

  software_agency_project/
  |-- backend/     admin.php, db.php
  |-- frontend/    HTML pages, PHP pages, css/, js/, images/, includes/
  |-- database/    software_agency.sql, add_payment.sql
  |-- docs/        screenshots


----------------------------------------------------------------------------------------------------------------------
  CHANGES TO THE ORIGINAL BACKEND
----------------------------------------------------------------------------------------------------------------------

  * frontend/login.php: the query is now "WHERE username = ? OR email = ?" so the login form can use an email.
  * logo.php, webdev.php, videoediting.php, contact.php and backend/admin.php were extended for the payment feature.


----------------------------------------------------------------------------------------------------------------------
  IMPORTANT NOTES
----------------------------------------------------------------------------------------------------------------------

  * backend/db.php uses MySQL root with no password (XAMPP default). Fine for local practice only.
  * The admin password admin123 is stored in plain text in the SQL file. Hash it before any real use.
  * This is a learning project, released under the MIT License.

======================================================================================================================
