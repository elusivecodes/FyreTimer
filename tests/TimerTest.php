<?php
declare(strict_types=1);

namespace Tests;

use
    Fyre\Utility\Timer,
    PHPUnit\Framework\TestCase,
    RunTimeException;

use function
    usleep;

final class TimerTest extends TestCase
{

    public function testStartStop(): void
    {
        Timer::start('test');
        usleep(500000);
        Timer::stop('test');

        $timers = Timer::getTimers();

        $this->assertCount(1, $timers);
        $this->assertArrayHasKey('test', $timers);
        $this->assertArrayHasKey('start', $timers['test']);
        $this->assertArrayHasKey('end', $timers['test']);

        $this->assertArrayHasKey('duration', $timers['test']);
        $this->assertGreaterThan(.5, $timers['test']['duration']);
    }

    public function testStartStopConcurrent(): void
    {
        Timer::start('test1');
        usleep(500000);
        Timer::start('test2');
        usleep(500000);
        Timer::stop('test1');
        Timer::stop('test2');

        $timers = Timer::getTimers();

        $this->assertCount(2, $timers);
        $this->assertGreaterThan(1, $timers['test1']['duration']);
        $this->assertGreaterThan(.5, $timers['test2']['duration']);
    }

    public function testStartAutoStop(): void
    {
        Timer::start('test');
        usleep(500000);

        $timers = Timer::getTimers();

        $this->assertArrayHasKey('duration', $timers['test']);
        $this->assertGreaterThan(.5, $timers['test']['duration']);
    }

    public function testStopNotStarted(): void
    {
        $this->expectException(RunTimeException::class);

        Timer::stop('test');
    }

    public function testGetElapsed(): void
    {
        Timer::start('test');
        usleep(500000);

        $timers = Timer::getTimers();

        $this->assertEquals($timers['test']['duration'], Timer::getElapsed('test'));
    }

    public function testGetElapsedNotStarted(): void
    {
        $this->assertNull(
            Timer::getElapsed('test')
        );
    }

    public function testStartAlreadyStarted(): void
    {
        Timer::start('test');
        usleep(500000);
        Timer::start('test');

        $this->assertGreaterThan(.5, Timer::getElapsed('test'));
    }

    public function testExistsTrue(): void
    {
        Timer::start('test');

        $this->assertTrue(
            Timer::exists('test')
        );
    }

    public function testExistsFalse(): void
    {
        $this->assertFalse(
            Timer::exists('test')
        );
    }

    protected function setUp(): void
    {
        Timer::clear();
    }

}
