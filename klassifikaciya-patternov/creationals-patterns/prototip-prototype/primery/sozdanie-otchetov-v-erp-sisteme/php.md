# PHP

<figure><img src="../../../../../.gitbook/assets/image (20).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Прототип"</p></figcaption></figure>

Тимлид поставил задачу на разработку модуля для создания и редактирования отчетов в ERP системе. Разработчик, которому была поручена эта задача, решил использовать паттерн Прототип для создания новых отчетов на основе существующих.

Причина выбора паттерна Прототип заключается в том, что создание новых отчетов с нуля может быть очень трудоемким и временем затратным процессом. Кроме того, многие отчеты могут иметь схожий дизайн и структуру, поэтому создание новых отчетов на основе существующих может значительно ускорить процесс разработки.

Для реализации паттерна Прототип в PHP, разработчик создал абстрактный класс `Report`, который содержит общую логику для всех отчетов. Затем, он создал два конкретных класса `SalesReport` и `InventoryReport`, которые наследуются от `Report` и предоставляют свои собственные реализации метода `clone()`.

Вот пример кода для реализации паттерна Прототип в PHP:

#### Базовый класс для всех отчетов

{% code overflow="wrap" lineNumbers="true" %}
```php
abstract class Report
{
    protected $title;
    protected $data;

    public function __construct($title, $data)
    {
        $this->title = $title;
        $this->data = $data;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getData()
    {
        return $this->data;
    }

    // Метод для клонирования отчета
    abstract public function clone();
}
```
{% endcode %}

Этот класс содержит общую логику для всех отчетов. В частности, он содержит свойства `title` и `data`, которые представляют заголовок и данные отчета соответственно. Кроме того, он содержит методы `getTitle()` и `getData()`, которые позволяют получить значения этих свойств.

Абстрактный метод `clone()` должен быть реализован в конкретных классах отчетов, чтобы обеспечить правильное клонирование объектов.

#### Отчет по продажам

{% code overflow="wrap" lineNumbers="true" %}
```php
class SalesReport extends Report
{
    public function __construct($title, $data)
    {
        parent::__construct($title, $data);
    }

    // Метод для клонирования отчета по продажам
    public function clone()
    {
        return new SalesReport($this->title, $this->data);
    }
}

```
{% endcode %}

Этот класс наследуется от базового класса `Report` и предоставляет свою собственную реализацию метода `clone()`. В частности, он создает новый объект `SalesReport` с теми же значениями `title` и `data`, что и у исходного объекта.

#### Отчет по остаткам на складе

{% code overflow="wrap" lineNumbers="true" %}
```php
class InventoryReport extends Report
{
    public function __construct($title, $data)
    {
        parent::__construct($title, $data);
    }

    // Метод для клонирования отчета по остаткам на складе
    public function clone()
    {
        return new InventoryReport($this->title, $this->data);
    }
}
```
{% endcode %}

Этот класс также наследуется от базового класса `Report` и предоставляет свою собственную реализацию метода `clone()`. В частности, он создает новый объект `InventoryReport` с теми же значениями `title` и `data`, что и у исходного объекта.

{% code overflow="wrap" lineNumbers="true" %}
```php
class ReportFactory
{
    private $prototypes;

    public function __construct()
    {
        $this->prototypes = [
            'sales' => new SalesReport('Sales Report', []),
            'inventory' => new InventoryReport('Inventory Report', []),
        ];
    }

    // Метод для создания нового отчета на основе существующего
    public function createReport($type, $title, $data)
    {
        $report = clone $this->prototypes[$type];
        $report->title = $title;
        $report->data = $data;
        return $report;
    }
}

```
{% endcode %}

{% code overflow="wrap" lineNumbers="true" %}
```php
/ Создаем новый отчет по продажам на основе существующего
$factory = new ReportFactory();
$report = $factory->createReport('sales', 'New Sales Report', [1, 2, 3]);
echo $report->getTitle();
print_r($report->getData());

// Создаем новый отчет по остаткам на складе на основе существующего
$report = $factory->createReport('inventory', 'New Inventory Report', ['apple' => 10, 'banana' => 20]);
echo $report->getTitle();
print_r($report->getData());
```
{% endcode %}

Этот класс использует паттерн Прототип для создания новых отчетов на основе существующих. В частности, он содержит свойство `prototypes`, которое представляет собой массив объектов прототипов отчетов. В конструкторе он создает объекты прототипов `SalesReport` и `InventoryReport`.

Метод `createReport()` выполняет клонирование объекта прототипа и возвращает новый объект отчета. В частности, он получает тип отчета (`sales` или `inventory`), заголовок и данные отчета в качестве параметров. Затем он клонирует объект прототипа с помощью оператора `clone` и устанавливает заголовок и данные отчета для нового объекта. Наконец, он возвращает новый объект отчета.

Использование паттерна Прототип позволило разработчику значительно ускорить процесс создания новых отчетов в ERP системе и упростить код за счет использования клонирования объектов.
