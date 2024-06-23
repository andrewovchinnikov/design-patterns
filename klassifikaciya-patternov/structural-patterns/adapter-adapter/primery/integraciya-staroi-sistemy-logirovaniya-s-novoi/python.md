# Python

У вас есть старая система логирования, которая использует свой собственный формат записей. Этот формат может быть, например, текстовым или XML. Новая система, с которой вы хотите интегрироваться, ожидает логи в формате JSON. Вам нужно преобразовать логи из старого формата в новый формат JSON, не изменяя при этом саму старую систему логирования.

Паттерн Адаптер позволяет объектам с несовместимыми интерфейсами работать вместе. В данном случае, адаптер будет преобразовывать вывод старой системы логирования в формат, который ожидает новая система.

1. **Определение интерфейса для новой системы**: Создадим интерфейс, который ожидает новая система. Этот интерфейс будет включать метод для логирования в формате JSON.

{% code overflow="wrap" lineNumbers="true" %}
```python
# Интерфейс для новой системы логирования
class JsonLoggerInterface:
    def log_to_json(self, data):
        pass

```
{% endcode %}

{% code overflow="wrap" lineNumbers="true" %}
```python
// Старая система логирования
# Старая система логирования
class OldLogger:
    def log_old_format(self, data):
        return f"Old Format: {data}"
```
{% endcode %}

2. **Создание адаптера**: Адаптер будет реализовывать этот интерфейс и использовать старую систему логирования для получения данных в старом формате, а затем преобразовывать их в JSON.

{% code overflow="wrap" lineNumbers="true" %}
```python
# Адаптер для преобразования старого формата в JSON
class LoggerAdapter(JsonLoggerInterface):
    def __init__(self, old_logger):
        self.old_logger = old_logger

    def log_to_json(self, data):
        old_format_data = self.old_logger.log_old_format(data)
        json_data = json.dumps({"log": old_format_data})
        return json_data
```
{% endcode %}

3. **Использование адаптера в новой системе**: Новая система будет использовать адаптер для логирования, не зная о том, что данные приходят из старой системы.

{% code overflow="wrap" lineNumbers="true" %}
```php
// Пример использования
$oldLogger = new OldLogger();
$loggerAdapter = new LoggerAdapter($oldLogger);

$data = "Sample log data";
e// Пример использования
func main() {
	oldLogger := &OldLogger{}
	loggerAdapter := &LoggerAdapter{OldLogger: oldLogger}

	data := "Sample log data"
	fmt.Println(loggerAdapter.LogToJson(data))
}
```
{% endcode %}

UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (46).png" alt=""><figcaption><p>UML диаграмма для паттерна "Адаптер"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
interface JsonLoggerInterface {
    +log_to_json($data)
}

class OldLogger {
    +log_old_format($data)
}

class LoggerAdapter {
    -old_logger: OldLogger
    +log_to_json($data)
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
