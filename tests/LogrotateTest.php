<?php

namespace Recca0120\EloquentLogrotate\Tests;

use Mockery as m;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;
use Recca0120\EloquentLogrotate\Logrotate;
use Illuminate\Database\Capsule\Manager as Capsule;

class LogrotateTest extends TestCase
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

    public function testYearlyLogrotate()
    {
        $now = Carbon::now();
        $log = new YearlyLog();
        $logrotateTable = $log->getTable();
        $this->assertSame('yearly_logs_'.$now->format('Y'), $logrotateTable);
        $this->assertSame([
            'id',
            'name',
            'email',
            'password',
            'created_at',
            'updated_at',
        ], Capsule::schema()->getColumnListing($logrotateTable));
    }

    public function testMonthlyLogrotate()
    {
        $now = Carbon::now();
        $log = new MonthlyLog();
        $logrotateTable = $log->getTable();
        $this->assertSame('monthly_logs_'.$now->format('Ym'), $logrotateTable);
        $this->assertSame([
            'id',
            'name',
            'email',
            'password',
            'created_at',
            'updated_at',
        ], Capsule::schema()->getColumnListing($logrotateTable));
    }

    public function testWeeklyLogrotate()
    {
        $now = Carbon::now();
        $log = new WeeklyLog();
        $logrotateTable = $log->getTable();
        $this->assertSame('weekly_logs_'.$now->format('YW'), $logrotateTable);
        $this->assertSame([
            'id',
            'name',
            'email',
            'password',
            'created_at',
            'updated_at',
        ], Capsule::schema()->getColumnListing($logrotateTable));
    }

    public function testDailyLogrotate()
    {
        $now = Carbon::now();
        $log = new DailyLog();
        $logrotateTable = $log->getTable();
        $this->assertSame('daily_logs_'.$now->format('Ymd'), $logrotateTable);
        $this->assertSame([
            'id',
            'name',
            'email',
            'password',
            'created_at',
            'updated_at',
        ], Capsule::schema()->getColumnListing($logrotateTable));
    }

    public function testHourlyLogrotate()
    {
        $now = Carbon::now();
        $log = new HourlyLog();
        $logrotateTable = $log->getTable();
        $this->assertSame('hourly_logs_'.$now->format('YmdH'), $logrotateTable);
        $this->assertSame([
            'id',
            'name',
            'email',
            'password',
            'created_at',
            'updated_at',
        ], Capsule::schema()->getColumnListing($logrotateTable));
    }
}

class YearlyLog extends Model
{
    use Logrotate;

    protected $logrotateType = 'yearly';

    protected function logrotateTableSchema($table)
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
    use Logrotate;

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

class WeeklyLog extends Model
{
    use Logrotate;

    protected $logrotateType = 'weekly';

    protected function logrotateTableSchema($table)
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
    use Logrotate;

    protected $logrotateType = 'daily';

    protected function logrotateTableSchema($table)
    {
        $table->increments('id');
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->timestamps();
    }
}

class HourlyLog extends Model
{
    use Logrotate;

    protected $logrotateType = 'hourly';

    protected function logrotateTableSchema($table)
    {
        $table->increments('id');
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->timestamps();
    }
}

