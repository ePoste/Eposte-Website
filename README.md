## 📌 Project Overview

ePoste website is a PHP and MySQL-powered web application that enables users to manage and organize their saved digital content in folders. It supports user registration, login/logout, folder creation/editing, post creation/viewing, and folder sharing features. This version focuses solely on a functional and user-friendly web platform.


## Guide To Run

Forking and Cloning the Repository

Fork the Repository

Go to the GitHub page of the ePoste project.

Click the Fork button in the top right corner of the repository page. This creates a copy of the project in your GitHub account.

Clone the Repository to Your Local Machine

git clone https://github.com/yourusername/ePoste.git

Replace yourusername with your GitHub username.

This will create a local copy of the repository where you can begin working.

2. Setting Up the Database Using XAMPP

Download and Install XAMPP

Download XAMPP from here and install it on your local machine.

Start XAMPP

Open the XAMPP Control Panel and start both Apache (for the web server) and MySQL (for the database server). These services will run locally on your machine, enabling the system to interact with both the server and database.

3. Create a Database in phpMyAdmin

Access phpMyAdmin

Open your web browser and go to http://localhost/phpmyadmin/ to access the phpMyAdmin dashboard.

Create a New Database

In the phpMyAdmin dashboard, click on Databases from the top menu.

Under the Create Database section, enter the database name eposte (or any desired name) and click Create to set up the database.

4. Import the SQL File

Once the database (eposte) is created, click on the database name to open it.

In the phpMyAdmin page for the database, click on the Import tab in the top menu.

Under the File to Import section, click Choose File and select the SQL file that contains your database structure and data.

Ensure that SQL is selected as the file format and then click Go to import the database. This will set up the required tables, relationships, and any initial data in the database.

5. Run the program

Open your browser and go to http://localhost/ePoste/login.php (assuming your project is saved in the htdocs folder of XAMPP).

6. Project File Structure and Descriptions

Below is a list of files in the project and their purposes:

EPOSTE-WEBSITE/
│
├── CSS/                           # Contains stylesheets for various pages
│   ├── createPost.css
│   ├── index.css
│   ├── login.css
│   ├── setting.css
│   ├── shareFolder.css
│   └── style.css                 # General/global styles
│
├── Login/                         # (Optional folder - confirm if used for routing or legacy files)
│
├── scripts/                       # JavaScript for UI validation and interaction
│   ├── menu.js
│   ├── password-change-validation.js
│   └── signup-validation.js
│
├── account.php                   # User account settings page
├── connection.php                # MySQL database connection settings
├── createFolder.php              # Page to create new folders
├── createPost.php                # Page to create new posts
├── deleteAccount.php             # Logic to delete a user account
├── deleteFolder.php              # Logic to delete folders
├── deletePost.php                # Logic to delete posts
├── editFolder.php                # Edit existing folder name or description
├── editPost.php                  # Edit existing post details
├── functions.php                 # Common PHP functions (e.g., session handling)
├── getTags.php                   # Retrieves tag suggestions via AJAX
├── index.php                     # Main dashboard; displays folders and posts
├── login.php                     # Login form and authentication logic
├── logout.php                    # Ends the current user session
├── shareFolder.php               # Share folder with other users by email
├── showAllFolder.php             # Displays all folders owned/shared
├── signup.php                    # User registration form and logic
├── viewPost.php                  # Detailed view of an individual post
│
├── Logo/                         # Contains UI assets like logos or icons
│
├── eposte.sql                    # SQL file to set up the database schema and initial data
└── README.md                     # Project documentation and setup guide
```

This structure helps separate presentation (CSS), logic (PHP), and data (MySQL) cleanly. All files must be placed inside the `htdocs/ePoste` directory to work properly with XAMPP.
```
## Known Issues / Limitations

- Users cannot upload images or media content with posts.
- No email verification is implemented for account creation.
- No mobile responsiveness yet (web layout is desktop-focused).

## Transition to Production Environment

To prepare ePoste for deployment in a live/production environment:

1. **Use a Hosting Provider**
   - Choose a PHP-compatible hosting service (e.g., Hostinger, Bluehost, or DigitalOcean).
   - Ensure support for MySQL or MariaDB.

2. **Migrate Files**
   - Upload the entire project directory (`EPOSTE-WEBSITE`) to your host’s `public_html/` or root directory via FTP or cPanel File Manager.

3. **Configure Database**
   - Create a new MySQL database from your hosting control panel.
   - Import the `eposte.sql` file using phpMyAdmin.
   - Update the `connection.php` file to match your production database credentials.

4. **Secure the System**
   - Enable HTTPS with an SSL certificate.
   - Add `.htaccess` rules to block access to sensitive files.
   - Use environment variables or an external config file for DB credentials.

5. **Optional Enhancements**
   - Enable email functionality for future password resets or sharing confirmations.
   - Add a responsive layout using CSS media queries or frameworks like Bootstrap.

## Testing the Installation

After completing the setup (local or production), follow these steps to test core functionality:

1. **Login and Registration**
   - Navigate to `login.php` and `signup.php` to test login and account creation.
   - Use test credentials or create a new account.

2. **Dashboard Display**
   - After login, you should see the folder dashboard (index.php).
   - Test folder creation (`createFolder.php`) and check that it appears in the dashboard.

3. **Post Creation**
   - Use `createPost.php` to create a post within a folder.
   - Confirm the post appears inside the folder view.

4. **Folder Management**
   - Edit or delete folders using `editFolder.php` and `deleteFolder.php`.

5. **Post Management**
   - Edit or delete posts using `editPost.php` and `deletePost.php`.

6. **Folder Sharing**
   - Use `shareFolder.php` to test sharing functionality by entering a valid user email.

7. **Logout**
   - Use `logout.php` to terminate the session.

8. **Database Validation**
   - Open phpMyAdmin to verify that data is correctly inserted into the `folders`, `posts`, and `users` tables.

If any page returns a blank screen, check:
- XAMPP's Apache and MySQL status
- `connection.php` for DB settings
- Browser developer console for JS or PHP errors

