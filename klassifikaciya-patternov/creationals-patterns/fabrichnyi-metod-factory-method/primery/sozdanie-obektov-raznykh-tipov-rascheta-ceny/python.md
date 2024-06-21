# Python

Допустим, ваша команда разрабатывает интернет-магазин, в котором есть несколько типов товаров (одежда, обувь, электроника и т.д.). Для каждого типа товара нужно рассчитывать цену по-разному. Вы хотите реализовать создание объектов, отвечающих за расчет цены, в зависимости от типа товара.

Для решения этой задачи вы решаете использовать паттерн "Фабричный метод". Для начала создаете интерфейс PriceCalculator, который будет содержать метод calculate\_price(). Этот интерфейс будет определять общий функционал для всех типов расчета цены.

{% code overflow="wrap" lineNumbers="true" %}
```python
from abc import ABC, abstractmethod

class PriceCalculator(ABC):
    @abstractmethod
    def calculate_price(self, base_price: float) -> float:
        pass
```
{% endcode %}

Затем реализуете этот интерфейс для каждого типа товара (одежда, обувь, электроника и т.д.):

<pre class="language-python" data-overflow="wrap" data-line-numbers><code class="lang-python"><strong>class ClothingPriceCalculator(PriceCalculator):
</strong>    def calculate_price(self, base_price: float) -> float:
        return base_price * 1.2  # Наценка 20% для одежды
</code></pre>

{% code overflow="wrap" lineNumbers="true" %}
```python
class ShoesPriceCalculator(PriceCalculator):
    def calculate_price(self, base_price: float) -> float:
        return base_price * 1.23  # Наценка 23% для обыви
```
{% endcode %}

{% code overflow="wrap" lineNumbers="true" %}
```python
class ElectronicsPriceCalculator(PriceCalculator):
    def calculate_price(self, base_price: float) -> float:
        return base_price * 1.25  # Наценка 25% для электроники
```
{% endcode %}

Далее создаете фабрику PriceCalculatorFactory, которая будет создавать объекты для расчета цены в зависимости от типа товара, переданного в метод create\_price\_calculator(). Этот метод будет возвращать объект типа PriceCalculator.

{% code overflow="wrap" lineNumbers="true" %}
```python
class PriceCalculatorFactory:
    @staticmethod
    def create_price_calculator(product_type: str) -> PriceCalculator:
        if product_type == "clothing":
            return ClothingPriceCalculator()
        elif product_type == "shoes":
            return ShoesPriceCalculator()
        elif product_type == "electronics":
            return ElectronicsPriceCalculator()
        else:
            raise ValueError("Неверный тип товара")
```
{% endcode %}

В итоге, когда клиент выбирает товар, ваше приложение использует фабрику для создания объекта, отвечающего за расчет цены, и вызывает метод calculate\_price() для расчета цены товара.

Диаграмма классов для этого кейса:

<figure><img src="../../../../../.gitbook/assets/image (36).png" alt=""><figcaption><p>UML диаграмма для паттерна "Фабричный метод"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
abstract class PriceCalculator {
    +calculate_price(base_price: float): float
}

class ClothingPriceCalculator extends PriceCalculator {
    +calculate_price(base_price: float): float
}

class ShoesPriceCalculator extends PriceCalculator {
    +calculate_price(base_price: float): float
}

class ElectronicsPriceCalculator extends PriceCalculator {
    +calculate_price(base_price: float): float
}

class PriceCalculatorFactory {
    +create_price_calculator(type: string): PriceCalculator
}

PriceCalculatorFactory --> PriceCalculator: create_price_calculator
PriceCalculator <|-- ClothingPriceCalculator
PriceCalculator <|-- ShoesPriceCalculator
PriceCalculator <|-- ElectronicsPriceCalculator
@enduml
```
{% endcode %}
