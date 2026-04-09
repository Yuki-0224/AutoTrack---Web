@echo off
REM ============================================================
REM AutoTrack Payment Fix - Windows Batch Script
REM ============================================================
REM Simply double-click this file to run the fix!
REM 
REM This script will:
REM 1. Navigate to the project directory
REM 2. Run the PHP fix script
REM 3. Keep the window open so you can see the results
REM ============================================================

echo.
echo ╔════════════════════════════════════════════════════════════╗
echo ║          AutoTrack Payment Records Fixer                   ║
echo ╚════════════════════════════════════════════════════════════╝
echo.

REM Change to the project directory
cd /d "C:\Users\princ\OneDrive\Desktop\ACADS\Xampp\htdocs\DriveSys\AutoTrack---Web\AutoTrack"

if errorlevel 1 (
    echo ❌ ERROR: Could not find the project directory!
    echo    Check that the path is correct in this script.
    pause
    exit /b 1
)

echo ✅ Found project directory
echo.
echo 📌 Running payment fix script...
echo.

REM Run the PHP script
php fix_payments_cli.php

if errorlevel 1 (
    echo.
    echo ❌ ERROR: PHP script failed!
    echo    Make sure:
    echo    1. PHP is installed
    echo    2. MySQL is running
    echo    3. The 'web' database exists
    pause
    exit /b 1
)

echo.
echo ✅ All done!
echo.
echo 📋 Next steps:
echo    1. Go to Dashboard: http://localhost:3040/dashboard
echo    2. Click View on any reservation
echo    3. Check that "Amount Paid" shows the correct amount
echo.
pause
