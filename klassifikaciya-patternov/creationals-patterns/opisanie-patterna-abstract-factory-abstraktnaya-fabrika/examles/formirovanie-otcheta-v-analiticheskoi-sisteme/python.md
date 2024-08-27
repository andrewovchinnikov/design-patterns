# Python

<figure><img src="../../../../../.gitbook/assets/image (7) (1).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Абстрактная фабрика" в аналитической системе для формирования отчета</p></figcaption></figure>

Кейс:

Наша компания разрабатывает аналитическую систему, которая должна формировать отчеты о двух типах данных - пользователях (UserData) и продажах (SalesData). Отчеты должны быть доступны в трех форматах - JSON, XML и CSV. Кроме того, мы хотим, чтобы наша система была гибкой и легко расширяемой, чтобы в будущем мы могли добавлять новые типы отчетов и форматы без значительных изменений в существующем коде.

Решение:

Для решения этой задачи мы решили использовать паттерн "Абстрактная фабрика". Этот паттерн предоставляет интерфейс для создания семейств взаимосвязанных или взаимозависимых объектов, не специфицируя их конкретные классы.

Код:

1. Определяем интерфейсы:

Сначала мы определяем два интерфейса - `DataFactory` и `DataType`. В Python интерфейсы можно реализовать с помощью абстрактных классов (`abc.ABC`). Интерфейс `DataFactory` содержит один метод `create_data()`, который должен возвращать объект, реализующий интерфейс `DataType`. Интерфейс `DataType` содержит два метода - `get_data()` и `set_format(format)`. Метод `get_data()` должен возвращать отчет в выбранном формате, а метод `set_format(format)` устанавливает формат отчета.

```python
from abc import ABC, abstractmethod

class DataFactory(ABC):
    @abstractmethod
    def create_data(self) -> 'DataType':
        pass

class DataType(ABC):
    @abstractmethod
    def get_data(self) -> str:
        pass

    @abstractmethod
    def set_format(self, format: str):
        pass
```

2. Реализуем конкретные фабрики:

Затем мы реализуем две конкретные фабрики - `UserDataFactory` и `SalesDataFactory`, которые реализуют интерфейс `DataFactory`. Метод `create_data()` в каждой фабрике возвращает объект конкретного типа данных - `UserData` или `SalesData`.

```python
class UserDataFactory(DataFactory):
    def create_data(self) -> 'UserData':
        return UserData()

class SalesDataFactory(DataFactory):
    def create_data(self) -> 'SalesUserDataata':
        return SalesData()
```

3. Реализуем конкретные типы данных:

Далее мы реализуем два конкретных типа данных - `UserData` и `SalesData`, которые реализуют интерфейс `DataType`. В каждом типе данных мы реализуем методы `get_data()` и `set_format(format)`. Метод `get_data()` формирует отчет о данных в выбранном формате с помощью стандартных библиотек Python `json`, `xml.etree.ElementTree` и `csv`. Метод `set_format(format)` устанавливает формат отчета.

```python
import json
import xml.etree.ElementTree as ET
import csv

class UserData(DataType):
    def __init__(self):
        self.format = ''
        self.user_data = [
            {'name': 'John', 'age': 30},
            {'name': 'Jane', 'age': 25}
        ]

    def get_data(self) -> str:
        if self.format == 'JSON':
            return json.dumps(self.user_data)
        elif self.format == 'XML':
            return self.to_xml()
        elif self.format == 'CSV':
            return self.to_csv()

    def set_format(self, format: str):
        self.format = format

    def to_xml(self):
        root = ET.Element('users')
        for user in self.user_data:
            user_elem = ET.SubElement(root, 'user')
            ET.SubElement(user_elem, 'name').text = user['name']
            ET.SubElement(user_elem, 'age').text = str(user['age'])
        return ET.tostring(root, encoding='unicode')

    def to_csv(self):
        output = io.StringIO()
        writer = csv.DictWriter(output, fieldnames=['name', 'age'])
        writer.writeheader()
        for user in self.user_data:
            writer.writerow(user)
        return output.getvalue()

class SalesData(DataType):
    def __init__(self):
        self.format = ''
        self.sales_data = [
            {'product': 'Book', 'price': 20},
            {'product': 'Pen', 'price': 5}
        ]

    def get_data(self) -> str:
        if self.format == 'JSON':
            return json.dumps(self.sales_data)
        elif self.format == 'XML':
            return self.to_xml()
        elif self.format == 'CSV':
            return self.to_csv()

    def set_format(self, format: str):
        self.format = format

    def to_xml(self):
        root = ET.Element('sales')
        for sale in self.sales_data:
            sale_elem = ET.SubElement(root, 'sale')
            ET.SubElement(sale_elem, 'product').text = sale['product']
            ET.SubElement(sale_elem, 'price').text = str(sale['price'])
        return ET.tostring(root, encoding='unicode')

    def to_csv(self):
        output = io.StringIO()
        writer = csv.DictWriter(output, fieldnames=['product', 'price'])
        writer.writeheader()
        for sale in self.sales_data:
            writer.writerow(sale)
        return output.getvalue()
```

4. Реализуем класс для формирования отчетов:

Наконец, мы реализуем класс `Report`, который использует интерфейсы `DataFactory` и `DataType` для формирования отчетов. В классе `Report` мы определяем два поля - `factory` и `data`, которые соответствуют фабрике и типу данных, используемым для формирования отчета. Мы также определяем три метода - конструктор `__init__(self, factory: DataFactory)`, метод `generate_report(self) -> str`, который формирует и возвращает отчет, и метод `set_format(self, format: str)`, который устанавливает формат отчета.

```python
class Report:
    def __init__(self, factory: DataFactory):
        self.factory = factory
        self.data = self.factory.create_data()

    def generate_report(self) -> str:
        # Здесь должна быть логика формирования отчета
        return self.data.get_data()

    def set_format(self, format: str):
        self.data.set_format(format)
```

5. Используем класс `Report` для формирования отчетов:

В конце мы создаем два отчета - `user_data_report` и `sales_data_report`, используя класс `Report` и соответствующие фабрики. Затем мы устанавливаем формат отчетов с помощью метода `set_format(format)` и формируем отчеты с помощью метода `generate_report()`.

```python
user_data_report = Report(UserDataFactory())
user_data_report.set_format('JSON')
print(user_data_report.generate_report())

sales_data_report = Report(SalesDataFactory())
sales_data_report.set_format('XML')
print(sales_data_report.generate_report())
```

Надеюсь, этот пример поможет вам лучше понять, как можно реализовать паттерн "Абстрактная фабрика" на Python и как он может быть полезен в разработке гибких и расширяемых систем.

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
