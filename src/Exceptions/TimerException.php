<?php
declare(strict_types=1);

namespace Fyre\Utility\Exceptions;

use RuntimeException;

/**
 * TimerException
 */
class TimerException extends RuntimeException
{

    public static function forInvalidTimer(string $name)
    {
        return new static('Invalid timer: '.$name);
    }

    public static function forTimerAlreadyStarted(string $name)
    {
        return new static('Timer already started: '.$name);
    }

    public static function forTimerAlreadyStopped(string $name)
    {
        return new static('Timer already stopped: '.$name);
    }

}
