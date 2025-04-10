Guide To Run

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

5. Testing the Login Functionality 

Test the Login Page 

Open your browser and go to http://localhost/ePoste/login.php (assuming your project is saved in the htdocs folder of XAMPP). 

Test the login functionality to ensure the authentication process works as expected. 

For example, ensure that when you enter correct user credentials, you can log in successfully. 

If invalid credentials are entered, the login process should reject them and prompt the user with an error message. 

Finsih later
