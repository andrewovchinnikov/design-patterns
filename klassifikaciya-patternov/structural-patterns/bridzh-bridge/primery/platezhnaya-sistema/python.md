# Python

Предположим,что у нас есть система платежей, которая поддерживает несколько платежных систем: Яндекс Деньги, СБП и Дебетовая карта. Мы хотим, чтобы наша система была гибкой и легко расширяемой, чтобы можно было добавлять новые платежные системы без изменения основного кода.

#### Решение с использованием паттерна "Мост"

**1. Абстракция платежной системы**

```python
from abc import ABC, abstractmethod

class PaymentSystem(ABC):
    @abstractmethod
    def processPayment(self, amount: float):
        pass
```

**2. Конкретные реализации платежных систем**

```python
class YandexMoney(PaymentSystem):
    def processPayment(self, amount: float):
        print(f"Обработка платежа через Яндекс Деньги на сумму {amount}")

class SBP(PaymentSystem):
    def processPayment(self, amount: float):
        print(f"Обработка платежа через СБП на сумму {amount}")

class DebitCard(PaymentSystem):
    def processPayment(self, amount: float):
        print(f"Обработка платежа через Дебетовую карту на сумму {amount}")
```

**3. Абстракция платежа**

```python
class Payment(ABC):
    def __init__(self, paymentSystem: PaymentSystem):
        self.paymentSystem = paymentSystem

    def setPaymentSystem(self, paymentSystem: PaymentSystem):
        self.paymentSystem = paymentSystem

    @abstractmethod
    def makePayment(self, amount: float):
        pass
```

**4. Конкретные реализации платежей**

```python
class OnlinePayment(Payment):
    def makePayment(self, amount: float):
        print(f"Онлайн платеж на сумму {amount}")
        self.paymentSystem.processPayment(amount)

class OfflinePayment(Payment):
    def makePayment(self, amount: float):
        print(f"Офлайн платеж на сумму {amount}")
        self.paymentSystem.processPayment(amount)
```

**5. Пример использования**

```python
if __name__ == "__main__":
    # Создаем объекты платежных систем
    yandexMoney = YandexMoney()
    sbp = SBP()
    debitCard = DebitCard()

    # Создаем объекты платежей
    onlinePayment = OnlinePayment(yandexMoney)
    offlinePayment = OfflinePayment(sbp)

    # Выполняем платежи
    onlinePayment.makePayment(100.0)
    offlinePayment.makePayment(200.0)

    # Меняем платежную систему для онлайн платежа
    onlinePayment.setPaymentSystem(debitCard)
    onlinePayment.makePayment(150.0)
```

#### Объяснение

1. **Абстракция платежной системы**: Мы создаем абстрактный класс `PaymentSystem`, который определяет метод `processPayment`. Этот метод будет реализован в конкретных платежных системах.
2. **Конкретные реализации платежных систем**: Мы создаем классы `YandexMoney`, `SBP` и `DebitCard`, которые реализуют метод `processPayment` по-своему.
3. **Абстракция платежа**: Мы создаем абстрактный класс `Payment`, который содержит ссылку на объект платежной системы и метод `makePayment`.
4. **Конкретные реализации платежей**: Мы создаем классы `OnlinePayment` и `OfflinePayment`, которые реализуют метод `makePayment` по-своему.
5. **Пример использования**: Мы создаем объекты платежных систем и платежей, устанавливаем платежные системы для платежей и выполняем плате

UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для паттерна "Мост"</p></figcaption></figure>

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



Таким образом, мы можем легко добавлять новые платежные системы, не изменяя основной код платежей. Это и есть суть паттерна "Мост".
