@echo off
setlocal

:: Change to the directory where your Laravel project is located
cd /d D:\WEB_PROJECTS\hris

:: Activate the virtual environment if you are using one
:: Replace "venv" with the name of your virtual environment if needed
:: Uncomment the next line if you are using a virtual environment
:: call venv\Scripts\activate.bat

:: Run Laravel's scheduler worker in the background
start "" /B php artisan schedule:work

:: Run php artisan schedule:list every minute
:loop
php artisan schedule:list
timeout /t 60 >NUL
goto loop