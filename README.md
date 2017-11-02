# Entity

laravel scaffold generator

# Feature

- Design table fields and indexes
- Manage model relations
- Make field validations
- Define model factories
- Configure controller middlewares

# Requirement

- Laravel 5
- Vue 2
- Axios
- Bootstrap 3

Make sure you have the following files:

- public/css/bootstrap.min.css
- public/js/es6-promise.auto.min.js
- public/js/axios.min.js
- public/js/vue.js

If you don't have these files, you can get them from `src\Scaffold\public`

# Installation

1. Via composer

```bash
composer require googee/entity:dev-master --dev
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

![model](https://github.com/GooGee/Entity/raw/master/screenshot/model.png)

![controller](https://github.com/GooGee/Entity/raw/master/screenshot/controller.png)
