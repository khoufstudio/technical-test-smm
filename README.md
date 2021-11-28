# Technical Test SMM

## About
This is a simple web application that’s made by Laravel 8 and VueJS. 


## Database Schema
<details>
    
Table: customers
    
| Field       | Type                | Null | Key | Extra          |
|-------------|---------------------|------|-----|----------------|
| id          | bigint(20) unsigned | NO   | PRI | auto_increment |
| name        | varchar(255)        | NO   |     |                |
| departement | varchar(255)        | NO   |     |                |
| nik         | varchar(255)        | NO   | UNI |                |
| created_at  | timestamp           | YES  |     |                |
| updated_at  | timestamp           | YES  |     |                |


Table: products
    
| Field        | Type                | Null | Key | Extra          |    
|--------------|---------------------|------|-----|----------------|
| id           | bigint(20) unsigned | NO   | PRI | auto_increment |
| product_code | varchar(255)        | NO   |     |                |
| name         | varchar(255)        | NO   |     |                |
| location     | varchar(255)        | NO   |     |                |
| stock        | int(11)             | NO   |     |                |
| packaging    | varchar(255)        | NO   |     |                |
| created_at   | timestamp           | YES  |     |                |
| updated_at   | timestamp           | YES  |     |                |
    
Table: product_requests
    
| Field                | Type                | Null | Key | Extra          |    
|----------------------|---------------------|------|-----|----------------|
| id                   | bigint(20) unsigned | NO   | PRI | auto_increment |
| customer_id          | bigint(20) unsigned | NO   | MUL |                |
| date_product_request | date                | NO   |     |                |
| created_at           | timestamp           | YES  |     |                |
| updated_at           | timestamp           | YES  |     |                |
| packaging            | varchar(255)        | NO   |     |                |
| created_at           | timestamp           | YES  |     |                |
| updated_at           | timestamp           | YES  |     |                |
    
Table: product_request_lists
    
| Field                    | Type                        | Null | Key            | Extra          |    
|--------------------------|-----------------------------|------|----------------|----------------|
| id                       | bigint(20) unsigned NO      | PRI  | auto_increment | auto_increment |
| product_request_id       | bigint(20) unsigned NO      | MUL  | MUL            |                |
| product_id               | bigint(20) unsigned YES MUL | NO   |                |                |
| quantity                 | int(11) NO                  | YES  |                |                |
| description varchar(255) | NO                          | YES  |                |                |
| created_at               | timestamp YES               | NO   |                |                |
| updated_at               | timestamp YES               | YES  |                |                |
| updated_at               | timestamp                   | YES  |                |                |

</details>

## ERD 
![image](https://user-images.githubusercontent.com/35180419/143762770-28570439-6e6e-492e-a143-33541b6f04ee.png)


## Requirement Installation
- Minimum PHP 7.4 (required)
- MySQL 5.7 
- Composer 2.1.8 
- NodeJS 12.18.4
- NPM 6.14.6

### Installation
- git clone https://github.com/khoufstudio/technical-test-smm.git
- cd technical-test-smm
- composer install
- cp .env.example .env
- Update `.env` and set your database credentials
- php artisan key:generate
- php artisan migrate
- php artisan db:seed
- npm install 

## Running Application
- php artisan serve
- npm run watch
