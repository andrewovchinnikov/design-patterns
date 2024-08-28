# Go

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Абстрактная фабрика" в платежной системе</p></figcaption></figure>

В этом примере мы реализуем паттерн "Абстрактная фабрика" для системы платежей в интернет-магазине с использованием Яндекс.Денег на Go.

Интерфейс `PaymentFactory` определяет методы для создания объектов системы платежей. Конкретные фабрики `TokenizedPaymentFactory` и `NonTokenizedPaymentFactory` реализуют этот интерфейс и создают конкретные объекты системы платежей, соответствующие выбранной конфигурации (с токенизацией или без нее).

Интерфейсы `CreditCardPayment` и `YandexMoneyPayment` определяют методы для объектов системы платежей, которые реализуются в конкретных классах `TokenizedCreditCardPayment`, `NonTokenizedCreditCardPayment`, `TokenizedYandexMoneyPayment` и `NonTokenizedYandexMoneyPayment`.

В клиентском коде мы выбираем конкретную фабрику в зависимости от того, нужна ли нам поддержка токенизации, и создаем объекты системы платежей с использованием этой фабрики. Затем, мы используем эти объекты для оплаты.

Этот пример демонстрирует, как паттерн "Абстрактная фабрика" может быть использован для создания гибкой и расширяемой системы, которая может легко изменяться и расширяться, не меняя существующий код.

{% code overflow="wrap" lineNumbers="true" fullWidth="false" %}
```go
package main

import "fmt"

// Интерфейс абстрактной фабрики для создания объектов системы платежей
type PaymentFactory interface {
    createCreditCardPayment() CreditCardPayment
    createYandexMoneyPayment() YandexMoneyPayment
}

// Конкретная фабрика для создания объектов системы платежей с поддержкой токенизации
type TokenizedPaymentFactory struct{}

func (f *TokenizedPaymentFactory) createCreditCardPayment() CreditCardPayment {
    return &TokenizedCreditCardPayment{}
}

func (f *TokenizedPaymentFactory) createYandexMoneyPayment() YandexMoneyPayment {
    return &TokenizedYandexMoneyPayment{}
}

// Конкретная фабрика для создания объектов системы платежей без поддержки токенизации
type NonTokenizedPaymentFactory struct{}

func (f *NonTokenizedPaymentFactory) createCreditCardPayment() CreditCardPayment {
    return &NonTokenizedCreditCardPayment{}
}

func (f *NonTokenizedPaymentFactory) createYandexMoneyPayment() YandexMoneyPayment {
    return &NonTokenizedYandexMoneyPayment{}
}

// Интерфейс для объектов системы платежей с использованием кредитной карты
type CreditCardPayment interface {
    pay(amount float64)
}

// Объект системы платежей с использованием кредитной карты и поддержкой токенизации
type TokenizedCreditCardPayment struct{}

func (p *TokenizedCreditCardPayment) pay(amount float64) {
    fmt.Printf("Оплата кредитной картой с токенизацией на сумму: %.2f\n", amount)
}

// Объект системы платежей с использованием кредитной карты и без поддержки токенизации
type NonTokenizedCreditCardPayment struct{}

func (p *NonTokenizedCreditCardPayment) pay(amount float64) {
    fmt.Printf("Оплата кредитной картой без токенизации на сумму: %.2f\n", amount)
}

// Интерфейс для объектов системы платежей с использованием Яндекс.Денег
type YandexMoneyPayment interface {
    pay(amount float64)
}

// Объект системы платежей с использованием Яндекс.Денег и поддержкой токенизации
type TokenizedYandexMoneyPayment struct{}

func (p *TokenizedYandexMoneyPayment) pay(amount float64) {
    fmt.Printf("Оплата Яндекс.Деньгами с токенизацией на сумму: %.2f\n", amount)
}

// Объект системы платежей с использованием Яндекс.Денег и без поддержки токенизации
type NonTokenizedYandexMoneyPayment struct{}

func (p *NonTokenizedYandexMoneyPayment) pay(amount float64) {
    fmt.Printf("Оплата Яндекс.Деньгами без токенизации на сумму: %.2f\n", amount)
}

func main() {
    // Выбираем конкретную фабрику в зависимости от того, нужна ли поддержка токенизации
    var factory PaymentFactory
    if true {
        factory = &TokenizedPaymentFactory{}
    } else {
        factory = &NonTokenizedPaymentFactory{}
    }

    // Создаем объекты системы платежей с использованием конкретной фабрики
    creditCardPayment := factory.createCreditCardPayment()
    yandexMoneyPayment := factory.createYandexMoneyPayment()

    // Используем объекты системы платежей для оплаты
    creditCardPayment.pay(100.00)
    yandexMoneyPayment.pay(200.00)
}

```
{% endcode %}
