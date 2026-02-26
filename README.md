# Disease Analytics Optimization Test

## Project Overview
Build a file upload system that read though the attached CSV and inserts the content as individual items into a table using Laravel jobs/queue.


### Setup & Installation
### Prerequisites
#### PHP 8+
#### Laravel 12
#### MySQL 
#### Composer

Installation Steps

Clone the repository:
```
git clone git@github.com:Enigmatec/mhn_take_home_test.git

cd mhn_take_home_test
```

Install dependencies: 
```
composer install
```
Set up environment variables:  
```
cp .env.example .env

```
Generate Key: 
```
php artisan key:generate
```
Update .env file: 
Set up database credential and mail credentials

Run database migrations: 
```
php artisan migrate

```
Open Tinker: 
```
php artisan tinker

```
Run Factories
```
OrderItem::factory()->count(100)->create()

```
Start the application: 
```
php artisan serve
```
## Available Endpoints
Import Endpoint: To import csv file for processing 
```
{baseUrl}/api/import-diseases : POST
```
Summary Report Endpoint: To get the summary report of the uploaded file
```
{baseUrl}/api/summary-reports/:id : Post
```
