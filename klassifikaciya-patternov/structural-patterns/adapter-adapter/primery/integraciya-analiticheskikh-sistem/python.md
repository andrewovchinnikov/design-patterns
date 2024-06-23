# Python

У нас есть аналитическая система, которая должна получать данные из трех различных источников: Яндекс Метрики, Roistat и Bitrix24. Каждый из этих источников предоставляет данные в своем собственном формате. Наша задача — создать единый интерфейс для получения данных из всех источников, чтобы аналитическая система могла работать с ними одинаково.

Паттерн Адаптер позволяет нам преобразовать интерфейс одного класса в интерфейс другого, который ожидают клиенты. Это особенно полезно, когда у нас есть несколько источников данных с разными интерфейсами, и мы хотим предоставить единый способ доступа к этим данным.

1.  **Создание интерфейса DataSourceInterface**:\
    Этот интерфейс будет определять метод `getData()`, который должен быть реализован всеми источниками данных.

    {% code overflow="wrap" lineNumbers="true" %}
    ```python
    # DataSourceInterface определяет интерфейс для получения данных
    class DataSourceInterface(ABC):
        @abstractmethod
        def get_data(self):
            pass
    ```
    {% endcode %}
2.  **Создание классов для каждого источника данных**:

    * `YandexMetrikaDataSource`
    * `RoistatDataSource`
    * `Bitrix24DataSource`

    {% code overflow="wrap" lineNumbers="true" %}
    ```python
    # YandexMetrikaDataSource представляет источник данных из Яндекс Метрики
    class YandexMetrikaDataSource:
        def fetch_data(self):
            return {
                "source": "Yandex Metrika",
                "data": {
                    "visits": 1000,
                    "pageviews": 2000
                }
            }

    # RoistatDataSource представляет источник данных из Roistat
    class RoistatDataSource:
        def retrieve_data(self):
            return {
                "source": "Roistat",
                "data": {
                    "leads": 50,
                    "cost": 1000
                }
            }

    # Bitrix24DataSource представляет источник данных из Bitrix24
    class Bitrix24DataSource:
        def get_bitrix_data(self):
            return {
                "source": "Bitrix24",
                "data": {
                    "deals": 30,
                    "tasks": 150
                }
            }
    ```
    {% endcode %}
3.  **Создание адаптеров для каждого источника данных**:

    * `YandexMetrikaAdapter`
    * `RoistatAdapter`
    * `Bitrix24Adapter`

    {% code overflow="wrap" lineNumbers="true" %}
    ```python
    # YandexMetrikaAdapter адаптирует YandexMetrikaDataSource к DataSourceInterface
    class YandexMetrikaAdapter(DataSourceInterface):
        def __init__(self, data_source):
            self.data_source = data_source

        def get_data(self):
            data = self.data_source.fetch_data()
            return {
                "source": data["source"],
                "visits": data["data"]["visits"],
                "pageviews": data["data"]["pageviews"]
            }

    # RoistatAdapter адаптирует RoistatDataSource к DataSourceInterface
    class RoistatAdapter(DataSourceInterface):
        def __init__(self, data_source):
            self.data_source = data_source

        def get_data(self):
            data = self.data_source.retrieve_data()
            return {
                "source": data["source"],
                "leads": data["data"]["leads"],
                "cost": data["data"]["cost"]
            }

    # Bitrix24Adapter адаптирует Bitrix24DataSource к DataSourceInterface
    class Bitrix24Adapter(DataSourceInterface):
        def __init__(self, data_source):
            self.data_source = data_source

        def get_data(self):
            data = self.data_source.get_bitrix_data()
            return {
                "source": data["source"],
                "deals": data["data"]["deals"],
                "tasks": data["data"]["tasks"]
            }
    ```
    {% endcode %}
4.  **Использование адаптеров в клиентском коде**:

    {% code overflow="wrap" lineNumbers="true" %}
    ```python
    # client_code представляет клиентский код, который работает с DataSourceInterface
    def client_code(data_source):
        print(data_source.get_data())

    # Использование адаптеров в клиентском коде
    yandex_metrika_data_source = YandexMetrikaDataSource()
    yandex_metrika_adapter = YandexMetrikaAdapter(yandex_metrika_data_source)

    roistat_data_source = RoistatDataSource()
    roistat_adapter = RoistatAdapter(roistat_data_source)

    bitrix24_data_source = Bitrix24DataSource()
    bitrix24_adapter = Bitrix24Adapter(bitrix24_data_source)

    client_code(yandex_metrika_adapter)
    client_code(roistat_adapter)
    client_code(bitrix24_adapter)
    ```
    {% endcode %}

**UML диаграмма**

<figure><img src="../../../../../.gitbook/assets/image (49).png" alt=""><figcaption><p>UML диаграмма для паттерна "Адаптер"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
interface DataSourceInterface {
    +get_data(): dict
}

class YandexMetrikaDataSource {
    +fetch_data(): dict
}

class RoistatDataSource {
    +retrieve_data(): dict
}

class Bitrix24DataSource {
    +get_bitrix_data(): dict
}

class YandexMetrikaAdapter {
    -data_source: YandexMetrikaDataSource
    +__init__(YandexMetrikaDataSource)
    +get_data(): dict
}

class RoistatAdapter {
    -data_source: RoistatDataSource
    +__init__(RoistatDataSource)
    +get_data(): dict
}

class Bitrix24Adapter {
    -data_source: Bitrix24DataSource
    +__init__(Bitrix24DataSource)
    +get_data(): dict
}

DataSourceInterface <|.. YandexMetrikaAdapter
DataSourceInterface <|.. RoistatAdapter
DataSourceInterface <|.. Bitrix24Adapter

YandexMetrikaAdapter --> YandexMetrikaDataSource
RoistatAdapter --> RoistatDataSource
Bitrix24Adapter --> Bitrix24DataSource
@enduml
```
{% endcode %}

**Объяснение**

1. **Интерфейс `DataSourceInterface`**: Определяет метод `GetData()`, который должен возвращать данные в едином формате.
2. **Классы источников данных**:
   * `YandexMetrikaDataSource` с методом `FetchData()`.
   * `RoistatDataSource` с методом `RetrieveData()`.
   * `Bitrix24DataSource` с методом `GetBitrixData()`.
3. **Адаптеры**:
   * `YandexMetrikaAdapter` с приватным свойством `DataSource` и методом `GetData()`.
   * `RoistatAdapter` с приватным свойством `DataSource` и методом `GetData()`.
   * `Bitrix24Adapter` с приватным свойством `DataSource` и методом `GetData()`.

Связи между элементами показывают, что адаптеры реализуют интерфейс `DataSourceInterface` и используют соответствующие источники данных для получения и преобразования данных.
