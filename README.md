# FyreTimer

**FyreTimer** is a free, open-source timer library for *PHP*.


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

**All**

Get all timers.

```php
$timers = Timer::all();
```

**Clear**

Clear all timers.

```php
Timer::clear();
```

**Count**

Get the number of timers.

```php
$timerCount = Timer::count();
```

**Delete**

Delete a timer.

- `$name` is a string representing the timer name.

```php
$deleted = Timer::delete($name);
```

**Elapsed**

Get the elapsed time for a timer.

- `$name` is a string representing the timer name.

```php
$elapsed = Timer::elapsed($name);
```

**Get**

Get a timer.

- `$name` is a string representing the timer name.

```php
$timer = Timer::get($name);
```

**Has**

Check if a timer exists.

- `$name` is a string representing the timer name.

```php
$hasTimer = Timer::has($name);
```

**Is Stopped**

Determine whether a timer is stopped.

- `$name` is a string representing the timer name.

```php
$isStopped = Timer::isStopped($name);
```

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

**Stop All**

Stop all timers.

```php
Timer::stopAll();
```