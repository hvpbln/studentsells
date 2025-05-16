# StudentSells
Final project for CTAPDEVL - **Applications Development and Emerging Technologies**

## Setup Instructions
Follow these steps to set up the project locally:
1. Start your local server:
- Open XAMPP and start Apache and MySQL.

2. Create the database:
- Go to http://localhost/phpmyadmin
- Create a new database named 'studentsells'

3. Configure environment settings:
- Open the .env file in the project root
- Update the database connection settings to match your local MySQL credentials
  (e.g. DB_DATABASE=studentsells, DB_USERNAME=root, DB_PASSWORD=yourpassword)

4. Install dependencies and setup Laravel:
- Open your command prompt in the project folder and run:
    - composer install (downloads all required PHP packages)
    - php artisan key:generate (generates the app key used for security)
    - php artisan migrate (creates all the database tables)
