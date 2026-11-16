
# CampusBridge – Online College Admission Portal

## Project Overview
CampusBridge is an online college admission portal developed to simplify the college admission process. It allows students to create accounts, submit admission applications, upload academic documents and track their application status. Administrators can review applications and update their status.

## Key Features

### Student Module
- Student registration and login.
- Student dashboard.
- Online admission application form.
- Personal and academic information submission.
- Optional marksheet upload (PDF, JPG, PNG).
- View application history.
- Track application status (Pending, Approved, Rejected).

### Administrator Module
- Administrator registration and login.
- Admin dashboard.
- View student applications.
- Review submitted academic details.
- Approve or reject applications.
- Add notes and update application status.

## Technologies Used
- Frontend: HTML, CSS, JavaScript
- Backend: PHP
- Database: MySQL
- Local Server: XAMPP
- Database Management: phpMyAdmin

## System Requirements
- Windows or Linux operating system
- XAMPP with PHP 8.0 or above
- MySQL
- Web browser (Chrome, Firefox, etc.)
- Visual Studio Code (optional)

## Installation and Setup

### Step 1: Install XAMPP
Download and install XAMPP on your computer.

### Step 2: Copy Project Folder
Copy the CampusBridge project folder into:

`C:\xampp\htdocs\`

### Step 3: Start Server
Open XAMPP Control Panel and start:
- Apache
- MySQL

### Step 4: Create Database
1. Open `http://localhost/phpmyadmin`
2. Create a database named `campusbridge` if it does not already exist.
3. Select the database.
4. Open the Import option.
5. Choose the `database.sql` file from the project folder.
6. Click Import.

### Step 5: Configure Database
Open `config.php` and check the database settings:

- DB_HOST: localhost
- DB_NAME: campusbridge
- DB_USER: root
- DB_PASS: (empty for default XAMPP setup)

### Step 6: Run the Project
Open your browser and visit:

`http://localhost/CampusBridge/`

The CampusBridge homepage will appear.

## Account Access

**Student Account:**
- Open the registration page.
- Select Student.
- Create an account and log in.
- Submit an admission application.

**Administrator Account:**
- Select Administrator during registration.
- Enter the configured Admin Registration Key.
- Create an account and log in through the Admin Login option.
- Review applications and update their status.

## Database Structure
The project uses a MySQL database named `campusbridge`.

Main tables:
- `users` – Stores student and administrator account details.
- `applications` – Stores admission application information and status.

## Project Structure

- `admin/` – Administrator pages
- `assets/css/` – CSS stylesheet
- `assets/js/` – JavaScript files
- `includes/` – Common header and footer files
- `student/` – Student dashboard and application pages
- `uploads/` – Uploaded documents
- `config.php` – Database configuration
- `database.sql` – Database file
- `index.php` – Homepage
- `login.php` – Login page
- `register.php` – Registration page
- `logout.php` – Logout functionality

## Project Purpose
This project was developed as part of the Full Stack Development Project at Educare Skill Academy.

**Note:** CampusBridge is a demonstration project and is not connected to any official college or university admission system. Use sample data for testing.
