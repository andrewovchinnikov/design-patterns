# PHP

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Абстрактная фабрика" в платежной системе</p></figcaption></figure>

Приведенный ниже код позволяет нашей  системе платежей поддерживать два способа оплаты: кредитной картой и Яндекс.Деньгами. Кроме того, наша система может работать как с токенизацией (для безопасности), так и без нее.

Используя паттерн "Абстрактная фабрика", мы создаем интерфейс `PaymentFactory`, который определяет методы для создания объектов системы платежей. Затем, мы создаем две конкретные фабрики: `TokenizedPaymentFactory` и `NonTokenizedPaymentFactory`, которые реализуют этот интерфейс и создают конкретные объекты системы платежей, соответствующие выбранной конфигурации (с токенизацией или без нее).

Интерфейсы `CreditCardPayment` и `YandexMoneyPayment` определяют методы для объектов системы платежей, которые реализуются в конкретных классах `TokenizedCreditCardPayment`, `NonTokenizedCreditCardPayment`, `TokenizedYandexMoneyPayment` и `NonTokenizedYandexMoneyPayment`.

В клиентском коде мы выбираем конкретную фабрику в зависимости от того, нужна ли нам поддержка токенизации, и создаем объекты системы платежей с использованием этой фабрики. Затем, мы используем эти объекты для оплаты.

Этот пример демонстрирует, как паттерн "Абстрактная фабрика" может быть использован для создания гибкой и расширяемой системы, которая может легко изменяться и расширяться, не меняя существующий код.

{% code overflow="wrap" lineNumbers="true" fullWidth="false" %}
```php
<?php

// Интерфейс абстрактной фабрики для создания объектов системы платежей
interface PaymentFactory
{
    public function createCreditCardPayment();

    public function createYandexMoneyPayment();
}

// Конкретная фабрика для создания объектов системы платежей с поддержкой токенизации
class TokenizedPaymentFactory implements PaymentFactory
{
    public function createCreditCardPayment()
    {
        return new TokenizedCreditCardPayment();
    }

    public function createYandexMoneyPayment()
    {
        return new TokenizedYandexMoneyPayment();
    }
}

// Конкретная фабрика для создания объектов системы платежей без поддержки токенизации
class NonTokenizedPaymentFactory implements PaymentFactory
{
    public function createCreditCardPayment()
    {
        return new NonTokenizedCreditCardPayment();
    }

    public function createYandexMoneyPayment()
    {
        return new NonTokenizedYandexMoneyPayment();
    }
}

// Интерфейс для объектов системы платежей с использованием кредитной карты
interface CreditCardPayment
{
    public function pay(float $amount);
}

// Объект системы платежей с использованием кредитной карты и поддержкой токенизации
class TokenizedCreditCardPayment implements CreditCardPayment
{
    public function pay(float $amount): void
    {
        echo "Оплата кредитной картой с токенизацией на сумму: {$amount}" . PHP_EOL;
    }
}

// Объект системы платежей с использованием кредитной карты и без поддержки токенизации
class NonTokenizedCreditCardPayment implements CreditCardPayment
{
    public function pay(float $amount): void
    {
        echo "Оплата кредитной картой без токенизации на сумму: {$amount}" . PHP_EOL;
    }
}

// Интерфейс для объектов системы платежей с использованием Яндекс.Денег
interface YandexMoneyPayment
{
    public function pay(float $amount);
}

// Объект системы платежей с использованием Яндекс.Денег и поддержкой токенизации
class TokenizedYandexMoneyPayment implements YandexMoneyPayment
{
    public function pay(float $amount): void
    {
        echo "Оплата Яндекс.Деньгами с токенизацией на сумму: {$amount}" . PHP_EOL;
    }
}

// Объект системы платежей с использованием Яндекс.Денег и без поддержки токенизации
class NonTokenizedYandexMoneyPayment implements YandexMoneyPayment
{
    public function pay(float $amount): void
    {
        echo "Оплата Яндекс.Деньгами без токенизации на сумму: {$amount}" . PHP_EOL;
    }
}

// Клиентский код

// Выбираем конкретную фабрику в зависимости от того, нужна ли поддержка токенизации
$factory = (true) ? new TokenizedPaymentFactory() : new NonTokenizedPaymentFactory();

// Создаем объекты системы платежей с использованием конкретной фабрики
$creditCardPayment = $factory->createCreditCardPayment();
$yandexMoneyPayment = $factory->createYandexMoneyPayment();

// Используем объекты системы платежей для оплаты
$creditCardPayment->pay(100.00);
$yandexMoneyPayment->pay(200.00);

```
{% endcode %}
