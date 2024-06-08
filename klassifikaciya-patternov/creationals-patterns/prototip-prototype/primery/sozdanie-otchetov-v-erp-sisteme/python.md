# Python

<figure><img src="../../../../../.gitbook/assets/image (23).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Прототип"</p></figcaption></figure>

Тимлид поставил задачу на разработку модуля для создания и редактирования отчетов в ERP системе. Разработчик, которому была поручена эта задача, решил использовать паттерн Прототип для создания новых отчетов на основе существующих.

Причина выбора паттерна Прототип заключается в том, что создание новых отчетов с нуля может быть очень трудоемким и временем затратным процессом. Кроме того, многие отчеты могут иметь схожий дизайн и структуру, поэтому создание новых отчетов на основе существующих может значительно ускорить процесс разработки.

Для реализации паттерна Прототип в Go, разработчик создал абстрактный интерфейс Report, который содержит общую логику для всех отчетов. Затем, он создал два конкретных типа SalesReport и InventoryReport, которые реализуют интерфейс Report и предоставляют свои собственные реализации метода Clone().

Вот пример кода для реализации паттерна Прототип на Python:

#### Абстрактный класс Report:

{% code overflow="wrap" lineNumbers="true" %}
```python
from abc import ABC, abstractmethod

class Report(ABC):
    def __init__(self, title, data):
        self.title = title
        self.data = data

    @abstractmethod
    def clone(self):
        pass
```
{% endcode %}

Абстрактный класс Report является базовым классом для всех отчетов в ERP системе. Он содержит общую логику для всех отчетов, включая заголовок и данные отчета. В классе Report есть два свойства: title и data. Свойство title содержит заголовок отчета, а свойство data содержит данные отчета.

Конструктор класса Report принимает два аргумента: title и data. Он устанавливает значения этих аргументов для свойств title и data соответственно.

Метод clone() должен быть реализован в конкретных классах отчетов, чтобы обеспечить правильное клонирование объектов.

#### Конкретный класс SalesReport:

{% code overflow="wrap" lineNumbers="true" %}
```python
class SalesReport(Report):
    def __init__(self, title, data):
        super().__init__(title, data)

    def clone(self):
        return SalesReport(self.title, self.data.copy())

```
{% endcode %}

Конкретный класс SalesReport наследуется от базового класса Report и представляет отчет по продажам. Класс SalesReport переопределяет метод clone() базового класса Report, чтобы создать копию объекта SalesReport с теми же значениями title и data, что и у исходного объекта. Метод clone() использует метод copy() для создания копии списка данных, чтобы избежать изменения исходного списка при изменении копии.

#### Конкретный класс InventoryReport:

{% code overflow="wrap" lineNumbers="true" %}
```python
class InventoryReport(Report):
    def __init__(self, title, data):
        super().__init__(title, data)

    def clone(self):
        return InventoryReport(self.title, {k: v for k, v in self.data.items()})

```
{% endcode %}

Конкретный класс InventoryReport наследуется от базового класса Report и представляет отчет по остаткам на складе.&#x20;

Класс InventoryReport также переопределяет метод clone() базового класса Report, чтобы создать копию объекта InventoryReport с теми же значениями title и data, что и у исходного объекта. Метод clone() использует списочное включение для создания копии словаря данных, чтобы избежать изменения исходного словаря при изменении копии

#### Класс ReportFactory:

{% code overflow="wrap" lineNumbers="true" %}
```python
class ReportFactory:
    def __init__(self):
        self.prototypes = {
            'sales': SalesReport('Sales Report', []),
            'inventory': InventoryReport('Inventory Report', {}),
        }

    def create_report(self, report_type, title, data):
        prototype = self.prototypes[report_type]
        report = prototype.clone()
        report.title = title
        report.data = data
        return report

```
{% endcode %}

В классе ReportFactory есть одно свойство: prototypes. Свойство prototypes является словарём, где ключ — это тип отчета, а значение — это прототип отчета.

Метод create\_report() создаёт новый отчет на основе существующего прототипа. Он принимает три аргумента: report\_type, title и data. Аргумент report\_type указывает тип отчета, который нужно создать. Аргумент title устанавливает заголовок нового отчета. Аргумент data устанавливает данные нового отчета.

Метод create\_report() сначала получает прототип отчета из свойства prototypes. Затем он создает копию прототипа с помощью метода clone(). Затем он устанавливает заголовок и данные для нового отчета. Наконец, он возвращает новый отчет.

