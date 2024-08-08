# Go

У нас есть аналитическая система, которая должна получать данные из трех различных источников: Яндекс Метрики, Roistat и Bitrix24. Каждый из этих источников предоставляет данные в своем собственном формате. Наша задача — создать единый интерфейс для получения данных из всех источников, чтобы аналитическая система могла работать с ними одинаково.

Паттерн Адаптер позволяет нам преобразовать интерфейс одного класса в интерфейс другого, который ожидают клиенты. Это особенно полезно, когда у нас есть несколько источников данных с разными интерфейсами, и мы хотим предоставить единый способ доступа к этим данным.

1.  **Создание интерфейса DataSourceInterface**:\
    Этот интерфейс будет определять метод `getData()`, который должен быть реализован всеми источниками данных.

    {% code overflow="wrap" lineNumbers="true" %}
    ```go
    // DataSourceInterface определяет интерфейс для получения данных
    type DataSourceInterface interface {
    	GetData() map[string]interface{}
    }
    ```
    {% endcode %}
2.  **Создание классов для каждого источника данных**:

    * `YandexMetrikaDataSource`
    * `RoistatDataSource`
    * `Bitrix24DataSource`

    {% code overflow="wrap" lineNumbers="true" %}
    ```go
    // YandexMetrikaDataSource представляет источник данных из Яндекс Метрики
    type YandexMetrikaDataSource struct{}

    // FetchData получает данные из Яндекс Метрики
    func (ym *YandexMetrikaDataSource) FetchData() map[string]interface{} {
    	return map[string]interface{}{
    		"source": "Yandex Metrika",
    		"data": map[string]interface{}{
    			"visits":   1000,
    			"pageviews": 2000,
    		},
    	}
    }

    // RoistatDataSource представляет источник данных из Roistat
    type RoistatDataSource struct{}

    // RetrieveData получает данные из Roistat
    func (r *RoistatDataSource) RetrieveData() map[string]interface{} {
    	return map[string]interface{}{
    		"source": "Roistat",
    		"data": map[string]interface{}{
    			"leads": 50,
    			"cost":  1000,
    		},
    	}
    }

    // Bitrix24DataSource представляет источник данных из Bitrix24
    type Bitrix24DataSource struct{}

    // GetBitrixData получает данные из Bitrix24
    func (b *Bitrix24DataSource) GetBitrixData() map[string]interface{} {
    	return map[string]interface{}{
    		"source": "Bitrix24",
    		"data": map[string]interface{}{
    			"deals": 30,
    			"tasks": 150,
    		},
    	}
    }
    ```
    {% endcode %}
3.  **Создание адаптеров для каждого источника данных**:

    * `YandexMetrikaAdapter`
    * `RoistatAdapter`
    * `Bitrix24Adapter`

    {% code overflow="wrap" lineNumbers="true" %}
    ```go
    // YandexMetrikaAdapter адаптирует YandexMetrikaDataSource к DataSourceInterface
    type YandexMetrikaAdapter struct {
    	DataSource *YandexMetrikaDataSource
    }

    // GetData возвращает данные в едином формате
    func (a *YandexMetrikaAdapter) GetData() map[string]interface{} {
    	data := a.DataSource.FetchData()
    	return map[string]interface{}{
    		"source":   data["source"],
    		"visits":   data["data"].(map[string]interface{})["visits"],
    		"pageviews": data["data"].(map[string]interface{})["pageviews"],
    	}
    }

    // RoistatAdapter адаптирует RoistatDataSource к DataSourceInterface
    type RoistatAdapter struct {
    	DataSource *RoistatDataSource
    }

    // GetData возвращает данные в едином формате
    func (a *RoistatAdapter) GetData() map[string]interface{} {
    	data := a.DataSource.RetrieveData()
    	return map[string]interface{}{
    		"source": data["source"],
    		"leads":  data["data"].(map[string]interface{})["leads"],
    		"cost":   data["data"].(map[string]interface{})["cost"],
    	}
    }

    // Bitrix24Adapter адаптирует Bitrix24DataSource к DataSourceInterface
    type Bitrix24Adapter struct {
    	DataSource *Bitrix24DataSource
    }

    // GetData возвращает данные в едином формате
    func (a *Bitrix24Adapter) GetData() map[string]interface{} {
    	data := a.DataSource.GetBitrixData()
    	return map[string]interface{}{
    		"source": data["source"],
    		"deals":  data["data"].(map[string]interface{})["deals"],
    		"tasks":  data["data"].(map[string]interface{})["tasks"],
    	}
    }
    ```
    {% endcode %}
4.  **Использование адаптеров в клиентском коде**:

    {% code overflow="wrap" lineNumbers="true" %}
    ```go
    // clientCode представляет клиентский код, который работает с DataSourceInterface
    func clientCode(dataSource DataSourceInterface) {
    	data := dataSource.GetData()
    	fmt.Println(data)
    }

    func main() {
    	yandexMetrikaDataSource := &YandexMetrikaDataSource{}
    	yandexMetrikaAdapter := &YandexMetrikaAdapter{DataSource: yandexMetrikaDataSource}

    	roistatDataSource := &RoistatDataSource{}
    	roistatAdapter := &RoistatAdapter{DataSource: roistatDataSource}

    	bitrix24DataSource := &Bitrix24DataSource{}
    	bitrix24Adapter := &Bitrix24Adapter{DataSource: bitrix24DataSource}

    	clientCode(yandexMetrikaAdapter)
    	clientCode(roistatAdapter)

    ```
    {% endcode %}

**UML диаграмма**

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для паттерна "Адаптер"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
interface DataSourceInterface {
    +GetData(): map[string]interface{}
}

class YandexMetrikaDataSource {
    +FetchData(): map[string]interface{}
}

class RoistatDataSource {
    +RetrieveData(): map[string]interface{}
}

class Bitrix24DataSource {
    +GetBitrixData(): map[string]interface{}
}

class YandexMetrikaAdapter {
    -DataSource: YandexMetrikaDataSource
    +GetData(): map[string]interface{}
}

class RoistatAdapter {
    -DataSource: RoistatDataSource
    +GetData(): map[string]interface{}
}

class Bitrix24Adapter {
    -DataSource: Bitrix24DataSource
    +GetData(): map[string]interface{}
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
