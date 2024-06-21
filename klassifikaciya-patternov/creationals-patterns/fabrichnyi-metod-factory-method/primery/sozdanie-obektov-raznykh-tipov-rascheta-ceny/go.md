# Go

Допустим, ваша команда разрабатывает интернет-магазин, в котором есть несколько типов товаров (одежда, обувь, электроника и т.д.). Для каждого типа товара нужно рассчитывать цену по-разному. Вы хотите реализовать создание объектов, отвечающих за расчет цены, в зависимости от типа товара.

Для решения этой задачи вы решаете использовать паттерн "Фабричный метод". Для начала создаете интерфейс PriceCalculator, который будет содержать метод CalculatePrice(). Этот интерфейс будет определять общий функционал для всех типов расчета цены.

{% code overflow="wrap" lineNumbers="true" %}
```go
type PriceCalculator interface {
    CalculatePrice(basePrice float64) float64
}
```
{% endcode %}

Затем реализуете этот интерфейс для каждого типа товара (одежда, обувь, электроника и т.д.):

{% code overflow="wrap" lineNumbers="true" %}
```go
type ClothingPriceCalculator struct{}

func (c *ClothingPriceCalculator) CalculatePrice(basePrice float64) float64 {
    return basePrice * 1.2 // Наценка 20% для одежды
}
```
{% endcode %}

{% code overflow="wrap" lineNumbers="true" %}
```go
func (c *ShoesPriceCalculator) CalculatePrice(basePrice float64) float64 {
    return basePrice * 1.22 // Наценка 22% для обуви
}
```
{% endcode %}

{% code overflow="wrap" lineNumbers="true" %}
```go
func (c *ElectronicsPriceCalculator) CalculatePrice(basePrice float64) float64 {
    return basePrice * 1.3 // Наценка 30% для электроники
}
```
{% endcode %}

Далее создаете фабрику PriceCalculatorFactory, которая будет создавать объекты для расчета цены в зависимости от типа товара, переданного в метод CreatePriceCalculator(). Этот метод будет возвращать объект типа PriceCalculator.

{% code overflow="wrap" lineNumbers="true" %}
```go
type PriceCalculatorFactory struct{}

func (f *PriceCalculatorFactory) CreatePriceCalculator(typ string) PriceCalculator {
    switch typ {
    case "clothing":
        return &ClothingPriceCalculator{}
    case "shoes":
        return &ShoesPriceCalculator{}
    case "electronics":
        return &ElectronicsPriceCalculator{}
    default:
        panic("Неверный тип товара")
    }
}
```
{% endcode %}

В итоге, когда клиент выбирает товар, ваше приложение использует фабрику для создания объекта, отвечающего за расчет цены, и вызывает метод CalculatePrice() для расчета цены товара.

Диаграмма классов для этого кейса:

<figure><img src="../../../../../.gitbook/assets/image (33).png" alt=""><figcaption><p>UML диаграмма для паттерна "Фабричный метод"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```go
@startuml
interface PriceCalculator {
    +CalculatePrice(basePrice: float): float
}

class ClothingPriceCalculator implements PriceCalculator {
    +CalculatePrice(basePrice: float): float
}

class ShoesPriceCalculator implements PriceCalculator {
    +CalculatePrice(basePrice: float): float
}

class ElectronicsPriceCalculator implements PriceCalculator {
    +CalculatePrice(basePrice: float): float
}

class PriceCalculatorFactory {
    +CreatePriceCalculator(type: string): PriceCalculator
}

PriceCalculatorFactory --> PriceCalculator: CreatePriceCalculator
PriceCalculator <|-- ClothingPriceCalculator
PriceCalculator <|-- ShoesPriceCalculator
PriceCalculator <|-- ElectronicsPriceCalculator
@enduml
```
{% endcode %}
