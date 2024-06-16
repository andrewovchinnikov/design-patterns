# Python

<figure><img src="../../../../../.gitbook/assets/image (27).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Строитель"</p></figcaption></figure>

Задача кейса состоит в том, чтобы предоставить пользователям гибкий и удобный интерфейс для создания графиков с различными типами, опциями и характеристиками. Для этого мы используем паттерн "Строитель", который позволяет создавать сложные объекты пошагово. Это полезно, когда создание объекта требует много шагов или когда необходимо избежать "телескопического конструктора" (конструктора, который имеет много параметров).

### Код:&#x20;

#### Класс `Chart`

{% code overflow="wrap" lineNumbers="true" %}
```python
class Chart:
    def __init__(self):
        self.type = None
        self.color = None
        self.size = None
        self.axis_labels = None
        self.data = None

    def __str__(self):
        return f"Chart(type={self.type}, color={self.color}, size={self.size}, axis_labels={self.axis_labels}, data={self.data})"
```
{% endcode %}

Представляет собой график с различными атрибутами: тип, цвет, размер, подписи осей и данные.

* `__init__`: Инициализирует атрибуты графика.
* `__str__`: Возвращает строковое представление объекта графика для удобного вывода.

#### Абстрактный класс `ChartBuilder`

{% code overflow="wrap" lineNumbers="true" %}
```python
from abc import ABC, abstractmethod

class ChartBuilder(ABC):
    def __init__(self):
        self.chart = Chart()

    @abstractmethod
    def set_type(self):
        pass

    @abstractmethod
    def set_color(self):
        pass

    @abstractmethod
    def set_size(self):
        pass

    @abstractmethod
    def set_axis_labels(self):
        pass

    @abstractmethod
    def add_data(self):
        pass

    def get_chart(self):
        return self.chart
```
{% endcode %}

Определяет интерфейс для всех строителей.

* `__init__`: Инициализирует объект графика.
* `set_type`, `set_color`, `set_size`, `set_axis_labels`, `add_data`: Абстрактные методы, которые должны быть реализованы в конкретных строителях.
* `get_chart`: Возвращает готовый объект графика.

#### Конкретный класс `LineChartBuilder`

```python
class LineChartBuilder(ChartBuilder):
    def set_type(self):
        self.chart.type = "line"

    def set_color(self):
        self.chart.color = "blue"

    def set_size(self):
        self.chart.size = "large"

    def set_axis_labels(self):
        self.chart.axis_labels = ["X-axis", "Y-axis"]

    def add_data(self):
        self.chart.data = [1.0, 2.0, 3.0, 4.0, 5.0]
```

Конкретный строитель для линейного графика.

* `set_type`
* `set_color`
* `set_size`
* `set_axis_labels`
* `add_data`

Реализуют соответствующие методы интерфейса `ChartBuilder` для настройки линейного графика.

#### Конкретный класс `BarChartBuilder`

```python
class BarChartBuilder(ChartBuilder):
    def set_type(self):
        self.chart.type = "bar"

    def set_color(self):
        self.chart.color = "red"

    def set_size(self):
        self.chart.size = "medium"

    def set_axis_labels(self):
        self.chart.axis_labels = ["Category", "Value"]

    def add_data(self):
        self.chart.data = [10.0, 20.0, 30.0, 40.0, 50.0]
```

Конкретный строитель для столбчатого графика.

* `set_type`
* `set_color`
* `set_size`
* `set_axis_labels`
* `add_data`

Реализуют соответствующие методы интерфейса `ChartBuilder` для настройки столбчатого графика.

#### Конкретный класс `PieChartBuilder`

{% code overflow="wrap" lineNumbers="true" %}
```python
class PieChartBuilder(ChartBuilder):
    def set_type(self):
        self.chart.type = "pie"

    def set_color(self):
        self.chart.color = "green"

    def set_size(self):
        self.chart.size = "small"

    def set_axis_labels(self):
        self.chart.axis_labels = ["Slice 1", "Slice 2", "Slice 3"]

    def add_data(self):
        self.chart.data = [30.0, 40.0, 30.0]
```
{% endcode %}

Конкретный строитель для кругового графика.

* `set_type`
* `set_color`
* `set_size`
* `set_axis_labels`
* `add_data`

Реализуют соответствующие методы интерфейса `ChartBuilder` для настройки кругового графика.

#### Клиентский код

```python
def main():
    line_chart_builder = LineChartBuilder()
    line_chart_builder.set_type()
    line_chart_builder.set_color()
    line_chart_builder.set_size()
    line_chart_builder.set_axis_labels()
    line_chart_builder.add_data()
    line_chart = line_chart_builder.get_chart()
    print(line_chart)

    bar_chart_builder = BarChartBuilder()
    bar_chart_builder.set_type()
    bar_chart_builder.set_color()
    bar_chart_builder.set_size()
    bar_chart_builder.set_axis_labels()
    bar_chart_builder.add_data()
    bar_chart = bar_chart_builder.get_chart()
    print(bar_chart)

    pie_chart_builder = PieChartBuilder()
    pie_chart_builder.set_type()
    pie_chart_builder.set_color()
    pie_chart_builder.set_size()
    pie_chart_builder.set_axis_labels()
    pie_chart_builder.add_data()
    pie_chart = pie_chart_builder.get_chart()
    print(pie_chart)

if __name__ == "__main__":
    main()
```

Создает объекты строителей, настраивает их и получает готовые объекты `Chart`.

* `main`: Создает экземпляры строителей, вызывает методы для настройки графиков и выводит информацию о готовых графиках.

Таким образом, паттерн "Строитель" позволяет создавать сложные объекты пошагово, что делает код более гибким и удобным для использования.
