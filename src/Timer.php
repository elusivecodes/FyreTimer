<?php
declare(strict_types=1);

namespace Fyre;

use
    RunTimeException;

use function
    array_key_exists,
    array_map,
    microtime,
    strtolower;

/**
 * Timer
 */
class Timer
{

    protected static array $timers = [];

    /**
     * Clear all timers.
     */
    public static function clear(): void
    {
        static::$timers = [];
    }

    /**
     * Check if a timer exists.
     * @param string $name The timer name.
     * @return bool TRUE if the timer exists, otherwise FALSE.
     */
    public static function exists(string $name): bool
    {
        $name = static::formatKey($name);

        return array_key_exists($name, static::$timers);
    }

    /**
     * Get the elapsed time for a timer.
     * @param string $name The timer name.
     * @return float|null The elapsed time.
     */
    public static function getElapsed(string $name): float|null
    {
        $name = static::formatKey($name);

		if (!array_key_exists($name, static::$timers)) {
			return null;
		}

        static::$timers[$name]['end'] ??= static::now();

        $timer = static::$timers[$name];

        return $timer['end'] - $timer['start'];
    }

    /**
     * Get all timers.
     * @return array The timers.
     */
    public static function getTimers(): array
    {
        foreach (static::$timers AS &$timer) {
            $timer['end'] ??= static::now();
        }

        return array_map(
            function($timer) {
                $timer['duration'] = $timer['end'] - $timer['start'];
                return $timer;
            },
            static::$timers
        );
    }

    /**
     * Start a timer.
     * @param string $name The timer name.
     */
    public static function start(string $name): void
    {
        $name = static::formatKey($name);

        static::$timers[$name] ??= [
            'start' => static::now(),
            'end' => null
        ];
    }

    /**
     * Stop a timer.
     * @param string $name The timer name.
     * @throws RunTimeException if the timer is invalid.
     */
    public static function stop(string $name): void
    {
        $name = static::formatKey($name);

        if (!array_key_exists($name, static::$timers)) {
            throw new RunTimeException('Invalid timer: '.$name);
        }

		static::$timers[$name]['end'] ??= static::now();
    }

    /**
     * Format a timer key.
     * @param string $name The timer name.
     * @return string The timer key.
     */
    protected static function formatKey(string $name): string
    {
        return strtolower($name);
    }

    /**
     * Get the current UTC timestamp with microseconds.
     * @return float The current UTC timestamp with microseconds.
     */
    protected static function now(): float
    {
        return microtime(true);
    }

}
