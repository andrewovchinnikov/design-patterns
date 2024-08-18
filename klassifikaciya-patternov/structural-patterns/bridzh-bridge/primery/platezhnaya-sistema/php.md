# PHP

Представь, что у нас есть система платежей, которая поддерживает несколько платежных систем: Яндекс Деньги, СБП и Дебетовая карта. Мы хотим, чтобы наша система была гибкой и легко расширяемой, чтобы можно было добавлять новые платежные системы без изменения основного кода.

**1. Абстракция платежной системы**

{% code overflow="wrap" lineNumbers="true" %}
```php
abstract class PaymentSystem {
    abstract public function processPayment(float $amount);
}
```
{% endcode %}

**2. Конкретные реализации платежных систем**

{% code overflow="wrap" lineNumbers="true" %}
```php
class YandexMoney extends PaymentSystem {
    public function processPayment(float $amount) {
        echo "Обработка платежа через Яндекс Деньги на сумму $amount\n";
    }
}

class SBP extends PaymentSystem {
    public function processPayment(float $amount) {
        echo "Обработка платежа через СБП на сумму $amount\n";
    }
}

class DebitCard extends PaymentSystem {
    public function processPayment(float $amount) {
        echo "Обработка платежа через Дебетовую карту на сумму $amount\n";
    }
}
```
{% endcode %}

**3. Абстракция платежа**

{% code overflow="wrap" lineNumbers="true" %}
```php
abstract class Payment {
    protected $paymentSystem;

    public function setPaymentSystem(PaymentSystem $paymentSystem) {
        $this->paymentSystem = $paymentSystem;
    }

    abstract public function makePayment(float $amount);
}
```
{% endcode %}

**4. Конкретные реализации платежей**

{% code overflow="wrap" lineNumbers="true" %}
```php
class OnlinePayment extends Payment {
    public function makePayment(float $amount) {
        echo "Онлайн платеж на сумму $amount\n";
        $this->paymentSystem->processPayment($amount);
    }
}

class OfflinePayment extends Payment {
    public function makePayment(float $amount) {
        echo "Офлайн платеж на сумму $amount\n";
        $this->paymentSystem->processPayment($amount);
    }
}
```
{% endcode %}

**5. Пример использования**

```php
// Создаем объекты платежных систем
$yandexMoney = new YandexMoney();
$sbp = new SBP();
$debitCard = new DebitCard();

// Создаем объекты платежей
$onlinePayment = new OnlinePayment();
$offlinePayment = new OfflinePayment();

// Устанавливаем платежные системы для платежей
$onlinePayment->setPaymentSystem($yandexMoney);
$offlinePayment->setPaymentSystem($sbp);

// Выполняем платежи
$onlinePayment->makePayment(100.0);
$offlinePayment->makePayment(200.0);

// Меняем платежную систему для онлайн платежа
$onlinePayment->setPaymentSystem($debitCard);
$onlinePayment->makePayment(150.0);
```

#### Объяснение

1. **Абстракция платежной системы**: Мы создаем абстрактный класс `PaymentSystem`, который определяет метод `processPayment`. Этот метод будет реализован в конкретных платежных системах.
2. **Конкретные реализации платежных систем**: Мы создаем классы `YandexMoney`, `SBP` и `DebitCard`, которые реализуют метод `processPayment` по-своему.
3. **Абстракция платежа**: Мы создаем абстрактный класс `Payment`, который содержит ссылку на объект платежной системы и метод `makePayment`.
4. **Конкретные реализации платежей**: Мы создаем классы `OnlinePayment` и `OfflinePayment`, которые реализуют метод `makePayment` по-своему.
5. **Пример использования**: Мы создаем объекты платежных систем и платежей, устанавливаем платежные системы для платежей и выполняем платежи.

#### UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для паттерна "Мост"</p></figcaption></figure>

```plant-uml
@startuml

abstract class PaymentSystem {
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

#### Вывод

Таким образом, мы можем легко добавлять новые платежные системы, не изменяя основной код платежей. Это и есть суть паттерна "Мост".
