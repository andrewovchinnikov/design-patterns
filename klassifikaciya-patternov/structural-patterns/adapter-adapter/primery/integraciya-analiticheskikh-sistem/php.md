# PHP

У нас есть аналитическая система, которая должна получать данные из трех различных источников: Яндекс Метрики, Roistat и Bitrix24. Каждый из этих источников предоставляет данные в своем собственном формате. Наша задача — создать единый интерфейс для получения данных из всех источников, чтобы аналитическая система могла работать с ними одинаково.

Паттерн Адаптер позволяет нам преобразовать интерфейс одного класса в интерфейс другого, который ожидают клиенты. Это особенно полезно, когда у нас есть несколько источников данных с разными интерфейсами, и мы хотим предоставить единый способ доступа к этим данным.

1.  **Создание интерфейса DataSourceInterface**:\
    Этот интерфейс будет определять метод `getData()`, который должен быть реализован всеми источниками данных.

    {% code overflow="wrap" lineNumbers="true" %}
    ```php
    interface DataSourceInterface {
        public function getData(): array;
    }
    ```
    {% endcode %}
2.  **Создание классов для каждого источника данных**:

    * `YandexMetrikaDataSource`
    * `RoistatDataSource`
    * `Bitrix24DataSource`

    {% code overflow="wrap" lineNumbers="true" %}
    ```php
    class YandexMetrikaDataSource {
        public function fetchData(): array {
            // Логика для получения данных из Яндекс Метрики
            return [
                'source' => 'Yandex Metrika',
                'data' => [
                    'visits' => 1000,
                    'pageviews' => 2000
                ]
            ];
        }
    }

    class RoistatDataSource {
        public function retrieveData(): array {
            // Логика для получения данных из Roistat
            return [
                'source' => 'Roistat',
                'data' => [
                    'leads' => 50,
                    'cost' => 1000
                ]
            ];
        }
    }

    class Bitrix24DataSource {
        public function getBitrixData(): array {
            // Логика для получения данных из Bitrix24
            return [
                'source' => 'Bitrix24',
                'data' => [
                    'deals' => 30,
                    'tasks' => 150
                ]
            ];
        }
    }
    ```
    {% endcode %}
3.  **Создание адаптеров для каждого источника данных**:

    * `YandexMetrikaAdapter`
    * `RoistatAdapter`
    * `Bitrix24Adapter`

    {% code overflow="wrap" lineNumbers="true" %}
    ```php
    class YandexMetrikaAdapter implements DataSourceInterface {
        private $yandexMetrikaDataSource;

        public function __construct(YandexMetrikaDataSource $yandexMetrikaDataSource) {
            $this->yandexMetrikaDataSource = $yandexMetrikaDataSource;
        }

        public function getData(): array {
            $data = $this->yandexMetrikaDataSource->fetchData();
            return [
                'source' => $data['source'],
                'visits' => $data['data']['visits'],
                'pageviews' => $data['data']['pageviews']
            ];
        }
    }

    class RoistatAdapter implements DataSourceInterface {
        private $roistatDataSource;

        public function __construct(RoistatDataSource $roistatDataSource) {
            $this->roistatDataSource = $roistatDataSource;
        }

        public function getData(): array {
            $data = $this->roistatDataSource->retrieveData();
            return [
                'source' => $data['source'],
                'leads' => $data['data']['leads'],
                'cost' => $data['data']['cost']
            ];
        }
    }

    class Bitrix24Adapter implements DataSourceInterface {
        private $bitrix24DataSource;

        public function __construct(Bitrix24DataSource $bitrix24DataSource) {
            $this->bitrix24DataSource = $bitrix24DataSource;
        }

        public function getData(): array {
            $data = $this->bitrix24DataSource->getBitrixData();
            return [
                'source' => $data['source'],
                'deals' => $data['data']['deals'],
                'tasks' => $data['data']['tasks']
            ];
        }
    }
    ```
    {% endcode %}
4.  **Использование адаптеров в клиентском коде**:

    {% code overflow="wrap" lineNumbers="true" %}
    ```php
    function clientCode(DataSourceInterface $dataSource) {
        return $dataSource->getData();
    }

    $yandexMetrikaDataSource = new YandexMetrikaDataSource();
    $yandexMetrikaAdapter = new YandexMetrikaAdapter($yandexMetrikaDataSource);

    $roistatDataSource = new RoistatDataSource();
    $roistatAdapter = new RoistatAdapter($roistatDataSource);

    $bitrix24DataSource = new Bitrix24DataSource();
    $bitrix24Adapter = new Bitrix24Adapter($bitrix24DataSource);

    print_r(clientCode($yandexMetrikaAdapter));
    print_r(clientCode($roistatAdapter));
    print_r(clientCode($bitrix24Adapter));
    ```
    {% endcode %}

**UML диаграмма**

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1) (1) (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для паттерна "Адаптер"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
interface DataSourceInterface {
    +getData(): array
}

class YandexMetrikaDataSource {
    +fetchData(): array
}

class RoistatDataSource {
    +retrieveData(): array
}

class Bitrix24DataSource {
    +getBitrixData(): array
}

class YandexMetrikaAdapter {
    -yandexMetrikaDataSource: YandexMetrikaDataSource
    +__construct(YandexMetrikaDataSource)
    +getData(): array
}

class RoistatAdapter {
    -roistatDataSource: RoistatDataSource
    +__construct(RoistatDataSource)
    +getData(): array
}

class Bitrix24Adapter {
    -bitrix24DataSource: Bitrix24DataSource
    +__construct(Bitrix24DataSource)
    +getData(): array
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

1. **Интерфейс `DataSourceInterface`**:
   * Определяет метод `getData()`, который должен возвращать данные в едином формате.
2. **Классы источников данных**:
   * `YandexMetrikaDataSource`, `RoistatDataSource`, `Bitrix24DataSource` — каждый из этих классов реализует логику для получения данных из соответствующего источника.
3.  **Адаптеры**:

    * `YandexMetrikaAdapter`,&#x20;
    * `RoistatAdapter`,&#x20;
    * `Bitrix24Adapter`&#x20;

    каждый из этих адаптеров реализует интерфейс `DataSourceInterface` и преобразует данные из источника в единый формат.
4. **Клиентский код**:
   * Функция `clientCode` принимает объект, реализующий `DataSourceInterface`, и вызывает метод `getData()`. Это позволяет клиентскому коду работать с разными источниками данных одинаково, не зависимо от их внутренней реализации.

Использование паттерна Адаптер в данном случае позволяет нам легко добавлять новые источники данных или изменять существующие, не меняя клиентский код.
