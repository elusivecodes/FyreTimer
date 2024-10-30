# FyreTimer

**FyreTimer** is a free, open-source timer library for *PHP*.


## Table Of Contents
- [Installation](#installation)
- [Basic Usage](#basic-usage)
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


## Basic Usage

```php
$timer = new Timer();
```


## Methods

**All**

Get all timers.

```php
$timers = $timer->all();
```

**Clear**

Clear all timers.

```php
$timer->clear();
```

**Count**

Get the number of timers.

```php
$count = $timer->count();
```

**Elapsed**

Get the elapsed time for a timer.

- `$name` is a string representing the timer name.

```php
$elapsed = $timer->elapsed($name);
```

**Get**

Get a timer.

- `$name` is a string representing the timer name.

```php
$data = $timer->get($name);
```

**Has**

Check if a timer exists.

- `$name` is a string representing the timer name.

```php
$hasTimer = $timer->has($name);
```

**Is Stopped**

Determine whether a timer is stopped.

- `$name` is a string representing the timer name.

```php
$isStopped = $timer->isStopped($name);
```

**Remove**

Remove a timer.

- `$name` is a string representing the timer name.

```php
$timer->remove($name);
```

**Start**

Start a timer.

- `$name` is a string representing the timer name.

```php
$timer->start($name);
```

**Stop**

Stop a timer.

- `$name` is a string representing the timer name.

```php
$timer->stop($name);
```

**Stop All**

Stop all timers.

```php
$timer->stopAll();
```