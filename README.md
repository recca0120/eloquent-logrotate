# Eloquent Logrotate

[![StyleCI](https://styleci.io/repos/40661503/shield?style=flat)](https://styleci.io/repos/40661503)
[![Build Status](https://travis-ci.org/recca0120/eloquent-logrotate.svg)](https://travis-ci.org/recca0120/eloquent-logrotate)
[![Total Downloads](https://poser.pugx.org/recca0120/eloquent-logrotate/d/total.svg)](https://packagist.org/packages/recca0120/eloquent-logrotate)
[![Latest Stable Version](https://poser.pugx.org/recca0120/eloquent-logrotate/v/stable.svg)](https://packagist.org/packages/recca0120/eloquent-logrotate)
[![Latest Unstable Version](https://poser.pugx.org/recca0120/eloquent-logrotate/v/unstable.svg)](https://packagist.org/packages/recca0120/eloquent-logrotate)
[![License](https://poser.pugx.org/recca0120/eloquent-logrotate/license.svg)](https://packagist.org/packages/recca0120/eloquent-logrotate)
[![Monthly Downloads](https://poser.pugx.org/recca0120/eloquent-logrotate/d/monthly)](https://packagist.org/packages/recca0120/eloquent-logrotate)
[![Daily Downloads](https://poser.pugx.org/recca0120/eloquent-logrotate/d/daily)](https://packagist.org/packages/recca0120/eloquent-logrotate)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/recca0120/eloquent-logrotate/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/recca0120/eloquent-logrotate/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/recca0120/eloquent-logrotate/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/recca0120/eloquent-logrotate/?branch=master)

## INSTALL

```bash
composer require recca0120/eloquent-logrotate
```

## HOW TO USE

### define model

```php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Recca0120\EloquentLogrotate\Logrotate;

class MonthlyLog extends Model
{
    use Logrotate;

    /**
     * $logrotateType: hourly, daily, weekly, monthly, yearly
     */
    protected $logrotateType = 'monthly';

    protected function logrotateTableSchema($table)
    {
        $table->increments('id');
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->timestamps();
    }
}
```

it will create database by monthly
