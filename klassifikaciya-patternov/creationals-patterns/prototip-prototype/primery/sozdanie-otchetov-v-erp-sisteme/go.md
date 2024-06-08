# Go

<figure><img src="../../../../../.gitbook/assets/image (22).png" alt=""><figcaption></figcaption></figure>

Тимлид поставил задачу на разработку модуля для создания и редактирования отчетов в ERP системе. Разработчик, которому была поручена эта задача, решил использовать паттерн Прототип для создания новых отчетов на основе существующих.

Причина выбора паттерна Прототип заключается в том, что создание новых отчетов с нуля может быть очень трудоемким и временем затратным процессом. Кроме того, многие отчеты могут иметь схожий дизайн и структуру, поэтому создание новых отчетов на основе существующих может значительно ускорить процесс разработки.

Для реализации паттерна Прототип в Go, разработчик создал абстрактный интерфейс Report, который содержит общую логику для всех отчетов. Затем, он создал два конкретных типа SalesReport и InventoryReport, которые реализуют интерфейс Report и предоставляют свои собственные реализации метода Clone().

Вот пример кода для реализации паттерна Прототип на Go:

#### Интерфейс Report:

{% code overflow="wrap" lineNumbers="true" %}
```go

type Report interface {
    GetTitle() string
    GetData() interface{}
    Clone() Report
}
```
{% endcode %}

Интерфейс Report определяет общий контракт для всех отчетов в ERP системе. Он содержит три метода: GetTitle(), GetData() и Clone().&#x20;

Метод GetTitle() должен возвращать заголовок отчета. Метод GetData() должен возвращать данные отчета. Метод Clone() должен возвращать копию текущего отчета.

#### Конкретный тип SalesReport:

{% code overflow="wrap" lineNumbers="true" %}
```go
type SalesReport struct {
    title string
    data  []int
}

func (r *SalesReport) GetTitle() string {
    return r.title
}

func (r *SalesReport) GetData() interface{} {
    return r.data
}

func (r *SalesReport) Clone() Report {
    return &SalesReport{
        title: r.title,
        data:  append([]int{}, r.data...),
    }
}

```
{% endcode %}

Конкретный тип SalesReport реализует интерфейс Report и представляет отчет по продажам.

Тип SalesReport содержит два поля: title и data. Поле title содержит заголовок отчета, а поле data содержит данные отчета.

Метод GetTitle() возвращает значение поля title. Метод GetData() возвращает значение поля data. Метод Clone() создает копию текущего отчета и возвращает ее.

#### Конкретный тип InventoryReport:

{% code overflow="wrap" lineNumbers="true" %}
```go
type InventoryReport struct {
    title string
    data  map[string]int
}

func (r *InventoryReport) GetTitle() string {
    return r.title
}

func (r *InventoryReport) GetData() interface{} {
    return r.data
}

func (r *InventoryReport) Clone() Report {
    data := make(map[string]int, len(r.data))
    for k, v := range r.data {
        data[k] = v
    }
    return &InventoryReport{
        title: r.title,
        data:  data,
    }
}


```
{% endcode %}

Конкретный тип InventoryReport реализует интерфейс Report и представляет отчет по остаткам на складе. Тип InventoryReport содержит два поля: title и data. Поле title содержит заголовок отчета, а поле data содержит данные отчета.

Метод GetTitle() возвращает значение поля title. Метод GetData() возвращает значение поля data. Метод Clone() создает копию текущего отчета и возвращает ее.

#### Тип ReportFactory:

{% code overflow="wrap" lineNumbers="true" %}
```go
type ReportFactory struct {
    prototypes map[string]Report
}

func (f *ReportFactory) CreateReport(typ, title string, data interface{}) Report {
    proto := f.prototypes[typ]
    report := proto.Clone()
    report.(*SalesReport).title = title
    report.(*SalesReport).data = data.([]int)
    // или
    // report.(*InventoryReport).title = title
    // report.(*InventoryReport).data = data.(map[string]int)
    return report
}

```
{% endcode %}

Тип ReportFactory реализует паттерн Прототип для создания новых отчетов на основе существующих.

Тип ReportFactory содержит одно поле: prototypes. Поле prototypes является картой, где ключ - это тип отчета, а значение - это прототип отчета.

Метод CreateReport() создает новый отчет на основе существующего прототипа. Он принимает три аргумента: typ, title и data. Аргумент typ указывает тип отчета, который нужно создать. Аргумент title устанавливает заголовок нового отчета. Аргумент data устанавливает данные нового отчета.

Метод CreateReport() сначала получает прототип отчета из карты prototypes. Затем он создает копию прототипа с помощью метода Clone(). Затем он устанавливает заголовок и данные для нового отчета. Наконец, он возвращает новый отчет.

#### Функция main:

{% code overflow="wrap" lineNumbers="true" %}
```go
func main() {
    factory := &ReportFactory{
        prototypes: map[string]Report{
            "sales":    &SalesReport{title: "Sales Report", data: []int{}},
            "inventory": &InventoryReport{title: "Inventory Report", data: map[string]int{}},
        },
    }

    // Создаем новый отчет по продажам на основе существующего
    report := factory.CreateReport("sales", "New Sales Report", []int{1, 2, 3})
    fmt.Println(report.GetTitle())
    fmt.Println(report.GetData())

    // Создаем новый отчет по остаткам на складе на основе существующего
    report = factory.CreateReport("inventory", "New Inventory Report", map[string]int{"apple": 10, "banana": 20})
    fmt.Println(report.GetTitle())
    fmt.Println(report.GetData())
}

```
{% endcode %}

Функция main является точкой входа в приложение. Она создает экземпляр типа ReportFactory и использует его для создания новых отчетов.

В функции main сначала создается экземпляр типа ReportFactory. Затем он используется для создания нового отчета по продажам на основе существующего прототипа. Затем он используется для создания нового отчета по остаткам на складе на основе существующего прототипа. Наконец, заголовки и данные новых отчетов выводятся на экран.
