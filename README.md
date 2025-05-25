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
- (If you don't already have it, duplicate the .env.example file and rename it to '.env'.
- Update the database connection settings to match your local MySQL credentials
- This is what it should look like:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=studentsells
DB_USERNAME=root or your db username
DB_PASSWORD= _blank_ or your db password
``` 

4. Install dependencies and setup Laravel:
- Open your command prompt in the project folder and run:
    - `composer install` (downloads all required PHP packages)
    - `php artisan key:generate` (generates the app key used for security)
    - `php artisan session:table` (creates a migration file for the sessions table)
    - `php artisan migrate` (creates all the database tables)

5. If may babaguhin kayo sa migrations, tell exeryone so all of us can
    - pull changes in code
    - `php artisan migrate:rollback` (to delete the former migrations)
    - `php artisan migrate` (to migrate the new set)

6. To manually create an admin account in your local environment, run the following command in your terminal:

```
php artisan tinker
```
Then enter the following code in Tinker:
```
use App\Models\User;

User::create([
    'name' => 'Admin',
    'email' => 'admin@gmail.com',
    'password' => bcrypt('admin123'),
    'role' => 'admin',
    'status' => 'active',
]);
``` 
