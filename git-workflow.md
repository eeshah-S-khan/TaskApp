Files Tracked

index.php - Main registration form and user list
mail.php - Email validation and PHPMailer integration
composer.json - PHP dependencies
composer.lock - Locked dependency versions
README.md - Project documentation
git-workflow.md - This workflow documentation

Technologies Used

PHP 
MariaDB/MySQL
PHPMailer 6.10.0
Composer
Git
HTML/CSS
Apache Web Server

Git Workflow Steps
1. Repository Initialization
bash# Initialize local repository
git init

# Add remote repository
git remote add origin https://github.com/eeshah-S-khan/TaskApp.git

2. Project Setup
bash# Install PHPMailer via Composer
composer require phpmailer/phpmailer

# Create project files
touch index.php mail.php config.php
3. Development Workflow
Add files to staging area
bashgit add .
# Or add specific files
git add index.php mail.php composer.json composer.lock

Commit changes 

Push changes to remote repository