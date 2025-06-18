# StudentSells

Final project for **CTAPDEVL - Applications Development and Emerging Technologies**

## Project Description

**StudentSells** is a full-stack Laravel web application designed as a marketplace platform exclusively for students. It allows users to buy, sell, and post requests for items within their academic community. The system includes a robust set of features for user management, listings, wishlist creation, messaging, ratings, and admin moderation.

---

## Video Demonstration

Watch the video here: [link]

---

## Requirements

Make sure the following tools and technologies are installed before running the project:

- **PHP** 8.4.5
- **Composer**
- **Laravel** 12.14.1
- **MySQL** (for database)
- **XAMPP** (for running Apache & MySQL)

---

## Installation & Setup Instructions

Follow these steps to set up the project on your local machine:

### 1. Start your local server

- Open **XAMPP** and start both **Apache** and **MySQL**.

### 2. Create the database

- Go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
- Create a new database named:
```
studentsells
```

### 3. Configure environment settings

- In the root directory of the project, duplicate `.env.example` and rename it to `.env`
- Open the `.env` file and configure your DB settings:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=studentsells
DB_USERNAME=root         # or your local db username
DB_PASSWORD=             # or your db password if any
```

### 4. Install dependencies and set up Laravel

- Open your terminal in the project folder and run:
```
composer install          # Install PHP dependencies
php artisan key:generate  # Generate app key
php artisan migrate       # Create database tables
```

### 5. Collaborating on migrations

- If someone changes a migration, make sure everyone pulls the updated code by running:
```
php artisan migrate:rollback  # Undo previous migrations
php artisan migrate           # Apply new migrations
```

### 6. Create an admin account (for local testing)
- In the command line at the root directory of the project, run:
```
php artisan tinker
```
- Then in Tinker, run:
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

### 7. Set up storage for profile images

```
php artisan storage:link
```

### 8. Launch the Laravel server
```
php artisan serve
```
