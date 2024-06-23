# Go

У нас есть два источника бизнес данных: `https://pb.nalog.ru/` и `https://dadata.ru/`. Каждый из этих источников предоставляет данные в своем собственном формате. Наша задача — предоставить единый интерфейс для получения сводных данных из этих источников. Это означает, что независимо от того, какой источник данных мы используем, мы должны получать данные в одном и том же формате.

Паттерн Адаптер (Adapter) используется для преобразования интерфейса одного класса в интерфейс другого, который ожидают клиенты. Это позволяет классам с несовместимыми интерфейсами работать вместе. В нашем случае, каждый источник данных имеет свой собственный формат данных, и мы хотим, чтобы они выглядели как имеющие один и тот же интерфейс. Использование паттерна Адаптер позволяет нам создать обертки (адаптеры) для каждого источника данных, которые будут преобразовывать данные в единый формат.

{% code overflow="wrap" lineNumbers="true" %}
```go
// DataSourceInterface определяет интерфейс для получения данных
type DataSourceInterface interface {
	GetData() map[string]string
}
```
{% endcode %}

1. **Интерфейс `DataSourceInterface`**: Определяет метод `getData()`, который должен возвращать данные в едином формате.

{% code overflow="wrap" lineNumbers="true" %}
```go
// NalogRuDataSource представляет источник данных из pb.nalog.ru
type NalogRuDataSource struct{}

// FetchData получает данные из pb.nalog.ru
func (n *NalogRuDataSource) FetchData() map[string]interface{} {
	return map[string]interface{}{
		"source": "nalog.ru",
		"data": map[string]string{
			"company": "ООО Рога и Копыта",
			"inn":     "1234567890",
		},
	}
}
```
{% endcode %}

{% code overflow="wrap" lineNumbers="true" %}
```go
// DadataRuDataSource представляет источник данных из dadata.ru
type DadataRuDataSource struct{}

// RetrieveData получает данные из dadata.ru
func (d *DadataRuDataSource) RetrieveData() map[string]interface{} {
	return map[string]interface{}{
		"source": "dadata.ru",
		"data": map[string]string{
			"company": "ООО Рога и Копыта",
			"inn":     "1234567890",
		},
	}
}
```
{% endcode %}

2. **Классы `NalogRuDataSource` и `DadataRuDataSource`**: Реализуют логику для получения данных из соответствующих источников.

{% code overflow="wrap" lineNumbers="true" %}
```go
// NalogRuAdapter адаптирует NalogRuDataSource к DataSourceInterface
type NalogRuAdapter struct {
	DataSource *NalogRuDataSource
}

// GetData возвращает данные в едином формате
func (a *NalogRuAdapter) GetData() map[string]string {
	data := a.DataSource.FetchData()
	return map[string]string{
		"source":  data["source"].(string),
		"company": data["data"].(map[string]string)["company"],
		"inn":     data["data"].(map[string]string)["inn"],
	}
}
```
{% endcode %}

{% code overflow="wrap" lineNumbers="true" %}
```go
// DadataRuAdapter адаптирует DadataRuDataSource к DataSourceInterface
type DadataRuAdapter struct {
	DataSource *DadataRuDataSource
}

// GetData возвращает данные в едином формате
func (a *DadataRuAdapter) GetData() map[string]string {
	data := a.DataSource.RetrieveData()
	return map[string]string{
		"source":  data["source"].(string),
		"company": data["data"].(map[string]string)["company"],
		"inn":     data["data"].(map[string]string)["inn"],
	}
}
```
{% endcode %}

3. **Адаптеры `NalogRuAdapter` и `DadataRuAdapter`**: Реализуют интерфейс `DataSourceInterface` и преобразуют данные из источников в единый формат.

{% code overflow="wrap" lineNumbers="true" %}
```go
// clientCode представляет клиентский код, который работает с DataSourceInterface
func clientCode(dataSource DataSourceInterface) {
	data := dataSource.GetData()
	fmt.Println(data)
}

func main() {
	nalogRuDataSource := &NalogRuDataSource{}
	nalogRuAdapter := &NalogRuAdapter{DataSource: nalogRuDataSource}

	dadataRuDataSource := &DadataRuDataSource{}
	dadataRuAdapter := &DadataRuAdapter{DataSource: dadataRuDataSource}

	clientCode(nalogRuAdapter)
	clientCode(dadataRuAdapter)
}
```
{% endcode %}

4. **Клиентский код**: Принимает объект, реализующий `DataSourceInterface`, и вызывает метод `getData()`.

UML диаграмма классов

<figure><img src="../../../../../.gitbook/assets/image (48).png" alt=""><figcaption><p>UML диаграмма для паттерна "Адаптер"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
interface DataSourceInterface {
    +GetData(): map[string]string
}

class NalogRuDataSource {
    +FetchData(): map[string]interface{}
}

class DadataRuDataSource {
    +RetrieveData(): map[string]interface{}
}

class NalogRuAdapter {
    -DataSource: NalogRuDataSource
    +GetData(): map[string]string
}

class DadataRuAdapter {
    -DataSource: DadataRuDataSource
    +GetData(): map[string]string
}

DataSourceInterface <|.. NalogRuAdapter
DataSourceInterface <|.. DadataRuAdapter

NalogRuAdapter --> NalogRuDataSource
DadataRuAdapter --> DadataRuDataSource
@enduml
```
{% endcode %}

Этот подход позволяет нам работать с разными источниками данных, не меняя клиентский код, что делает систему более гибкой и легко расширяемой.
