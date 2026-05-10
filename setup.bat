@echo off
echo ============================================================
echo   JobPortal Pro - Setup Script
echo ============================================================
echo.

REM Check if PHP is available
php -v >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR] PHP is not found in your PATH.
    echo Please install Laragon, XAMPP, or add PHP to your PATH.
    echo Download Laragon: https://laragon.org/download/
    pause
    exit /b 1
)

echo [1/6] Installing Composer dependencies...
call composer install --no-interaction --prefer-dist
if %errorlevel% neq 0 (
    echo [ERROR] Composer install failed. Make sure Composer is installed.
    pause
    exit /b 1
)

echo.
echo [2/6] Copying .env file...
if not exist .env (
    copy .env.example .env
    echo .env file created from .env.example
    echo IMPORTANT: Edit .env and set your DB_DATABASE, DB_USERNAME, DB_PASSWORD
) else (
    echo .env already exists, skipping.
)

echo.
echo [3/6] Generating application key...
php artisan key:generate

echo.
echo [4/6] Running database migrations...
php artisan migrate --force
if %errorlevel% neq 0 (
    echo [ERROR] Migration failed. Check your .env database credentials.
    pause
    exit /b 1
)

echo.
echo [5/6] Seeding database (admin + categories)...
php artisan db:seed --force

echo.
echo [6/6] Creating storage symlink...
php artisan storage:link

echo.
echo ============================================================
echo   Setup complete!
echo ============================================================
echo.
echo   Admin Login:   /admin/login
echo   Company Login: /company/login
echo   User Login:    /login/user
echo.
echo   Default Admin: (check AdminSeeder for credentials)
echo.
echo   Start server with: php artisan serve
echo   Then visit:        http://localhost:8000
echo.
pause
