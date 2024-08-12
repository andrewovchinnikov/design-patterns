# Go

Мы — команда разработчиков, работающая над созданием системы платежей. Наша цель — предоставить пользователям возможность обрабатывать платежи через различные платежные системы, такие как Яндекс Деньги, СБП и Дебетовые карты. Для этого мы используем паттерн Компоновщик, который позволяет нам обрабатывать платежи через разные методы единообразно.

**1. Интерфейс PaymentMethod**

```go
package main

import "fmt"

type PaymentMethod interface {
    ProcessPayment(amount float64)
}
```

**2. Структура YandexMoney**

```go
type YandexMoney struct{}

func (ym YandexMoney) ProcessPayment(amount float64) {
    fmt.Printf("Обработка платежа через Яндекс Деньги на сумму %.2f\n", amount)
}
```

**3. Структура SBP**

```go
type SBP struct{}

func (sbp SBP) ProcessPayment(amount float64) {
    fmt.Printf("Обработка платежа через СБП на сумму %.2f\n", amount)
}
```

**4. Структура DebitCard**

```go
type DebitCard struct{}

func (dc DebitCard) ProcessPayment(amount float64) {
    fmt.Printf("Обработка платежа через Дебетовую карту на сумму %.2f\n", amount)
}
```

**5. Структура CompositePaymentMethod**

```go
type CompositePaymentMethod struct {
    paymentMethods []PaymentMethod
}

func (cp *CompositePaymentMethod) AddPaymentMethod(method PaymentMethod) {
    cp.paymentMethods = append(cp.paymentMethods, method)
}

func (cp *CompositePaymentMethod) RemovePaymentMethod(method PaymentMethod) {
    for i, m := range cp.paymentMethods {
        if m == method {
            cp.paymentMethods = append(cp.paymentMethods[:i], cp.paymentMethods[i+1:]...)
            break
        }
    }
}

func (cp CompositePaymentMethod) ProcessPayment(amount float64) {
    for _, method := range cp.paymentMethods {
        method.ProcessPayment(amount)
    }
}
```

**6. Пример использования**

```go
func main() {
    // Создаем объекты платежных методов
    yandexMoney := YandexMoney{}
    sbp := SBP{}
    debitCard := DebitCard{}

    // Создаем композитный платежный метод
    compositePayment := CompositePaymentMethod{}
    compositePayment.AddPaymentMethod(yandexMoney)
    compositePayment.AddPaymentMethod(sbp)
    compositePayment.AddPaymentMethod(debitCard)

    // Обрабатываем платеж через композитный метод
    compositePayment.ProcessPayment(100.0)
}
```

#### Объяснение кода

1. **Интерфейс PaymentMethod**: Это базовый интерфейс для всех платежных методов. Он содержит метод `ProcessPayment`, который должен быть реализован в структурах.
2. **Структуры YandexMoney, SBP и DebitCard**: Эти структуры реализуют метод `ProcessPayment` для обработки платежей через соответствующие платежные системы.
3. **Структура CompositePaymentMethod**: Эта структура позволяет объединять несколько платежных методов в один композитный метод. Она содержит срез `paymentMethods`, в который можно добавлять и удалять платежные методы. Метод `ProcessPayment` вызывает метод `ProcessPayment` для каждого из добавленных платежных методов.
4. **Пример использования**: Мы создаем объекты для каждого платежного метода, добавляем их в композитный платежный метод и вызываем метод `ProcessPayment` для обработки платежа через все добавленные методы.



UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (55).png" alt=""><figcaption><p>UML диаграмма для паттерна "Компоновщик"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
interface PaymentMethod {
    +processPayment(amount: float): void
}

class YandexMoney implements PaymentMethod {
    +processPayment(amount: float): void
}

class SBP implements PaymentMethod {
    +processPayment(amount: float): void
}

class DebitCard implements PaymentMethod {
    +processPayment(amount: float): void
}

class CompositePaymentMethod implements PaymentMethod {
    -paymentMethods: List<PaymentMethod>
    +addPaymentMethod(method: PaymentMethod): void
    +removePaymentMethod(method: PaymentMethod): void
    +processPayment(amount: float): void
}
@enduml

```
{% endcode %}

#### Вывод

Таким образом, паттерн Компоновщик позволяет нам обрабатывать платежи через разные платежные системы единообразно, что упрощает управление и расширение системы платежей.
