<?php

namespace Recca0120\LaravelTracy\Tests;

use Mockery as m;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Model;
use Recca0120\EloquentLogRotate\LogRotate;

class LogRotateTest extends TestCase
{
    protected function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    public function testLogRotateDaily()
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
