# FyreTimer

**FyreTimer** is a free, timer library for *PHP*.


## Table Of Contents
- [Installation](#installation)
- [Methods](#methods)



## Installation

**Using Composer**

```
composer require fyre/timer
```

In PHP:

```php
use Fyre\Utility\Timer;
```


## Methods

**Clear**

Clear all timers.

```php
Timer::clear();
```

**Exists**

Check if a timer exists.

- `$name` is a string representing the timer name.

```php
$exists = Timer::exists($name);
```

**Get Elapsed**

Get the elapsed time for a timer.

- `$name` is a string representing the timer name.

```php
$elapsed = Timer::getElapsed($name);
```

This method will automatically stop the timer if it has not already been stopped.

**Get Timers**

Get all timers.

```php
$timers = Timer::getTimers();
```

This method will automatically stop all timers if they have not already been stopped.

**Start**

Start a timer.

- `$name` is a string representing the timer name.

```php
Timer::start($name);
```

**Stop**

Stop a timer.

- `$name` is a string representing the timer name.

```php
Timer::stop($name);
```