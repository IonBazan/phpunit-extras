# phpunit-extras

[![PHP 8.1+](https://img.shields.io/badge/PHP-8.1+-blue.svg)](https://packagist.org/packages/ion-bazan/phpunit-extras)
[![Latest version](https://img.shields.io/packagist/v/ion-bazan/phpunit-extras.svg)](https://packagist.org/packages/ion-bazan/phpunit-extras)
[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/IonBazan/phpunit-extras/test.yml)](https://github.com/IonBazan/phpunit-extras/actions)
[![Codecov](https://img.shields.io/codecov/c/gh/IonBazan/phpunit-extras)](https://codecov.io/gh/IonBazan/phpunit-extras)
[![Downloads](https://img.shields.io/packagist/dt/ion-bazan/phpunit-extras.svg)](https://packagist.org/packages/ion-bazan/phpunit-extras)
[![License](https://img.shields.io/packagist/l/ion-bazan/phpunit-extras.svg)](https://packagist.org/packages/ion-bazan/phpunit-extras)

> **Java-style test automation for PHPUnit** - using **PHP 8.1+ attributes**.

Write **cleaner, declarative, and expressive** unit tests with:

```php
#[Mock] private Logger $logger;
#[InjectMocks] private OrderService $service;
#[Captor] private ArgumentCaptor $message;
```

Inspired by **Mockito**, **JUnit 5**, and **Spring Boot Testing**.

## Installation

```bash
composer require ion-bazan/phpunit-extras
```

## Features

| Feature          | Status  | Java Equivalent  |
|------------------|---------|------------------|
| `#[Mock]`        | Done    | `@Mock`          |
| `#[InjectMocks]` | Done    | `@InjectMocks`   |
| `#[Captor]`      | Done    | `ArgumentCaptor` |
| `#[Spy]`         | Planned | `@Spy`           |
| `#[TempDir]`     | Planned | `@TempDir`       |
| `#[ValueSource]` | Planned | `@ValueSource`   |

## Usage

### 1. Use `WithExtras` trait

```php
use IonBazan\PHPUnitExtras\WithExtras;

class OrderServiceTest extends TestCase
{
    use WithExtras;

    #[Mock]
    private Payment $payment;
    #[Mock]
    private Logger $logger;
    #[Captor]
    private ArgumentCaptor $message;
    #[InjectMocks]
    private OrderService $service;

    public function testOrderLogsCharge(): void
    {
        $this->logger->expects($this->once())
            ->method('log')
            ->with($this->message);

        $this->service->place(150);

        $this->assertSame('Charged 150', $this->message->getValue());
    }
}
```
> All attributes are processed automatically via `WithExtras` trait.

### 2. Manual Processing (for fine control) TBD

### `#[Captor]` – Capture Method Arguments

```php
#[Captor] 
private ArgumentCaptor $message;

$this->logger->expects($this->once())
    ->method('log')
    ->with($this->message);

$this->logger->log('hello world');

$this->assertSame('hello world', $this->message->getValue());
$this->assertSame(['hello world'], $this->message->getAllValues());
```

- `getValue()` → first call
- `getLastValue()` → last call
- `getAllValues()` → all calls
- `count()` → number of calls


## Requirements

- PHP 8.1+
- PHPUnit 10+

## Why phpunit-extras?

| Benefit          | Description                     |
|------------------|---------------------------------|
| Less boilerplate | No `setUp()`, no manual mocks   |
| Declarative      | Intent in attributes            |
| IDE-friendly     | Autocomplete, refactoring       |
| Extensible       | Add new handlers easily         |

## Roadmap

- [ ] `#[Spy]` – partial mocks
- [ ] `#[TempDir]` – auto-cleaned temp dirs
- [ ] `#[TestFactory]` – dynamic tests


## License

MIT © [Ion Bazan](https://github.com/IonBazan)
