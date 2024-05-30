# PHP

<figure><img src="../../../../../.gitbook/assets/image (5).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Абстрактная фабрика" в аналитической системе для формирования отчета</p></figcaption></figure>

Кейс:

Наша компания разрабатывает аналитическую систему, которая должна формировать отчеты о двух типах данных - пользователях (UserData) и продажах (SalesData). Отчеты должны быть доступны в трех форматах - JSON, XML и CSV. Кроме того, мы хотим, чтобы наша система была гибкой и легко расширяемой, чтобы в будущем мы могли добавлять новые типы отчетов и форматы без значительных изменений в существующем коде.

Решение:

Для решения этой задачи мы решили использовать паттерн "Абстрактная фабрика". Этот паттерн предоставляет интерфейс для создания семейств взаимосвязанных или взаимозависимых объектов, не специфицируя их конкретные классы.

Код:

1. Определяем интерфейсы:

Сначала мы определяем два интерфейса - `DataFactory` и `DataType`. Интерфейс `DataFactory` содержит один метод `createData()`, который должен возвращать объект, реализующий интерфейс `DataType`. Интерфейс `DataType` содержит два метода - `getData()` и `setFormat($format)`. Метод `getData()` должен возвращать отчет в выбранном формате, а метод `setFormat($format)` устанавливает формат отчета.

```php
interface DataFactory {
    public function createData(): DataType;
}

interface DataType {
    public function getData();
    public function setFormat($format);
}
```

2. Реализуем конкретные фабрики:

Затем мы реализуем две конкретные фабрики - `UserDataFactory` и `SalesDataFactory`, которые реализуют интерфейс `DataFactory`. Метод `createData()` в каждой фабрике возвращает объект конкретного типа данных - `UserData` или `SalesData`.

```php
class UserDataFactory implements DataFactory {
    public function createData(): DataType {
        return new UserData();
    }
}

class SalesDataFactory implements DataFactory {
    public function createData(): DataType {
        return new SalesData();
    }
}
```

3. Реализуем конкретные типы данных:

Далее мы реализуем два конкретных типа данных - `UserData` и `SalesData`, которые реализуют интерфейс `DataType`. В каждом типе данных мы реализуем методы `getData()` и `setFormat($format)`. Метод `getData()` формирует отчет о данных в выбранном формате с помощью стандартных функций PHP `json_encode()`, `xml_encode()` и `fputcsv()`. Метод `setFormat($format)` устанавливает формат отчета.

```php
class UserData implements DataType {
    private $format;
    private $userData = [];

    public function getData() {
        switch ($this->format) {
            case 'JSON':
                return json_encode($this->userData);
            case 'XML':
                return xml_encode($this->userData);
            case 'CSV':
                $this->toCSV();
                break;
        }
    }

    public function setFormat($format) {
        $this->format = $format;
    }

    private function toCSV() {
        $file = fopen('php://output', 'w');
        fputcsv($file, array_keys($this->userData[0]));
        foreach ($this->userData as $row) {
            fputcsv($file, $row);
        }
        fclose($file);
    }
}

class SalesData implements DataType {
    private $format;
    private $salesData = [];

    public function getData() {
        switch ($this->format) {
            case 'JSON':
                return json_encode($this->salesData);
            case 'XML':
                return xml_encode($this->salesData);
            case 'CSV':
                $this->toCSV();
                break;
        }
    }

    public function setFormat($format) {
        $this->format = $format;
    }

    private function toCSV() {
        $file = fopen('php://output', 'w);
        fputcsv($file, array_keys($this->salesData[0]);
        foreach ($this->salesData as $row) {
            fputcsv($file, $row);
        }
        fclose($file);
    }
}
```

4. Реализуем класс для формирования отчетов:

Наконец, мы реализуем класс `Report`, который использует интерфейсы `DataFactory` и `DataType` для формирования отчетов. В классе `Report` мы определяем два поля - `factory` и `data`, которые соответствуют фабрике и типу данных, используемым для формирования отчета. Мы также определяем три метода - конструктор `__construct(DataFactory $factory)`, метод `generateReport()`, который формирует и возвращает отчет, и метод `setFormat($format)`, который устанавливает формат отчета.

```php
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
```

5. Используем класс `Report` для формирования отчетов:

В конце мы создаем два отчета - `userDataReport` и `salesDataReport`, используя класс `Report` и соответствующие фабрики. Затем мы устанавливаем формат отчетов с помощью метода `setFormat($format)` и формируем отчеты с помощью метода `generateReport()`.

```php
$userDataReport = new Report(new UserDataFactory());
$userDataReport->setFormat('JSON');
echo $userDataReport->generateReport();

$salesDataReport = new Report(new SalesDataFactory());
$salesDataReport->setFormat('XML');
echo $salesDataReport->generateReport();
```

Надеюсь, этот пример поможет вам лучше понять, как можно реализовать паттерн "Абстрактная фабрика" на PHP и как он может быть полезен в разработке гибких и расширяемых систем.

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
