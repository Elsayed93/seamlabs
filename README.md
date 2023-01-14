## SeamLabs Task

Simple Tasks consist of two parts: 
- The first part is consist of three problem to solve 
- Second part is consist of APIs
    - Register 
    - Login 
    - List, Show, Update and Delete User Model 



## Steps for running project

### 1- Clone the project

```
git clone https://github.com/Elsayed93/pharmacies-products.git
```

<p>If you want SSL </p>

```
git clone git@github.com:Elsayed93/pharmacies-products.git
```

<br>

### 2- Make sure you are in the project directory and composer install

```
composer install
```

### 3- copy .env-example file and rename the copied file .env

### 4- Create Database and fill database credentials in .env file

### 5- Run migrate command

### 6- Generate App Key

```
cp .env-example .env

php artisan migrate

php artisan key:generate
```

### 7- Run the server

```
php artisan serve
```