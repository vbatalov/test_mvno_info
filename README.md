# ТЗ

Миросервис перемещения баланса с одной сим на другую

## from: @mvno_info

### Postman

Documentation: https://documenter.getpostman.com/view/31594466/2sAXjQ1A6U

### Start

1. Clone this repo
2. `composer install`
3. `cp .env.example` .env && `php artisan key:generate`
4. `php artisan migrate --seed`
5. `php artisan serve`

### Правила валидации

```php
[
    "simid_from" => [
        "required", "integer", "min_digits:6",
    ],
    "simid_to" => [
        "required", "integer", "min_digits:6",
    ],
    "sum" => [
        "required", "decimal:2,10",
    ],
    "comment" => [
        "required", "string"
    ]
]
```
