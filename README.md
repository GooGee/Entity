# Entity

laravel scaffold generator

# Feature

- Design table fields and indexes
- Define model factories
- Manage model relations
- Make field validations
- Configure controller middleware
- Create Bootstrap forms

# Requirement

- Laravel 5
- Vue 2

# Installation

1. Via composer

```bash
composer require googee/entity --dev
```

2. Add the service provider in `config/app.php`:

```php
GooGee\Entity\EntityServiceProvider::class,
```

3. Publish asset

```bash
php artisan vendor:publish --provider="GooGee\Entity\EntityServiceProvider"
```

4. Visit http://localhost/entity

# ScreenShot

![table](https://github.com/GooGee/Entity/raw/master/screenshot/table.png)

![seed](https://github.com/GooGee/Entity/raw/master/screenshot/seed.png)

![model](https://github.com/GooGee/Entity/raw/master/screenshot/model.png)
