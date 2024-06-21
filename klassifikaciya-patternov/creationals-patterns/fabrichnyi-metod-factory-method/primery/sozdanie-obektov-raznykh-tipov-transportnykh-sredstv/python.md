# Python

Представьте, что вы работаете в компании, которая занимается доставкой грузов. Ваша команда разрабатывает приложение, которое будет использоваться для организации доставки. Клиенты могут выбирать тип транспорта, который им подходит. Ваша задача - реализовать создание объектов транспортных средств в зависимости от выбора клиента.

Для решения этой задачи вы решаете использовать паттерн "Фабричный метод". Для начала создаете интерфейс Transport, который будет содержать метод deliver(). Этот интерфейс будет определять общий функционал для всех типов транспортных средств.

{% code overflow="wrap" lineNumbers="true" %}
```python
from abc import ABC, abstractmethod

class Transport(ABC):
    @abstractmethod
    def deliver(self):
        pass
```
{% endcode %}

Затем реализуете этот интерфейс для каждого типа транспортного средства (автомобиль, велосипед, самолет и т.д.):

{% code overflow="wrap" lineNumbers="true" %}
```python
class Car(Transport):
    def deliver(self):
        print("Доставка груза на автомобиле")
```
{% endcode %}

{% code overflow="wrap" lineNumbers="true" %}
```python
class Bicycle(Transport):
    def deliver(self):
        print("Доставка груза на велосипеде")
```
{% endcode %}

{% code overflow="wrap" lineNumbers="true" %}
```python
class Plane(Transport):
    def deliver(self):
        print("Доставка груза на самолете")
```
{% endcode %}

Далее создаете фабрику TransportFactory, которая будет создавать объекты транспортных средств в зависимости от типа, переданного в метод create\_transport(). Этот метод будет возвращать объект типа Transport.

{% code overflow="wrap" lineNumbers="true" %}
```python
class TransportFactory:
    @staticmethod
    def create_transport(transport_type: str) -> Transport:
        if transport_type == "car":
            return Car()
        elif transport_type == "bicycle":
            return Bicycle()
        elif transport_type == "plane":
            return Plane()
        else:
            raise ValueError("Неверный тип транспорта")
```
{% endcode %}

В итоге, когда клиент выбирает тип транспорта, ваше приложение использует фабрику для создания объекта транспортного средства и вызывает метод deliver() для доставки груза.

Диаграмма классов для этого кейса:

<figure><img src="../../../../../.gitbook/assets/image (34).png" alt=""><figcaption><p>UML диаграмма для паттерна "Фабричный метод"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
abstract class Transport {
    +deliver(): void
}

class Car extends Transport {
    +deliver(): void
}

class Bicycle extends Transport {
    +deliver(): void
}

class Plane extends Transport {
    +deliver(): void
}

class TransportFactory {
    +create_transport(type: string): Transport
}

TransportFactory --> Transport: create_transport
Transport <|-- Car
Transport <|-- Bicycle
Transport <|-- Plane
@enduml
```
{% endcode %}
