# PHP

У вас есть старая система логирования, которая использует свой собственный формат записей. Этот формат может быть, например, текстовым или XML. Новая система, с которой вы хотите интегрироваться, ожидает логи в формате JSON. Вам нужно преобразовать логи из старого формата в новый формат JSON, не изменяя при этом саму старую систему логирования.

Паттерн Адаптер позволяет объектам с несовместимыми интерфейсами работать вместе. В данном случае, адаптер будет преобразовывать вывод старой системы логирования в формат, который ожидает новая система.

1. **Определение интерфейса для новой системы**: Создадим интерфейс, который ожидает новая система. Этот интерфейс будет включать метод для логирования в формате JSON.

{% code overflow="wrap" lineNumbers="true" %}
```php
// Интерфейс для новой системы логирования
interface JsonLoggerInterface {
    public function logToJson($data);
}
```
{% endcode %}

{% code overflow="wrap" lineNumbers="true" %}
```php
// Старая система логирования
class OldLogger {
    public function logOldFormat($data) {
        return "Old Format: " . $data;
    }
}
```
{% endcode %}

2. **Создание адаптера**: Адаптер будет реализовывать этот интерфейс и использовать старую систему логирования для получения данных в старом формате, а затем преобразовывать их в JSON.

{% code overflow="wrap" lineNumbers="true" %}
```php
// Адаптер для преобразования старого формата в JSON
class LoggerAdapter implements JsonLoggerInterface {
    private $oldLogger;

    public function __construct(OldLogger $oldLogger) {
        $this->oldLogger = $oldLogger;
    }

    public function logToJson($data) {
        $oldFormatData = $this->oldLogger->logOldFormat($data);
        $jsonData = json_encode(["log" => $oldFormatData]);
        return $jsonData;
    }
}
```
{% endcode %}

3. **Использование адаптера в новой системе**: Новая система будет использовать адаптер для логирования, не зная о том, что данные приходят из старой системы.

{% code overflow="wrap" lineNumbers="true" %}
```php
// Пример использования
$oldLogger = new OldLogger();
$loggerAdapter = new LoggerAdapter($oldLogger);

$data = "Sample log data";
echo $loggerAdapter->logToJson($data);
?>
```
{% endcode %}

UML диаграмма

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
interface JsonLoggerInterface {
    +logToJson($data)
}

class OldLogger {
    +logOldFormat($data)
}

class LoggerAdapter {
    -oldLogger: OldLogger
    +__construct(OldLogger)
    +logToJson($data)
}

JsonLoggerInterface <|.. LoggerAdapter
LoggerAdapter o-- OldLogger
@enduml
```
{% endcode %}

* **JsonLoggerInterface**: Интерфейс, который ожидает новая система.
* **OldLogger**: Старая система логирования, которая использует свой собственный формат.
* **LoggerAdapter**: Адаптер, который реализует интерфейс `JsonLoggerInterface` и использует `OldLogger` для преобразования данных в JSON.

Этот подход позволяет интегрировать старую систему логирования с новой системой, не изменяя код старой системы, и использует паттерн Адаптер для обеспечения совместимости.
