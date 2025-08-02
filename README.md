# WeOwl Laravel Project

A school management system built with Laravel that matches the design and functionality of the original WeOwl project.

## Features

- **Dark Theme Design**: Matches the original WeOwl project's dark theme with Bootstrap 5
- **Multi-User Authentication**: Separate login systems for Managers, Parents, Teachers, and Vice Managers
- **Responsive Design**: Works on desktop and mobile devices
- **Modern UI**: Clean and intuitive user interface

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL/MariaDB
- Node.js and NPM (for asset compilation)

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd weowl-laravel
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Copy environment file**
   ```bash
   cp .env.example .env
   ```

5. **Configure your database in `.env`**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=weowl_laravel
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Generate application key**
   ```bash
   php artisan key:generate
   ```

7. **Run database migrations**
   ```bash
   php artisan migrate
   ```

8. **Seed the database with sample data**
   ```bash
   php artisan db:seed
   ```

9. **Compile assets**
   ```bash
   npm run build
   ```

## Running the Application

1. **Start the development server**
   ```bash
   php artisan serve
   ```

2. **Open your browser and navigate to**
   ```
   http://localhost:8000
   ```

## Sample Login Credentials

After running the database seeder, you can use these credentials to test the application:

### Manager
- Email: `manager@weowl.com`
- Password: `password123`

### Parent
- Email: `parent@weowl.com`
- Password: `password123`

### Teacher
- Email: `teacher@weowl.com`
- Password: `password123`

### Vice Manager
- Email: `vice@weowl.com`
- Password: `password123`

## Project Structure

```
weowl-laravel/
├── app/
│   ├── Http/Controllers/    # Controllers for different user types
│   └── Models/             # Eloquent models
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/           # Database seeders
├── resources/
│   └── views/
│       ├── layouts/        # Layout templates
│       ├── manager/        # Manager views
│       ├── parent/         # Parent views
│       ├── teacher/        # Teacher views
│       └── vice/           # Vice manager views
├── public/
│   └── css/               # Compiled CSS files
└── routes/
    └── web.php            # Web routes
```

## Features Implemented

- ✅ Landing page with WeOwl design
- ✅ Manager authentication and dashboard
- ✅ Parent authentication and dashboard
- ✅ Teacher authentication and dashboard
- ✅ Vice Manager authentication and dashboard
- ✅ Dark theme with Bootstrap 5
- ✅ Responsive navigation
- ✅ User-specific headers and layouts

## Next Steps

To complete the full WeOwl functionality, you would need to implement:

- Student management
- Attendance tracking
- Grade management
- Communication features
- Notification system
- File uploads
- Advanced reporting

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## License

This project is licensed under the MIT License.
