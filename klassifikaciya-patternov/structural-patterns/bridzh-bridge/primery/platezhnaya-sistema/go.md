# Go

Представь, что у нас есть система платежей, которая поддерживает несколько платежных систем: Яндекс Деньги, СБП и Дебетовая карта. Мы хотим, чтобы наша система была гибкой и легко расширяемой, чтобы можно было добавлять новые платежные системы без изменения основного кода.

**1. Абстракция платежной системы**

{% code overflow="wrap" lineNumbers="true" %}
```go
package main

import "fmt"

type PaymentSystem interface {
    processPayment(amount float64)
}
```
{% endcode %}

**2. Конкретные реализации платежных систем**

{% code overflow="wrap" lineNumbers="true" %}
```go
type YandexMoney struct{}

func (y YandexMoney) processPayment(amount float64) {
    fmt.Printf("Обработка платежа через Яндекс Деньги на сумму %.2f\n", amount)
}

type SBP struct{}

func (s SBP) processPayment(amount float64) {
    fmt.Printf("Обработка платежа через СБП на сумму %.2f\n", amount)
}

type DebitCard struct{}

func (d DebitCard) processPayment(amount float64) {
    fmt.Printf("Обработка платежа через Дебетовую карту на сумму %.2f\n", amount)
}
```
{% endcode %}

**3. Абстракция платежа**

{% code overflow="wrap" lineNumbers="true" %}
```go
type Payment struct {
    paymentSystem PaymentSystem
}

func (p *Payment) setPaymentSystem(paymentSystem PaymentSystem) {
    p.paymentSystem = paymentSystem
}

func (p *Payment) makePayment(amount float64) {
    p.paymentSystem.processPayment(amount)
}
```
{% endcode %}

**4. Конкретные реализации платежей**

{% code overflow="wrap" lineNumbers="true" %}
```go
type OnlinePayment struct {
    Payment
}

func (op *OnlinePayment) makePayment(amount float64) {
    fmt.Printf("Онлайн платеж на сумму %.2f\n", amount)
    op.Payment.makePayment(amount)
}

type OfflinePayment struct {
    Payment
}

func (op *OfflinePayment) makePayment(amount float64) {
    fmt.Printf("Офлайн платеж на сумму %.2f\n", amount)
    op.Payment.makePayment(amount)
}
```
{% endcode %}

**5. Пример использования**

{% code overflow="wrap" lineNumbers="true" %}
```go
func main() {
    // Создаем объекты платежных систем
    yandexMoney := YandexMoney{}
    sbp := SBP{}
    debitCard := DebitCard{}

    // Создаем объекты платежей
    onlinePayment := OnlinePayment{}
    offlinePayment := OfflinePayment{}

    // Устанавливаем платежные системы для платежей
    onlinePayment.setPaymentSystem(&yandexMoney)
    offlinePayment.setPaymentSystem(&sbp)

    // Выполняем платежи
    onlinePayment.makePayment(100.0)
    offlinePayment.makePayment(200.0)

    // Меняем платежную систему для онлайн платежа
    onlinePayment.setPaymentSystem(&debitCard)
    onlinePayment.makePayment(150.0)
}
```
{% endcode %}

#### Объяснение

1. **Абстракция платежной системы**: Мы создаем интерфейс `PaymentSystem`, который определяет метод `processPayment`. Этот метод будет реализован в конкретных платежных системах.
2. **Конкретные реализации платежных систем**: Мы создаем структуры `YandexMoney`, `SBP` и `DebitCard`, которые реализуют метод `processPayment` по-своему.
3. **Абстракция платежа**: Мы создаем структуру `Payment`, которая содержит ссылку на объект платежной системы и метод `makePayment`.
4. **Конкретные реализации платежей**: Мы создаем структуры `OnlinePayment` и `OfflinePayment`, которые реализуют метод `makePayment` по-своему.
5. **Пример использования**: Мы создаем объекты платежных систем и платежей, устанавливаем платежные системы для платежей и выполняем платежи.



UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (53).png" alt=""><figcaption><p>UML диаграмма дял паттерна "Мост"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml

interface PaymentSystem {
    +processPayment(amount: float): void
}

class YandexMoney implements PaymentSystem {
    +processPayment(amount: float): void
}

class SBP implements PaymentSystem {
    +processPayment(amount: float): void
}

class DebitCard implements PaymentSystem {
    +processPayment(amount: float): void
}

abstract class Payment {
    -paymentSystem: PaymentSystem
    +setPaymentSystem(paymentSystem: PaymentSystem): void
    +makePayment(amount: float): void
}

class OnlinePayment extends Payment {
    +makePayment(amount: float): void
}

class OfflinePayment extends Payment {
    +makePayment(amount: float): void
}

PaymentSystem <|-- YandexMoney
PaymentSystem <|-- SBP
PaymentSystem <|-- DebitCard

Payment <|-- OnlinePayment
Payment <|-- OfflinePayment

Payment "1" -- "1" PaymentSystem

@enduml
```
{% endcode %}

#### Вывод

Таким образом, мы можем легко добавлять новые платежные системы, не изменяя основной код платежей. Это и есть суть паттерна "Мост".
