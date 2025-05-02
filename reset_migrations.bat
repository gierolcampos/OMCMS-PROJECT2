@echo off
echo This script will reset your database and run the new consolidated migrations.
echo All your data will be lost. Make sure you have a backup if needed.
echo.
set /p confirm=Are you sure you want to continue? (y/n): 

if /i "%confirm%" neq "y" (
    echo Operation cancelled.
    exit /b
)

echo.
echo Resetting database...
php artisan migrate:reset

echo.
echo Moving old migrations to backup folder...
move database\migrations\0001_*.php database\migrations_backup\ >nul 2>&1
move database\migrations\2024_05_*.php database\migrations_backup\ >nul 2>&1
move database\migrations\2025_*.php database\migrations_backup\ >nul 2>&1

echo.
echo Running new consolidated migrations...
php artisan migrate

echo.
echo Migration completed successfully!
echo Your database has been reset and the new schema has been applied.
echo.
echo If you need to restore the old migrations, you can find them in the database\migrations_backup folder.
