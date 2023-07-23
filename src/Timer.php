<?php
declare(strict_types=1);

namespace Fyre\Utility;

use Fyre\Utility\Exceptions\TimerException;

use function array_key_exists;
use function count;
use function hrtime;

/**
 * Timer
 */
class Timer
{

    protected static array $timers = [];

    /**
     * Get all timers.
     * @return array The timers.
     */
    public static function all(): array
    {
        return static::$timers;
    }

    /**
     * Clear all timers.
     */
    public static function clear(): void
    {
        static::$timers = [];
    }

    /**
     * Get the number of timers.
     * @return int The number of timers.
     */
    public static function count(): int
    {
        return count(static::$timers);
    }

    /**
     * Get the elapsed time for a timer.
     * @param string $name The timer name.
     * @return float The elapsed time.
     */
    public static function elapsed(string $name): float
    {
		if (!static::has($name)) {
            throw TimerException::forInvalidTimer($name);
		}

        return hrtime(true) - static::$timers[$name]['start'];
    }

    /**
     * Get a timer.
     * @param string $name The timer name.
     * @return array|null The timer data.
     */
    public static function get(string $name): array|null
    {
        return static::$timers[$name] ?? null;
    }

    /**
     * Determine whether a timer exists.
     * @param string $name The timer name.
     * @return bool TRUE if the timer exists, otherwise FALSE.
     */
    public static function has(string $name): bool
    {
        return array_key_exists($name, static::$timers);
    }

    /**
     * Determine whether a timer is stopped.
     * @param string $name The timer name.
     * @return bool TRUE if the timer is stopped, otherwise FALSE.
     */
    public static function isStopped(string $name): bool
    {
		if (!static::has($name)) {
            throw TimerException::forInvalidTimer($name);
        }

        return static::$timers[$name]['end'] !== null;
    }

    /**
     * Remove a timer.
     * @param string $name The timer name.
     * @return bool TRUE if the timer was removed, otherwise FALSE.
     */
    public static function remove(string $name): bool
    {
		if (!static::has($name)) {
            return false;
        }

        unset(static::$timers[$name]);

        return true;
    }

    /**
     * Start a timer.
     * @param string $name The timer name.
     */
    public static function start(string $name): void
    {
		if (static::has($name)) {
            throw TimerException::forTimerAlreadyStarted($name);
        }

        static::$timers[$name] = [
            'start' => hrtime(true) / 1000,
            'end' => null,
            'duration' => null
        ];
    }

    /**
     * Stop a timer.
     * @param string $name The timer name.
     */
    public static function stop(string $name): void
    {
        if (static::isStopped($name)) {
            throw TimerException::forTimerAlreadyStopped($name);
        }

        $timer = static::$timers[$name];

		$timer['end'] = hrtime(true) / 1000;
        $timer['duration'] = $timer['end'] - $timer['start'];

        static::$timers[$name] = $timer;
    }

    /**
     * Stop all timers.
     */
    public static function stopAll(): void
    {
        foreach (static::$timers AS $name => $timer) {
            if ($timer['end'] !== null) {
                continue;
            }

            $timer['end'] = hrtime(true) / 1000;
            $timer['duration'] = $timer['end'] - $timer['start'];

            static::$timers[$name] = $timer;
        }
    }

}
