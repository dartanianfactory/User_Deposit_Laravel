### USER BALANCE TRANSFER - TEST PROJECT

#### Тестовый админ
```
email: testing_admin@mail.ru
password: 123123
```

#### Тестовый клиент
```
email: testing_customer@mail.ru
password: 123123
```

```
docker compose up --build
docker exec -it bank_php bash
---->php artisan migrate:fresh
---->php artisan db:seed 
---->exit
```

```
POST http://localhost:3030/api/user/login
{
    email,
    password,
}

GET http://localhost:3030/api/user/bank/balance/{id}
{}

POST http://localhost:3030/api/user/bank/deposit
{
    to_user_id,
    amount,
    comment,
}

POST http://localhost:3030/api/user/bank/withdraw
{
    from_user_id,
    amount,
    comment,
}

POST http://localhost:3030/api/user/bank/transfer
{
    from_user_id,
    to_user_id,
    amount,
    comment,
}
```