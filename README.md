Laravel Project
A comprehensive web application built with Laravel framework.
Requirements

PHP >= 8.1
Composer
Node.js & NPM
MySQL/MariaDB
Git

Installation
Follow these steps to set up the project locally:
1. Clone the repository
git clone https://github.com/yourusername/your-repository.git
cd your-repository
2. Install PHP dependencies
composer install
3. Install JavaScript dependencies
npm install
4. Configure environment variables
cp .env.example .env
Edit the .env file and configure your database settings:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
5. Generate application key
php artisan key:generate
6. Run database migrations and seeders
php artisan migrate
php artisan db:seed
Running the Application
Development server
Run the Laravel development server:
php artisan serve
The application will be accessible at http://localhost:8000
Compile assets for development
To compile assets in development mode and enable hot-reloading:
npm run dev
Compile assets for production
npm run build
Testing
Run tests with the following command:
php artisan test
Deployment
1. Configure production environment
Ensure your production environment variables are properly set in the .env file on your server.
2. Optimize for production
Run the following commands:
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
3. Database migrations
Run migrations on the production server:
php artisan migrate --force
Common Issues and Solutions
Permission Issues
If you encounter permission issues, run the following commands:
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
Clearing Cache
If you need to clear all caches:
php artisan optimize:clear
Contributing
Please read the CONTRIBUTING.md file for details on our code of conduct and the process for submitting pull requests.
License
This project is licensed under the MIT License - see the LICENSE file for details.
