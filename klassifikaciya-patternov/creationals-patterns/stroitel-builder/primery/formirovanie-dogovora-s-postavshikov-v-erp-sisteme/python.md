# Python

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Строитель"</p></figcaption></figure>

Тимлид сформировал задачу на разработку нового модуля для существующей ERP системы, который будет отвечать за формирование и обработку договоров с поставщиками. Разработчик, взявшийся за эту задачу, столкнулся с тем, что объект "Договор" имеет сложную структуру и содержит множество различных данных, таких как информация о стоимости, сроках выполнения, обязанностях сторон и т.д. Кроме того, договор может быть связан с другими объектами бизнес-логики, такими как заказы, счета и т.д.

Разработчик решил использовать паттерн "Строитель" для создания объектов "Договор". Этот паттерн позволяет создавать сложные объекты с помощью последовательного вызова методов, добавляющих необходимые данные и устанавливающих связи с другими объектами. При этом сам процесс создания объекта вынесен в отдельный класс "Builder", что позволяет избежать избыточной сложности кода и улучшить его гибкость и расширяемость.

Ниже приведен пример кода, реализующего паттерн "Строитель" для создания объектов "Договор":

Класс "Договор"

{% code overflow="wrap" lineNumbers="true" %}
```python
class Contract:
    def __init__(self):
        self.cost = 0.0
        self.deadline = datetime.now()
        self.obligations = []
        self.order = None
        self.invoice = None

    def get_cost(self):
        return self.cost

    def get_deadline(self):
        return self.deadline

    def get_obligations(self):
        return self.obligations

    def get_order(self):
        return self.order

    def get_invoice(self):
        return self.invoice
```
{% endcode %}

Класс "Договор" (Contract): Этот класс представляет объект "Договор" в бизнес-логике. Он имеет атрибуты для стоимости, срока выполнения, обязанностей и ссылок на Заказ и Счет. Он также имеет методы получения для доступа к этим атрибутам. В конструкторе класса инициализируется свойство $obligations как пустой массив. Кроме того, класс содержит публичные методы-геттеры для доступа к значениям своих свойств.&#x20;

Класс "ContractBuilder" для создания объектов "Договор"

{% code overflow="wrap" lineNumbers="true" %}
```python
class ContractBuilder:
    def __init__(self):
        self.contract = Contract()

    def set_cost(self, cost):
        self.contract.cost = cost
        return self

    def set_deadline(self, deadline):
        self.contract.deadline = deadline
        return self

    def add_obligation(self, obligation):
        self.contract.obligations.append(obligation)
        return self

    def set_order(self, order):
        self.contract.order = order
        return self

    def set_invoice(self, invoice):
        self.contract.invoice = invoice
        return self

    def build(self):
        result = self.contract
        self.contract = Contract()  
        return result
```
{% endcode %}

Этот класс реализует паттерн "Строитель" для создания объектов "Договор". Он содержит приватное свойство $contract, которое хранит текущий экземпляр класса Contract, который строится. В конструкторе класса инициализируется свойство $contract как новый экземпляр класса Contract. Кроме того, класс содержит цепочку публичных методов-сеттеров для настройки свойств экземпляра класса Contract, которые возвращают текущий экземпляр класса ContractBuilder для дальнейшей цепочки вызовов. Метод build() создает и возвращает готовый экземпляр класса Contract, а также сбрасывает значение свойства $contract для создания нового экземпляра класса Contract при следующем вызове.

Пример использования

{% code overflow="wrap" lineNumbers="true" %}
```python
def main():
    order = Order()  # Создаем объект "Заказ"
    invoice = Invoice()  # Создаем объект "Счет"

    contract = ContractBuilder() \
        .set_cost(1000.0) \
        .set_deadline(datetime.now() + timedelta(days=30)) \
        .add_obligation("Поставка товара в срок") \
        .add_obligation("Соответствие товара требованиям заказа") \
        .set_order(order) \
        .set_invoice(invoice) \
        .build()

    print("Стоимость контракта: ", contract.get_cost())
    print("Дедлайн контракта: ", contract.get_deadline())
    print("Обязанности сторон: ", contract.get_obligations())
    print("Связанный заказ: ", contract.get_order())
    print("Связанный счет: ", contract.get_invoice())

if __name__ == "__main__":
    main()
```
{% endcode %}

В примере использования создаются новые объекты "Заказ" (Order) и "Счет" (Invoice), которые будут связаны с создаваемым объектом "Договор". Затем создается новый экземпляр класса ContractBuilder и вызывается цепочка методов-сеттеров для настройки свойств создаваемого объекта "Договор", таких как стоимость, срок выполнения, обязанности сторон, связанный заказ и связанный счет. Метод build() вызывается в конце цепочки для создания и возврата готового объекта "Договор". Затем выводятся значения свойств созданного объекта "Договор" с помощью методов-геттеров.
