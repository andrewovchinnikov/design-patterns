# Copy of Copy of PHP

<figure><img src="../../../../../.gitbook/assets/image (1).png" alt=""><figcaption><p>UML диаграмма для примера применения абстрактной фабрики в платежной системе</p></figcaption></figure>

Кейс: Наша аналитическая система должна формировать отчеты о двух типах данных - пользователях (UserData) и продажах (SalesData). Отчеты должны быть доступны в трех форматах - JSON, XML и CSV. Мы хотим, чтобы наша система была гибкой и легко расширяемой, поэтому решили использовать паттерн "Абстрактная фабрика".\
\
В этом примере мы создали интерфейсы `DataFactory` и `DataType`. Конкретные фабрики `UserDataFactory` и `SalesDataFactory` реализуют интерфейс `DataFactory` и создают конкретные типы данных `UserData` и `SalesData`, которые реализуют интерфейс `DataType`.

Класс `Report` использует эти фабрики для формирования отчетов. Благодаря этому, если нам понадобится добавить новый тип данных или новый формат отчета, нам просто нужно будет создать новую фабрику или новый тип данных, а класс `Report` при этом не изменится.

{% code overflow="wrap" lineNumbers="true" fullWidth="false" %}
```php
<?php
// Интерфейсы

// Интерфейс для фабрик
interface DataFactory {
    public function createData();
}

// Интерфейс для типов данных
interface DataType {
    public function getData();
    public function setFormat($format);
}

// Конкретные фабрики

// Фабрика для данных пользователей
class UserDataFactory implements DataFactory {
    public function createData() {
        return new UserData();
    }
}

// Фабрика для данных продаж
class SalesDataFactory implements DataFactory {
    public function createData() {
        return new SalesData();
    }
}

// Конкретные типы данных

// Данные пользователей
class UserData implements DataType {
    private $format;

    // Здесь должна быть логика получения данных о пользователях
    public function getData() {
        // Форматирование данных в зависимости от выбранного формата
        if ($this->format == 'JSON') {
            return json_encode($this->userData);
        } elseif ($this->format == 'XML') {
            return xml_encode($this->userData);
        } elseif ($this->format == 'CSV') {
            return csv_encode($this->userData);
        }
    }

    public function setFormat($format) {
        $this->format = $format;
    }
}

// Данные продаж
class SalesData implements DataType {
    private $format;

    // Здесь должна быть логика получения данных о продажах
    public function getData() {
        // Форматирование данных в зависимости от выбранного формата
        if ($this->format == 'JSON') {
            return json_encode($this->salesData);
        } elseif ($this->format == 'XML') {
            return xml_encode($this->salesData);
        } elseif ($this->format == 'CSV') {
            return csv_encode($this->salesData);
        }
    }

    public function setFormat($format) {
        $this->format = $format;
    }
}

// Класс для формирования отчетов
class Report {
    private $factory;
    private $data;

    public function __construct(DataFactory $factory) {
        $this->factory = $factory;
    }

    public function generateReport() {
        $this->data = $this->factory->createData();
        // Здесь должна быть логика формирования отчета
        return $this->data->getData();
    }

    public function setFormat($format) {
        $this->data->setFormat($format);
    }
}

// Пример использования
$userDataReport = new Report(new UserDataFactory());
$userDataReport->setFormat('JSON');
echo $userDataReport->generateReport();

$salesDataReport = new Report(new SalesDataFactory());
$salesDataReport->setFormat('XML');
echo $salesDataReport->generateReport();
?>
```
{% endcode %}
