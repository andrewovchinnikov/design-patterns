# Python

<figure><img src="../../../../../.gitbook/assets/image (17).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Одиночка"</p></figcaption></figure>

Предположим, что наша команда разрабатывает систему управления контентом (CMS) для средних и крупных бизнесов. В рамках разработки нам необходимо реализовать функционал по созданию и редактированию страниц сайта.

Каждой странице сайта соответствует объект класса Page, который содержит информацию о заголовке страницы, её содержимом, мета-тегах и других атрибутах. При создании новой страницы пользователь выбирает шаблон, на основе которого будет создана новая страница. Шаблон представляет собой объект класса Template, который содержит информацию о структуре и дизайне страницы.

Создание новых страниц на основе шаблонов может быть реализовано с помощью паттерна Прототип. Для этого мы можем создать класс-фабрику PageFactory, который будет содержать прототипы страниц для каждого шаблона. При создании новой страницы пользователь выбирает шаблон, а PageFactory создаёт новый объект класса Page, клонируя прототип соответствующего шаблона.

Вот пример кода для реализации паттерна Прототип в Python:

Начнем с определения интерфейса Report, который будет содержать общие методы для всех отчетов:

{% code overflow="wrap" lineNumbers="true" %}
```python
type Report interface {
    GetTitle() string
    GetData() interface{}
    Clone() Report
}
```
{% endcode %}

Здесь мы определяем, что любой отчет должен иметь методы GetTitle() и GetData(), которые будут возвращать заголовок и данные отчета соответственно. Кроме того, мы определяем метод Clone(), который будет использоваться для создания копии отчета.

Теперь давайте определим два конкретных отчета: SalesReport и InventoryReport.

SalesReport будет содержать информацию о продажах:

{% code overflow="wrap" lineNumbers="true" %}
```python
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

Здесь мы определяем структуру SalesReport, которая содержит поля title и data. Затем мы реализуем методы GetTitle(), GetData() и Clone(), которые были определены в интерфейсе Report.

InventoryReport будет содержать информацию о остатках на складе:

{% code overflow="wrap" lineNumbers="true" %}
```python
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

Здесь мы определяем структуру InventoryReport, которая содержит поля title и data. Затем мы реализуем методы GetTitle(), GetData() и Clone(), которые были определены в интерфейсе Report.

Теперь давайте определим класс ReportFactory, который будет использоваться для создания отчетов:

{% code overflow="wrap" lineNumbers="true" %}
```python
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

Здесь мы определяем структуру ReportFactory, которая содержит поле prototypes, которое является картой, где ключ - это тип отчета, а значение - это экземпляр отчета, который будет использоваться в качестве прототипа.

Затем мы определяем метод CreateReport(), который будет использоваться для создания отчетов. Этот метод принимает три аргумента: typ, title и data. Аргумент typ указывает, какой тип отчета мы хотим создать. Аргумент title указывает заголовок отчета, а аргумент data указывает данные отчета.

В методе CreateReport() мы получаем прототип отчета из карты prototypes, затем создаем копию этого прототипа с помощью метода Clone(). Затем устанавливаем заголовок и данные отчета в соответствующих полях. Наконец, возвращаем созданный отчет.

Теперь давайте посмотрим на main функцию:

{% code overflow="wrap" lineNumbers="true" %}
```python
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

Здесь мы создаем экземпляр класса ReportFactory и устанавливаем прототипы отчетов в поле prototypes.

Затем мы создаем новый отчет по продажам на основе существующего с помощью метода CreateReport(). Затем выводим заголовок и данные отчета на экран.

После этого мы создаем новый отчет по остаткам на складе на основе существующего с помощью метода CreateReport(). Затем выводим заголовок и данные отчета на экран.

В итоге, мы видим, что паттерн Прототип позволяет нам создавать новые отчеты на основе существующих, что значительно упрощает и ускоряет процесс разработки.
