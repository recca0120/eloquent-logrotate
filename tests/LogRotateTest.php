<?php

namespace Recca0120\LaravelTracy\Tests;

use Mockery as m;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
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
        $this->capsule->setEventDispatcher(new Dispatcher(new Container));
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
        $this->assertSame('logs_'.$now->format('Ymd'), $log->getTable());
    }
}

class Log extends Model
{
    use LogRotate;
}
