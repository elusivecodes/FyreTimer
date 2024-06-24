<?php
declare(strict_types=1);

namespace Tests;

use Fyre\Utility\Exceptions\TimerException;
use Fyre\Utility\Timer;
use PHPUnit\Framework\TestCase;

use function usleep;

final class TimerTest extends TestCase
{
    protected function setUp(): void
    {
        Timer::clear();
    }

    public function testCount(): void
    {
        Timer::start('test1');
        Timer::start('test2');

        $this->assertSame(2, Timer::count());
    }

    public function testElapsed(): void
    {
        Timer::start('test');
        usleep(500000);
        $elapsed1 = Timer::elapsed('test');
        usleep(500000);
        $elapsed2 = Timer::elapsed('test');

        $this->assertIsFloat($elapsed1);
        $this->assertIsFloat($elapsed2);
        $this->assertGreaterThan($elapsed1, $elapsed2);
        $this->assertFalse(Timer::isStopped('test'));
    }

    public function testElapsedInvalid(): void
    {
        $this->expectException(TimerException::class);

        Timer::elapsed('test');
    }

    public function testGet(): void
    {
        Timer::start('test');

        $timer = Timer::get('test');

        $this->assertArrayHasKey('start', $timer);
        $this->assertArrayHasKey('end', $timer);
        $this->assertArrayHasKey('duration', $timer);
        $this->assertIsFloat($timer['start']);
        $this->assertNull($timer['end']);
        $this->assertNull($timer['duration']);
    }

    public function testGetInvalid(): void
    {
        $this->assertNull(Timer::get('test'));
    }

    public function testHasFalse(): void
    {
        $this->assertFalse(Timer::has('test'));
    }

    public function testHasTrue(): void
    {
        Timer::start('test');

        $this->assertTrue(Timer::has('test'));
    }

    public function testIsStoppedFalse(): void
    {
        Timer::start('test');

        $this->assertFalse(Timer::isStopped('test'));
    }

    public function testIsStoppedInvalid(): void
    {
        $this->expectException(TimerException::class);

        Timer::isStopped('test');
    }

    public function testIsStoppedTrue(): void
    {
        Timer::start('test');
        Timer::stop('test');

        $this->assertTrue(Timer::isStopped('test'));
    }

    public function testRemove(): void
    {
        Timer::start('test');

        $this->assertTrue(Timer::remove('test'));
        $this->assertFalse(Timer::has('test'));
    }

    public function testRemoveInvalid(): void
    {
        $this->assertFalse(Timer::remove('test'));
    }

    public function testStart(): void
    {
        $this->expectNotToPerformAssertions();

        Timer::start('test');
    }

    public function testStartMultiple(): void
    {
        $this->expectException(TimerException::class);

        Timer::start('test');
        Timer::start('test');
    }

    public function testStop(): void
    {
        Timer::start('test');
        Timer::stop('test');

        $timer = Timer::get('test');

        $this->assertArrayHasKey('start', $timer);
        $this->assertArrayHasKey('end', $timer);
        $this->assertArrayHasKey('duration', $timer);
        $this->assertIsFloat($timer['start']);
        $this->assertIsFloat($timer['end']);
        $this->assertIsFloat($timer['duration']);
    }

    public function testStopAll(): void
    {
        Timer::start('test1');
        Timer::start('test2');
        Timer::stopAll();

        $timers = Timer::all();

        $this->assertIsArray($timers);
        $this->assertCount(2, $timers);
        $this->assertArrayHasKey('test1', $timers);
        $this->assertArrayHasKey('test2', $timers);
        $this->assertSame(Timer::get('test1'), $timers['test1']);
        $this->assertSame(Timer::get('test2'), $timers['test2']);
    }

    public function testStopAllMultiple(): void
    {
        Timer::start('test1');
        Timer::start('test2');
        Timer::stopAll();

        $timers = Timer::all();

        usleep(500000);
        Timer::stopAll();

        $this->assertSame($timers, Timer::all());
    }

    public function testStopInvalid(): void
    {
        $this->expectException(TimerException::class);

        Timer::stop('test');
    }

    public function testStopMultiple(): void
    {
        $this->expectException(TimerException::class);

        Timer::start('test');
        Timer::stop('test');
        Timer::stop('test');
    }
}
