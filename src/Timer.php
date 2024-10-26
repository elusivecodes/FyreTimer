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
    protected array $timers = [];

    /**
     * Get all timers.
     *
     * @return array The timers.
     */
    public function all(): array
    {
        return $this->timers;
    }

    /**
     * Clear all timers.
     */
    public function clear(): void
    {
        $this->timers = [];
    }

    /**
     * Get the number of timers.
     *
     * @return int The number of timers.
     */
    public function count(): int
    {
        return count($this->timers);
    }

    /**
     * Get the elapsed time for a timer.
     *
     * @param string $name The timer name.
     * @return float The elapsed time.
     *
     * @throws TimerException if the timer is not valid.
     */
    public function elapsed(string $name): float
    {
        if (!array_key_exists($name, $this->timers)) {
            throw TimerException::forInvalidTimer($name);
        }

        return hrtime(true) - $this->timers[$name]['start'];
    }

    /**
     * Get a timer.
     *
     * @param string $name The timer name.
     * @return array|null The timer data.
     */
    public function get(string $name): array|null
    {
        return $this->timers[$name] ?? null;
    }

    /**
     * Determine whether a timer exists.
     *
     * @param string $name The timer name.
     * @return bool TRUE if the timer exists, otherwise FALSE.
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->timers);
    }

    /**
     * Determine whether a timer is stopped.
     *
     * @param string $name The timer name.
     * @return bool TRUE if the timer is stopped, otherwise FALSE.
     *
     * @throws TimerException if the timer is not valid.
     */
    public function isStopped(string $name): bool
    {
        if (!array_key_exists($name, $this->timers)) {
            throw TimerException::forInvalidTimer($name);
        }

        return $this->timers[$name]['end'] !== null;
    }

    /**
     * Remove a timer.
     *
     * @param string $name The timer name.
     * @return static The Timer.
     *
     * @throws TimerException if the timer is already stopped.
     */
    public function remove(string $name): static
    {
        if (!array_key_exists($name, $this->timers)) {
            throw TimerException::forInvalidTimer($name);
        }

        unset($this->timers[$name]);

        return $this;
    }

    /**
     * Start a timer.
     *
     * @param string $name The timer name.
     * @return static The Timer.
     *
     * @throws TimerException if the timer is already started.
     */
    public function start(string $name): static
    {
        if (array_key_exists($name, $this->timers)) {
            throw TimerException::forTimerAlreadyStarted($name);
        }

        $this->timers[$name] = [
            'start' => hrtime(true) / 1000,
            'end' => null,
            'duration' => null,
        ];

        return $this;
    }

    /**
     * Stop a timer.
     *
     * @param string $name The timer name.
     * @return static The Timer.
     *
     * @throws TimerException if the timer is already stopped.
     */
    public function stop(string $name): static
    {
        if (!array_key_exists($name, $this->timers)) {
            throw TimerException::forInvalidTimer($name);
        }

        if ($this->timers[$name]['end'] !== null) {
            throw TimerException::forTimerAlreadyStopped($name);
        }

        $timer = $this->timers[$name];

        $timer['end'] = hrtime(true) / 1000;
        $timer['duration'] = $timer['end'] - $timer['start'];

        $this->timers[$name] = $timer;

        return $this;
    }

    /**
     * Stop all timers.
     *
     * @return static The Timer.
     */
    public function stopAll(): static
    {
        foreach ($this->timers as $name => $timer) {
            if ($timer['end'] !== null) {
                continue;
            }

            $timer['end'] = hrtime(true) / 1000;
            $timer['duration'] = $timer['end'] - $timer['start'];

            $this->timers[$name] = $timer;
        }

        return $this;
    }
}
