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

    public function testLogRotate()
    {
        $now = Carbon::now();
        $log = new Log();
        $logRotateTable = $log->getTable();
        $this->assertSame('logs_'.$now->format('Ymd'), $logRotateTable);
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

class Log extends Model
{
    use LogRotate;

    protected function createLogRotateTable($table)
    {
        $table->increments('id');
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->timestamps();
    }
}
