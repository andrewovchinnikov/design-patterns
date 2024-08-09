# Python

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Абстрактная фабрика" в платежной системе</p></figcaption></figure>

В этом примере мы реализуем паттерн "Абстрактная фабрика" для системы платежей в интернет-магазине с использованием Яндекс.Денег на Python.

Интерфейс `PaymentFactory` определяет методы для создания объектов системы платежей. Конкретные фабрики `TokenizedPaymentFactory` и `NonTokenizedPaymentFactory` реализуют этот интерфейс и создают конкретные объекты системы платежей, соответствующие выбранной конфигурации (с токенизацией или без нее).

Интерфейсы `CreditCardPayment` и `YandexMoneyPayment` определяют методы для объектов системы платежей, которые реализуются в конкретных классах `TokenizedCreditCardPayment`, `NonTokenizedCreditCardPayment`, `TokenizedYandexMoneyPayment` и `NonTokenizedYandexMoneyPayment`.

В клиентском коде мы выбираем конкретную фабрику в зависимости от того, нужна ли нам поддержка токенизации, и создаем объекты системы платежей с использованием этой фабрики. Затем, мы используем эти объекты для оплаты.

Этот пример демонстрирует, как паттерн "Абстрактная фабрика" может быть использован для создания гибкой и расширяемой системы, которая может легко изменяться и расширяться, не меняя существующий код.

{% code overflow="wrap" lineNumbers="true" fullWidth="false" %}
```python
# Интерфейс абстрактной фабрики для создания объектов системы платежей
class PaymentFactory:
    def create_credit_card_payment(self):
        pass

    def create_yandex_money_payment(self):
        pass

# Конкретная фабрика для создания объектов системы платежей с поддержкой токенизации
class TokenizedPaymentFactory(PaymentFactory):
    def create_credit_card_payment(self):
        return TokenizedCreditCardPayment()

    def create_yandex_money_payment(self):
        return TokenizedYandexMoneyPayment()

# Конкретная фабрика для создания объектов системы платежей без поддержки токенизации
class NonTokenizedPaymentFactory(PaymentFactory):
    def create_credit_card_payment(self):
        return NonTokenizedCreditCardPayment()

    def create_yandex_money_payment(self):
        return NonTokenizedYandexMoneyPayment()

# Интерфейс для объектов системы платежей с использованием кредитной карты
class CreditCardPayment:
    def pay(self, amount: float):
        pass

# Объект системы платежей с использованием кредитной карты и поддержкой токенизации
class TokenizedCreditCardPayment(CreditCardPayment):
    def pay(self, amount: float):
        print(f"Оплата кредитной картой с токенизацией на сумму: {amount:.2f}")

# Объект системы платежей с использованием кредитной карты и без поддержки токенизации
class NonTokenizedCreditCardPayment(CreditCardPayment):
    def pay(self, amount: float):
        print(f"Оплата кредитной картой без токенизации на сумму: {amount:.2f}")

# Интерфейс для объектов системы платежей с использованием Яндекс.Денег
class YandexMoneyPayment:
    def pay(self, amount: float):
        pass

# Объект системы платежей с использованием Яндекс.Денег и поддержкой токенизации
class TokenizedYandexMoneyPayment(YandexMoneyPayment):
    def pay(self, amount: float):
        print(f"Оплата Яндекс.Деньгами с токенизацией на сумму: {amount:.2f}")

# Объект системы платежей с использованием Яндекс.Денег и без поддержки токенизации
class NonTokenizedYandexMoneyPayment(YandexMoneyPayment):
    def pay(self, amount: float):
        print(f"Оплата Яндекс.Деньгами без токенизации на сумму: {amount:.2f}")

# Клиентский код

# Выбираем конкретную фабрику в зависимости от того, нужна ли поддержка токенизации
factory = TokenizedPaymentFactory() if True else NonTokenizedPaymentFactory()

# Создаем объекты системы платежей с использованием конкретной фабрики
credit_card_payment = factory.create_credit_card_payment()
yandex_money_payment = factory.create_yandex_money_payment()

# Используем объекты системы платежей для оплаты
credit_card_payment.pay(100.00)
yandex_money_payment.pay(200.00)


```
{% endcode %}
