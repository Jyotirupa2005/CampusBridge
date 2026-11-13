CAMPUSBRIDGE - ONLINE COLLEGE ADMISSION PORTAL
Technology: PHP 8+, MySQL, HTML, CSS, JavaScript

FEATURES
- Responsive public homepage
- Student registration and login (passwords hashed)
- Student dashboard and application history
- Admission application form with academic and personal details
- Optional marksheet upload (PDF/JPG/PNG, max 2 MB)
- Admin login and application review
- Admin can update status (Pending / Approved / Rejected) and add a note
- CSRF token checks and PDO prepared statements

REQUIREMENTS
- XAMPP (Apache + MySQL) or equivalent PHP/MySQL server
- PHP 8.0+ recommended; PDO MySQL and Fileinfo extensions enabled

INSTALLATION USING XAMPP
1. Extract the CampusBridge folder into: C:\xampp\htdocs\
2. Start Apache and MySQL from XAMPP Control Panel.
3. Open http://localhost/phpmyadmin
4. Choose Import and import the file: CampusBridge/database.sql
   (The SQL creates the campusbridge database and its tables.)
5. Check config.php. Default XAMPP settings are usually:
   DB_HOST = localhost, DB_NAME = campusbridge, DB_USER = root, DB_PASS = ''
   BASE_URL = /CampusBridge
6. Open http://localhost/CampusBridge/
7. Register a student account and submit a test application.

CREATE AN ADMIN ACCOUNT (IMPORTANT)
For safety, the website does not provide public admin registration.
1. Register a normal account through the website.
2. Open phpMyAdmin > campusbridge > SQL.
3. Run this query, replacing the email with the account you registered:
   UPDATE users SET role='admin' WHERE email='your-admin-email@example.com';
4. Log out. Open http://localhost/CampusBridge/admin/login.php
5. Log in with the same email and password.

TEST CHECKLIST
- Register a new student.
- Log in as student.
- Submit an application and optionally upload a PDF/JPG/PNG under 2 MB.
- Confirm the application appears on the student dashboard as Pending.
- Promote a separate account to admin using the SQL above.
- Log in at /admin/login.php, update the application status and add a note.
- Return to the student dashboard and confirm the status/note is visible.

NOTES
- This is a student project/demo application, not an official university admission service.
- Use sample data only. Do not upload sensitive identity documents.
- For a public production deployment, configure HTTPS, secure cookie settings,
  server-side rate limiting, email verification, backups, stronger upload scanning,
  privacy/legal notices and institution-specific admission rules.
- The demo does not process payments or connect to a real college/university.
