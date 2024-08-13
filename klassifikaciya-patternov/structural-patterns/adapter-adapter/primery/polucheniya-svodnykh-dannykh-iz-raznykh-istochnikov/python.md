# Python

У нас есть два источника бизнес данных: `https://pb.nalog.ru/` и `https://dadata.ru/`. Каждый из этих источников предоставляет данные в своем собственном формате. Наша задача — предоставить единый интерфейс для получения сводных данных из этих источников. Это означает, что независимо от того, какой источник данных мы используем, мы должны получать данные в одном и том же формате.

Паттерн Адаптер (Adapter) используется для преобразования интерфейса одного класса в интерфейс другого, который ожидают клиенты. Это позволяет классам с несовместимыми интерфейсами работать вместе. В нашем случае, каждый источник данных имеет свой собственный формат данных, и мы хотим, чтобы они выглядели как имеющие один и тот же интерфейс. Использование паттерна Адаптер позволяет нам создать обертки (адаптеры) для каждого источника данных, которые будут преобразовывать данные в единый формат.

{% code overflow="wrap" lineNumbers="true" %}
```python
# Интерфейс для получения данных
class DataSourceInterface(ABC):
    @abstractmethod
    def get_data(self):
        pass
```
{% endcode %}

1. **Интерфейс `DataSourceInterface`**: Определяет метод `getData()`, который должен возвращать данные в едином формате.

{% code overflow="wrap" lineNumbers="true" %}
```python
# Класс для работы с данными из pb.nalog.ru
class NalogRuDataSource:
    def fetch_data(self):
        return {
            "source": "nalog.ru",
            "data": {
                "company": "ООО Рога и Копыта",
                "inn": "1234567890"
            }
        }
```
{% endcode %}

{% code overflow="wrap" lineNumbers="true" %}
```python
# Класс для работы с данными из dadata.ru
class DadataRuDataSource:
    def retrieve_data(self):
        return {
            "source": "dadata.ru",
            "data": {
                "company": "ООО Рога и Копыта",
                "inn": "1234567890"
            }
        }
```
{% endcode %}

2. **Классы `NalogRuDataSource` и `DadataRuDataSource`**: Реализуют логику для получения данных из соответствующих источников.

{% code overflow="wrap" lineNumbers="true" %}
```python
# Адаптер для NalogRuDataSource
class NalogRuAdapter(DataSourceInterface):
    def __init__(self, nalog_ru_data_source):
        self.nalog_ru_data_source = nalog_ru_data_source

    def get_data(self):
        data = self.nalog_ru_data_source.fetch_data()
        return {
            "source": data["source"],
            "company": data["data"]["company"],
            "inn": data["data"]["inn"]
        }
```
{% endcode %}

{% code overflow="wrap" lineNumbers="true" %}
```python
# Адаптер для DadataRuDataSource
class DadataRuAdapter(DataSourceInterface):
    def __init__(self, dadata_ru_data_source):
        self.dadata_ru_data_source = dadata_ru_data_source

    def get_data(self):
        data = self.dadata_ru_data_source.retrieve_data()
        return {
            "source": data["source"],
            "company": data["data"]["company"],
            "inn": data["data"]["inn"]
        }
```
{% endcode %}

3. **Адаптеры `NalogRuAdapter` и `DadataRuAdapter`**: Реализуют интерфейс `DataSourceInterface` и преобразуют данные из источников в единый формат.

{% code overflow="wrap" lineNumbers="true" %}
```python
# Клиентский код
def client_code(data_source):
    print(data_source.get_data())

# Пример использования
nalog_ru_data_source = NalogRuDataSource()
nalog_ru_adapter = NalogRuAdapter(nalog_ru_data_source)

dadata_ru_data_source = DadataRuDataSource()
dadata_ru_adapter = DadataRuAdapter(dadata_ru_data_source)

client_code(nalog_ru_adapter)
client_code(dadata_ru_adapter)
```
{% endcode %}

4. **Функция `client_code`**: Принимает объект, реализующий `DataSourceInterface`, и вызывает метод `get_data()`.

UML диаграмма классов

<figure><img src="../../../../../.gitbook/assets/image (2) (1) (1).png" alt=""><figcaption><p>UML диаграмма для паттерна "Адаптер"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
interface DataSourceInterface {
    +get_data(): dict
}

class NalogRuDataSource {
    +fetch_data(): dict
}

class DadataRuDataSource {
    +retrieve_data(): dict
}

class NalogRuAdapter {
    -nalog_ru_data_source: NalogRuDataSource
    +__init__(NalogRuDataSource)
    +get_data(): dict
}

class DadataRuAdapter {
    -dadata_ru_data_source: DadataRuDataSource
    +__init__(DadataRuDataSource)
    +get_data(): dict
}

DataSourceInterface <|.. NalogRuAdapter
DataSourceInterface <|.. DadataRuAdapter

NalogRuAdapter --> NalogRuDataSource
DadataRuAdapter --> DadataRuDataSource
@enduml
```
{% endcode %}

Этот подход позволяет нам работать с разными источниками данных, не меняя клиентский код, что делает систему более гибкой и легко расширяемой.
