# Laravel Application System Updater

A powerful and automated system for keeping your Laravel applications up-to-date. Easily update your application's files, database schema, and codebase with a single, streamlined process.

**Key Features:**

- **Effortless Updates:**
    - Upload a compressed ZIP file containing the latest version of your application.
    - The system automatically extracts and replaces files in their correct locations.
- **Automated Database Migrations:**
    - Seamlessly execute database migrations to synchronize your database schema with the updated application.
- **Codebase Synchronization:**
    - Effortlessly update all your application's code files to the latest version.
- **Configuration Backups:**
    - Create backups of your existing configuration files before the update process begins.
    - Easily revert to previous configurations if needed.
- **User-Friendly Interface:**
    - An intuitive and easy-to-use interface makes the update process a breeze for all users.
- **Enhanced Security:**
    - Ensure your application is always protected with the latest security patches and updates.

**Benefits:**

- **Save Time:**
    - Eliminate the need for manual file copying and database migrations.
- **Reduce Errors:**
    - Minimize human error by automating the update process.
- **Streamlined Workflow:**
    - Simplify the application update process for developers and system administrators.
- **Improved Security:**
    - Maintain the highest level of security for your application by keeping it up-to-date.

---

### **1. Environment Requirements**

To use this package, the Laravel application and server environment must meet the following criteria:

#### **Server Requirements:**

- **PHP Version**: `^8.0`
- **Extensions**:
    - `zip` (For working with zip files)
    - `mbstring` (String operations)
    - `openssl` (Encryption/decryption)
    - `pdo` (Database operations)
    - `json` (Handling JSON)

#### **Laravel Version:**

- Laravel `^9.0` or higher (compatible with PHP 8.0)
- Ensure that your `storage` directory is properly linked in a Laravel application
  
## **Installation**

### **1. Require the Package**

Run the following Composer command:

```bash 
composer require jobayer/laravel-application-system-updater
```

### **2. Publish Configuration and Views**

Publish the configuration file and views for customization:

```bash 
php artisan vendor:publish --tag=views
```

### **3. Register the Service Provider**

If you're using Laravel 5.5 or later, the package will automatically register itself. For older versions, manually register the service provider in `config/app.php`:

```php
'providers' => [Jobayer\LaravelAppUpdater\ServiceProvider::class,],
```

---

## **Usage**

### **1. Uploading and Extracting Updates**

Use the following routes to handle updates:

```php
use Jobayer\LaravelAppUpdater\Http\Controllers\UpdaterController;
Route::get('/system-updater', [UpdaterController::class, 'index']);
Route::post('/system-updater', [UpdaterController::class, 'processUpdate']);
```

---
##  **Workflow**

###### 1. File Upload & Extraction

- Upload a `.zip` file with updates.
- Extract files to the correct directories in the Laravel application.
- Replace existing files and add new ones.

###### 2. Database Update

- Make sure `database/update-schema.sql` database is present.
- Execute custom SQL queries if provided in the zip.

###### 3. Logging

- Log all update actions (successes, errors, changes).

###### 4. Version Control

- Track the current application version and compare with the zip's version.
- Ensure compatibility between the current app version and updates.

###### 5. Security & Permissions

- Validate uploaded zip files for authenticity.
- Ensure proper file permissions for security.

---

## **Contributing**

Contributions are welcome! If you'd like to add features, fix bugs, or improve documentation, feel free to fork the repository and submit a pull request.

---

## **License**

This package is open-sourced software licensed under the MIT license.

---

## **Support**

If you encounter issues or have questions, please create an issue on the [GitHub Repository](https://github.com/mdabdullajobayer/Laravel-Application-System-Updater).
