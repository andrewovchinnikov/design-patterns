# PH

У нас есть два источника бизнес данных: `https://pb.nalog.ru/` и `https://dadata.ru/`. Каждый из этих источников предоставляет данные в своем собственном формате. Наша задача — предоставить единый интерфейс для получения сводных данных из этих источников. Это означает, что независимо от того, какой источник данных мы используем, мы должны получать данные в одном и том же формате.

Паттерн Адаптер (Adapter) используется для преобразования интерфейса одного класса в интерфейс другого, который ожидают клиенты. Это позволяет классам с несовместимыми интерфейсами работать вместе. В нашем случае, каждый источник данных имеет свой собственный формат данных, и мы хотим, чтобы они выглядели как имеющие один и тот же интерфейс. Использование паттерна Адаптер позволяет нам создать обертки (адаптеры) для каждого источника данных, которые будут преобразовывать данные в единый формат.

{% code overflow="wrap" lineNumbers="true" %}
```php
// Интерфейс, который ожидает клиент
interface DataSourceInterface {
    public function getData(): array;
}
```
{% endcode %}

1. **Интерфейс `DataSourceInterface`**: Определяет метод `getData()`, который должен возвращать данные в едином формате.

{% code overflow="wrap" lineNumbers="true" %}
```php
// Класс для работы с данными из pb.nalog.ru
class NalogRuDataSource {
    public function fetchData(): array {
        // Логика для получения данных из pb.nalog.ru
        return [
            'source' => 'nalog.ru',
            'data' => [
                'company' => 'ООО Рога и Копыта',
                'inn' => '1234567890'
            ]
        ];
    }
}
```
{% endcode %}

{% code overflow="wrap" lineNumbers="true" %}
```php
// Класс для работы с данными из dadata.ru
class DadataRuDataSource {
    public function retrieveData(): array {
        // Логика для получения данных из dadata.ru
        return [
            'source' => 'dadata.ru',
            'data' => [
                'company' => 'ООО Рога и Копыта',
                'inn' => '1234567890'
            ]
        ];
    }
}
```
{% endcode %}

2. **Классы `NalogRuDataSource` и `DadataRuDataSource`**: Реализуют логику для получения данных из соответствующих источников.

{% code overflow="wrap" lineNumbers="true" %}
```php
// Адаптер для NalogRuDataSource
class NalogRuAdapter implements DataSourceInterface {
    private $nalogRuDataSource;

    public function __construct(NalogRuDataSource $nalogRuDataSource) {
        $this->nalogRuDataSource = $nalogRuDataSource;
    }

    public function getData(): array {
        $data = $this->nalogRuDataSource->fetchData();
        // Преобразование данных в нужный формат
        return [
            'source' => $data['source'],
            'company' => $data['data']['company'],
            'inn' => $data['data']['inn']
        ];
    }
}
```
{% endcode %}

{% code overflow="wrap" lineNumbers="true" %}
```php
// Адаптер для DadataRuDataSource
class DadataRuAdapter implements DataSourceInterface {
    private $dadataRuDataSource;

    public function __construct(DadataRuDataSource $dadataRuDataSource) {
        $this->dadataRuDataSource = $dadataRuDataSource;
    }

    public function getData(): array {
        $data = $this->dadataRuDataSource->retrieveData();
        // Преобразование данных в нужный формат
        return [
            'source' => $data['source'],
            'company' => $data['data']['company'],
            'inn' => $data['data']['inn']
        ];
    }
}
```
{% endcode %}

3. **Адаптеры `NalogRuAdapter` и `DadataRuAdapter`**: Реализуют интерфейс `DataSourceInterface` и преобразуют данные из источников в единый формат.

{% code overflow="wrap" lineNumbers="true" %}
```php
// Клиентский код
function clientCode(DataSourceInterface $dataSource) {
    return $dataSource->getData();
}

// Пример использования
$nalogRuDataSource = new NalogRuDataSource();
$nalogRuAdapter = new NalogRuAdapter($nalogRuDataSource);

$dadataRuDataSource = new DadataRuDataSource();
$dadataRuAdapter = new DadataRuAdapter($dadataRuDataSource);

print_r(clientCode($nalogRuAdapter));
print_r(clientCode($dadataRuAdapter));
```
{% endcode %}

4. **Клиентский код**: Принимает объект, реализующий `DataSourceInterface`, и вызывает метод `getData()`.

UML диаграмма классов

<figure><img src="../../../../../.gitbook/assets/image (47).png" alt=""><figcaption><p>UML диаграмма для паттерна "Адаптер"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
interface DataSourceInterface {
    +getData(): array
}

class NalogRuDataSource {
    +fetchData(): array
}

class DadataRuDataSource {
    +retrieveData(): array
}

class NalogRuAdapter {
    -nalogRuDataSource: NalogRuDataSource
    +__construct(NalogRuDataSource)
    +getData(): array
}

class DadataRuAdapter {
    -dadataRuDataSource: DadataRuDataSource
    +__construct(DadataRuDataSource)
    +getData(): array
}

DataSourceInterface <|.. NalogRuAdapter
DataSourceInterface <|.. DadataRuAdapter

NalogRuAdapter --> NalogRuDataSource
DadataRuAdapter --> DadataRuDataSource
@enduml
```
{% endcode %}
