## Requirement

-   [Laravel](https://laravel.com/)
-   [Postman](https://www.postman.com/)
-   [Mysql](https://www.mysql.com/)

## Project Setup

```sh
# clone it
git clone https://github.com/akilsagitarius/akil-nobi.git

cd akil-nobi

# Install dependencies
composer install

# Copy Env file
cp .env.example .env

# Generate key
php artisan key:generate

# Run migrations
php artisan migrate || 
(jika tidak menggunakan migration import dari file nobitest.sql)



# Run seeder
php artisan db:seed

# Optimize
php artisan optimize

```

## Project Run

```sh
# Run the project
php artisan serve

```

## List Endpoints

1. API to add a new user

```bash
[POST] /api/v1/user/add
```

example input

```bash
{
    "name" : "Muhammad Akil",
    "username" : "akil"
}
```

2. API to get all user

```bash
[GET] /api/v1/ib/member
```

3. API to update total balance

```bash
[POST] /api/v1/ib/updateTotalBalance
```

example input

```bash
{
    "current_balance" : 2800000
}
```

4. API to get all NAB

```bash
[GET] /api/v1/ib/listNAB
```

5. API to deposit balance

```bash
[POST] /api/v1/ib/topup
```

example input

```bash
{
    "user_id" : "1",
    "amount_rupiah" : 50000
}
```

6. API to withdraw balance

```bash
[POST] /api/v1/ib/withdraw
```

example input

```bash
{
    "user_id" : "1",
    "amount_rupiah" : 1000
}
```
