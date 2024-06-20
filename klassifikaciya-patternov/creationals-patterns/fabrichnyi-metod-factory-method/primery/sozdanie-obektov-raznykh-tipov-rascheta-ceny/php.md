# PHP

Допустим, ваша команда разрабатывает интернет-магазин, в котором есть несколько типов товаров (одежда, обувь, электроника и т.д.). Для каждого типа товара нужно рассчитывать цену по-разному. Вы хотите реализовать создание объектов, отвечающих за расчет цены, в зависимости от типа товара.

Для решения этой задачи вы решаете использовать паттерн "Фабричный метод". Для начала создаете интерфейс PriceCalculator, который будет содержать метод calculatePrice(). Этот интерфейс будет определять общий функционал для всех типов расчета цены.

```php
interface PriceCalculator
{
    public function calculatePrice(float $basePrice): float;
}
```

Затем реализуете этот интерфейс для каждого типа товара (одежда, обувь, электроника и т.д.). Например, для одежды:

```php
class ClothingPriceCalculator implements PriceCalculator
{
    public function calculatePrice(float $basePrice): float
    {
        return $basePrice * 1.2; // Наценка 20% для одежды
    }
}
```

Далее создаете фабрику PriceCalculatorFactory, которая будет создавать объекты для расчета цены в зависимости от типа товара, переданного в метод createPriceCalculator(). Этот метод будет возвращать объект типа PriceCalculator.

```php
class PriceCalculatorFactory
{
    public static function createPriceCalculator(string $type): PriceCalculator
    {
        switch ($type) {
            case 'clothing':
                return new ClothingPriceCalculator();
            case 'shoes':
                return new ShoesPriceCalculator();
            case 'electronics':
                return new ElectronicsPriceCalculator();
            default:
                throw new InvalidArgumentException('Неверный тип товара');
        }
    }
}
```

В итоге, когда клиент выбирает товар, ваше приложение использует фабрику для создания объекта, отвечающего за расчет цены, и вызывает метод calculatePrice() для расчета цены товара.

Диаграмма классов для этого кейса:

<figure><img src="../../../../../.gitbook/assets/image (2).png" alt=""><figcaption><p>UML диаграмма для паттерна "Фабричный метод"</p></figcaption></figure>

```plant-uml
@startuml
interface PriceCalculator {
    +calculatePrice(basePrice: float): float
}

class ClothingPriceCalculator implements PriceCalculator {
    +calculatePrice(basePrice: float): float
}

class ShoesPriceCalculator implements PriceCalculator {
    +calculatePrice(basePrice: float): float
}

class ElectronicsPriceCalculator implements PriceCalculator {
    +calculatePrice(basePrice: float): float
}

class PriceCalculatorFactory {
    +createPriceCalculator(type: string): PriceCalculator
}

PriceCalculatorFactory --> PriceCalculator: createPriceCalculator
PriceCalculator <|-- ClothingPriceCalculator
PriceCalculator <|-- ShoesPriceCalculator
PriceCalculator <|-- ElectronicsPriceCalculator
@enduml
```
