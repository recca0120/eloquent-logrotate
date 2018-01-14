<?php

namespace Recca0120\LaravelTracy\Tests;

use Mockery as m;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;
use Recca0120\EloquentLogRotate\LogRotate;
use Illuminate\Database\Capsule\Manager as Capsule;

class LogRotateTest extends TestCase
{
    private $capsule;

    protected function setUp()
    {
        parent::setUp();
        $this->capsule = new Capsule;
        $this->capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
    }

    protected function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    public function testYearlyLogRotate()
    {
        $now = Carbon::now();
        $log = new YearlyLog();
        $logRotateTable = $log->getTable();
        $this->assertSame('yearly_logs_'.$now->format('Y'), $logRotateTable);
        $this->assertSame([
            'id',
            'name',
            'email',
            'password',
            'created_at',
            'updated_at',
        ], Capsule::schema()->getColumnListing($logRotateTable));
    }

    public function testMonthlyLogRotate()
    {
        $now = Carbon::now();
        $log = new MonthlyLog();
        $logRotateTable = $log->getTable();
        $this->assertSame('monthly_logs_'.$now->format('Ym'), $logRotateTable);
        $this->assertSame([
            'id',
            'name',
            'email',
            'password',
            'created_at',
            'updated_at',
        ], Capsule::schema()->getColumnListing($logRotateTable));
    }

    public function testDailyLogRotate()
    {
        $now = Carbon::now();
        $log = new DailyLog();
        $logRotateTable = $log->getTable();
        $this->assertSame('daily_logs_'.$now->format('Ymd'), $logRotateTable);
        $this->assertSame([
            'id',
            'name',
            'email',
            'password',
            'created_at',
            'updated_at',
        ], Capsule::schema()->getColumnListing($logRotateTable));
    }
}

class YearlyLog extends Model
{
    use LogRotate;

    protected $logRotate = 'yearly';

    protected function createLogRotateTable($table)
    {
        $table->increments('id');
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->timestamps();
    }
}

class MonthlyLog extends Model
{
    use LogRotate;

    protected $logRotate = 'monthly';

    protected function createLogRotateTable($table)
    {
        $table->increments('id');
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->timestamps();
    }
}

class DailyLog extends Model
{
    use LogRotate;

    protected $logRotate = 'daily';

    protected function createLogRotateTable($table)
    {
        $table->increments('id');
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->timestamps();
    }
}
