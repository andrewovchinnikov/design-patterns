# PHP

<figure><img src="../../../../../.gitbook/assets/image (3) (1) (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Строитель"</p></figcaption></figure>

Задача этого кейса состоит в том, чтобы предоставить пользователям гибкий и удобный интерфейс для создания графиков с различными типами, опциями и характеристиками. Паттерн "Строитель" позволяет создавать объекты сложных объектов пошагово. Это полезно, когда создание объекта требует много шагов или когда необходимо избежать "телескопического конструктора" (конструктора, который имеет много параметров).

В данном случае мы создаем класс `Chart`, который представляет собой график. Мы хотим предоставить пользователям возможность создавать графики различных типов с различными опциями. Для этого мы используем паттерн "Строитель".

### Вот как это может выглядеть в коде:&#x20;

#### Базовый класс для создания графика

{% code overflow="wrap" lineNumbers="true" %}
```php
abstract class ChartBuilder {
    protected $chart;

    public function createNewChart() {
        $this->chart = new Chart();
    }

    public function getChart() {
        return $this->chart;
    }

    abstract public function setType();
    abstract public function setColor();
    abstract public function setSize();
    abstract public function setAxisLabels();
    abstract public function addData();
}
```
{% endcode %}

#### Конкретный класс Builder для создания линейного графика

{% code overflow="wrap" lineNumbers="true" %}
```php
class LineChartBuilder extends ChartBuilder {
    public function setType() {
        $this->chart->setType('line');
    }
}
```
{% endcode %}

#### Конкретный класс Builder для создания столбчатого графика

{% code overflow="wrap" lineNumbers="true" %}
```php
class BarChartBuilder extends ChartBuilder {
    public function setType() {
        $this->chart->setType('bar');
    }
}
```
{% endcode %}

#### Конкретный класс Builder для создания кругового графика

{% code overflow="wrap" lineNumbers="true" %}
```php
class PieChartBuilder extends ChartBuilder {
    public function setType() {
        $this->chart->setType('pie');
    }
}
```
{% endcode %}

#### Класс, представляющий собой график

{% code overflow="wrap" lineNumbers="true" %}
```php
class Chart {
    protected $type;
    protected $color;
    protected $size;
    protected $axisLabels;
    protected $data;

    public function setType($type) {
        $this->type = $type;
    }
}
```
{% endcode %}

#### Клиентский код, использующий паттерн "Строитель"

{% code overflow="wrap" lineNumbers="true" %}
```php
// Клиентский код, использующий паттерн "Строитель"
$lineChartBuilder = new LineChartBuilder();
$lineChartBuilder->createNewChart();
$lineChartBuilder->setType();
$lineChartBuilder->setColor();
$lineChartBuilder->setSize();
$lineChartBuilder->setAxisLabels();
$lineChartBuilder->addData();
$lineChart = $lineChartBuilder->getChart();
```
{% endcode %}

В этом примере мы используем паттерн "Строитель" для создания объектов графика. Мы создаем базовый класс `ChartBuilder`, который определяет общий интерфейс для всех строителей. Затем мы создаем конкретные строители для каждого типа графика (`LineChartBuilder`, `BarChartBuilder`, `PieChartBuilder`). Каждый строитель реализует методы для установки типа, цвета, размера, подписей осей и добавления данных.

Клиентский код создает объект `LineChartBuilder`, настраивает его и получает готовый объект `Chart`. Таким образом, мы можем создавать графики различных типов с различными опциями, используя один и тот же код для создания объектов.
