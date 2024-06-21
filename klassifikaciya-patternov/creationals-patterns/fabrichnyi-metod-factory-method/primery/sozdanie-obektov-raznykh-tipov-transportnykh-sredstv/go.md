# Go

Представьте, что вы работаете в компании, которая занимается доставкой грузов. Ваша команда разрабатывает приложение, которое будет использоваться для организации доставки. Клиенты могут выбирать тип транспорта, который им подходит. Ваша задача - реализовать создание объектов транспортных средств в зависимости от выбора клиента.

Для решения этой задачи вы решаете использовать паттерн "Фабричный метод". Для начала создаете интерфейс Transport, который будет содержать метод Deliver(). Этот интерфейс будет определять общий функционал для всех типов транспортных средств.

{% code overflow="wrap" lineNumbers="true" %}
```go
type Transport interface {
    Deliver()
}
```
{% endcode %}

Затем реализуете этот интерфейс для каждого типа транспортного средства (автомобиль, велосипед, самолет и т.д.):

{% code overflow="wrap" lineNumbers="true" %}
```go
type Car struct{}

func (c *Car) Deliver() {
    fmt.Println("Доставка груза на автомобиле")
}
```
{% endcode %}

{% code overflow="wrap" lineNumbers="true" %}
```go
type Bicycle struct{}

func (c *Bicycle) Deliver() {
    fmt.Println("Доставка груза на велосипеде")
}
```
{% endcode %}

{% code overflow="wrap" lineNumbers="true" %}
```go
type Plane struct{}

func (c *Plane) Deliver() {
    fmt.Println("Доставка груза на самолете")
}
```
{% endcode %}

Далее создаете фабрику TransportFactory, которая будет создавать объекты транспортных средств в зависимости от типа, переданного в метод CreateTransport(). Этот метод будет возвращать объект типа Transport.

{% code overflow="wrap" lineNumbers="true" %}
```go
type TransportFactory struct{}

func (f *TransportFactory) CreateTransport(typ string) Transport {
    switch typ {
    case "car":
        return &Car{}
    case "bicycle":
        return &Bicycle{}
    case "plane":
        return &Plane{}
    default:
        panic("Неверный тип транспорта")
    }
}
```
{% endcode %}

В итоге, когда клиент выбирает тип транспорта, ваше приложение использует фабрику для создания объекта транспортного средства и вызывает метод Deliver() для доставки груза.

Диаграмма классов для этого кейса:

<figure><img src="../../../../../.gitbook/assets/image (31).png" alt=""><figcaption><p>UML диаграмма для паттерна "Фабричный метод"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
interface Transport {
    +Deliver(): void
}

class Car implements Transport {
    +Deliver(): void
}

class Bicycle implements Transport {
    +Deliver(): void
}

class Plane implements Transport {
    +Deliver(): void
}

class TransportFactory {
    +CreateTransport(type: string): Transport
}

TransportFactory --> Transport: CreateTransport
Transport <|-- Car
Transport <|-- Bicycle
Transport <|-- Plane
@enduml
```
{% endcode %}
