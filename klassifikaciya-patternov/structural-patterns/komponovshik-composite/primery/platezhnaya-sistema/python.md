# Python

Мы — команда разработчиков, работающая над созданием системы платежей. Наша цель — предоставить пользователям возможность обрабатывать платежи через различные платежные системы, такие как Яндекс Деньги, СБП и Дебетовые карты. Для этого мы используем паттерн Компоновщик, который позволяет нам обрабатывать платежи через разные методы единообразно.

**1. Интерфейс PaymentMethod**

{% code overflow="wrap" lineNumbers="true" %}
```python
from abc import ABC, abstractmethod

class PaymentMethod(ABC):
    @abstractmethod
    def processPayment(self, amount: float):
        pass
```
{% endcode %}

**2. Класс YandexMoney**

{% code overflow="wrap" lineNumbers="true" %}
```python
class YandexMoney(PaymentMethod):
    def processPayment(self, amount: float):
        print(f"Обработка платежа через Яндекс Деньги на сумму {amount:.2f}")
```
{% endcode %}

**3. Класс SBP**

{% code overflow="wrap" lineNumbers="true" %}
```python
class SBP(PaymentMethod):
    def processPayment(self, amount: float):
        print(f"Обработка платежа через СБП на сумму {amount:.2f}")
```
{% endcode %}

**4. Класс DebitCard**

{% code overflow="wrap" lineNumbers="true" %}
```python
class DebitCard(PaymentMethod):
    def processPayment(self, amount: float):
        print(f"Обработка платежа через Дебетовую карту на сумму {amount:.2f}")
```
{% endcode %}

**5. Класс CompositePaymentMethod**

{% code overflow="wrap" lineNumbers="true" %}
```python
class CompositePaymentMethod(PaymentMethod):
    def __init__(self):
        self.paymentMethods = []

    def addPaymentMethod(self, method: PaymentMethod):
        self.paymentMethods.append(method)

    def removePaymentMethod(self, method: PaymentMethod):
        self.paymentMethods.remove(method)

    def processPayment(self, amount: float):
        for method in self.paymentMethods:
            method.processPayment(amount)
```
{% endcode %}

**6. Пример использования**

{% code overflow="wrap" lineNumbers="true" %}
```python
def main():
    # Создаем объекты платежных методов
    yandexMoney = YandexMoney()
    sbp = SBP()
    debitCard = DebitCard()

    # Создаем композитный платежный метод
    compositePayment = CompositePaymentMethod()
    compositePayment.addPaymentMethod(yandexMoney)
    compositePayment.addPaymentMethod(sbp)
    compositePayment.addPaymentMethod(debitCard)

    # Обрабатываем платеж через композитный метод
    compositePayment.processPayment(100.0)

if __name__ == "__main__":
    main()
```
{% endcode %}

#### Объяснение кода

1. **Интерфейс PaymentMethod**: Это базовый интерфейс для всех платежных методов. Он содержит абстрактный метод `processPayment`, который должен быть реализован в подклассах.
2. **Классы YandexMoney, SBP и DebitCard**: Эти классы реализуют метод `processPayment` для обработки платежей через соответствующие платежные системы.
3. **Класс CompositePaymentMethod**: Этот класс позволяет объединять несколько платежных методов в один композитный метод. Он содержит список `paymentMethods`, в который можно добавлять и удалять платежные методы. Метод `processPayment` вызывает метод `processPayment` для каждого из добавленных платежных методов.
4. **Пример использования**: Мы создаем объекты для каждого платежного метода, добавляем их в композитный платежный метод и вызываем метод `processPayment` для обработки платежа через все добавленные методы.

UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для паттерна "Компоновщик"</p></figcaption></figure>

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



Таким образом, паттерн "Компоновщик" позволяет нам обрабатывать платежи через разные платежные системы единообразно, что упрощает управление и расширение системы платежей.
