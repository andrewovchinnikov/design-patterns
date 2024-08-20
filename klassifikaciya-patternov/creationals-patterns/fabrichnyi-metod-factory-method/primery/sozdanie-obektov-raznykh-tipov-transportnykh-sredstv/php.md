# PHP

Представьте, что вы работаете в компании, которая занимается доставкой грузов. Ваша команда разрабатывает приложение, которое будет использоваться для организации доставки. Клиенты могут выбирать тип транспорта, который им подходит. Ваша задача - реализовать создание объектов транспортных средств в зависимости от выбора клиента.

Для решения этой задачи вы решаете использовать паттерн "Фабричный метод". Для начала создаете интерфейс Transport, который будет содержать метод deliver(). Этот интерфейс будет определять общий функционал для всех типов транспортных средств.

Сначала создадим интерфейс Transport:

{% code overflow="wrap" lineNumbers="true" %}
```php
interface Transport
{
    public function deliver();
}
```
{% endcode %}

Затем реализуете этот интерфейс для каждого типа транспортного средства (автомобиль, велосипед, самолет и т.д.). Например, для автомобиля:

{% code overflow="wrap" lineNumbers="true" %}
```php
class Car implements Transport
{
    public function deliver()
    {
        echo "Доставка груза на автомобиле";
    }
}

class Bicycle implements Transport
{
    public function deliver()
    {
        echo "Доставка груза на велосипеде";
    }
}

class Plane implements Transport
{
    public function deliver()
    {
        echo "Доставка груза на самолете";
    }
}
```
{% endcode %}

Далее создаете фабрику TransportFactory, которая будет создавать объекты транспортных средств в зависимости от типа, переданного в метод createTransport(). Этот метод будет возвращать объект типа Transport.

{% code overflow="wrap" lineNumbers="true" %}
```php
class TransportFactory
{
    public static function createTransport(string $type): Transport
    {
        switch ($type) {
            case 'car':
                return new Car();
            case 'bicycle':
                return new Bicycle();
            case 'plane':
                return new Plane();
            default:
                throw new InvalidArgumentException('Неверный тип транспорта');
        }
    }
}
```
{% endcode %}

Используем фабрику для создания объектов:

```php
$transport = TransportFactory::createTransport('car');
$transport->deliver(); // Выведет "Доставка груза на автомобиле"
```

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (2) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для паттерна "Фабричный метод"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
interface Transport {
    +deliver(): void
}

class Car implements Transport {
    +deliver(): void
}

class Bicycle implements Transport {
    +deliver(): void
}

class Plane implements Transport {
    +deliver(): void
}

class TransportFactory {
    +createTransport(type: string): Transport
}

TransportFactory --> Transport: createTransport
Transport <|-- Car
Transport <|-- Bicycle
Transport <|-- Plane
@enduml

```
{% endcode %}
