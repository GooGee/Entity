# Entity

laravel scaffold generator

# Feature

- Design tables
- Manage model relations
- Configure controller middlewares

# Installation

1. Via composer

```bash
composer require googee/entity:dev-master --dev
```

2. Add the service provider in `config/app.php`:

```php
GooGee\Entity\EntityServiceProvider::class,
```

3. Run artisan

```bash
php artisan vendor:publish --provider="GooGee\Entity\EntityServiceProvider"
```

4. Visit http://localhost/entity

# ScreenShot

![table](https://github.com/GooGee/Entity/raw/master/screenshot/table.png)

![model](https://github.com/GooGee/Entity/raw/master/screenshot/model.png)

![controller](https://github.com/GooGee/Entity/raw/master/screenshot/controller.png)
