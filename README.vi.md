# Like Laravel Nova but I'm Rookie

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nguyentranchung/rookie.svg?style=flat-square)](https://packagist.org/packages/nguyentranchung/rookie)
[![Build Status](https://img.shields.io/travis/nguyentranchung/rookie/master.svg?style=flat-square)](https://travis-ci.org/nguyentranchung/rookie)
[![Quality Score](https://img.shields.io/scrutinizer/g/nguyentranchung/rookie.svg?style=flat-square)](https://scrutinizer-ci.com/g/nguyentranchung/rookie)
[![Total Downloads](https://img.shields.io/packagist/dt/nguyentranchung/rookie.svg?style=flat-square)](https://packagist.org/packages/nguyentranchung/rookie)

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what PSRs you support to avoid any confusion with users and contributors.

## Installation

You can install the package via composer:

```bash
composer require nguyentranchung/rookie
```

Publish config
```bash
php artisan vendor:publish --provider=NguyenTranChung\Rookie\RookieServiceProvider
```

## Usage

Tạo files UserRookie.php trong thư mục app\Rookies
``` php
<?php

namespace App\Rookies;

use App\User;
use NguyenTranChung\Rookie\Fields\Field;
use NguyenTranChung\Rookie\Fields\HasMany;
use NguyenTranChung\Rookie\Rookie;

class UserRookie extends Rookie
{
    protected string $modelClass = User::class;
    protected string $title = 'name';

    /**
     * @inheritDoc
     */
    public function fields()
    {
        return [
            Field::make(User::ID),
            Field::make(User::NAME)
                ->filter()
                ->sortable(),
            Field::make(User::EMAIL)
                ->filter()
                ->sortable(),
            HasMany::make(User::POSTS, PostRookie::class)
                ->showCountOnly(),
            Field::make(User::CREATED_AT)
                ->setValue(fn(User $model) => $model->created_at->diffForHumans()),
        ];
    }
}
```

Sau đó thêm vào trong config\rookie.php
```php
<?php

return [
    // ...
    'rookies' => [
        'users' => App\Rookies\UserRookie::class,
    ],
];
```

Mở trình duyệt truy cập http://localhost:8000/rookies/users

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email nguyentranchung52th@gmail.com instead of using the issue tracker.

## Credits

- [Nguyen Tran Chung](https://github.com/nguyentranchung)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
