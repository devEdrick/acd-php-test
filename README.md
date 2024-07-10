# Call Log Application
## Introduction
This web application is designed to manage a call log.

## Prerequisites
Before you begin, ensure you have the following installed:
- PHP 8.2 or higher
- MySQL 8 or compatible database
- Composer

## Installation
Follow these steps to set up the project on your local machine:

### Clone the Repository
```bash
git clone https://github.com/devEdrick/acd-php-test.git
cd acd-php-test
```

### Install Dependencies
Install the necessary PHP dependencies:
```bash
composer install
```

### Configure Environment
Copy the example environment file and set up your environment variables:
```bash
cp .env.example .env
```

### Import Database Dump
```bash
mysql -u username -p call_logs_db < dbdump.sql
```

### Serve the Application
Run the following commands in separate terminal windows to serve the website:

```bash
php -S localhost:8000 -t public
```

## Usage
### Web Interface
The web interface is accessible at:
```bash
http://localhost:8000  
```

The following functionalities are available:

- Get Call Headers
- Create Call Header
- Edit Call Header
- Delete Call Header
- Show Call Header and Call Details
- Create Call Detail
- Edit Call Detail
- Delete Call Detail

