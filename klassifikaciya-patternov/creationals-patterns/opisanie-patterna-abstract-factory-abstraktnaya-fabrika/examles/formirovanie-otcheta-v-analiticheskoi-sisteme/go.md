# Go

<figure><img src="../../../../../.gitbook/assets/image (6) (1).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Абстрактная фабрика" в аналитической системе для формирования отчета</p></figcaption></figure>

Кейс:

Наша компания разрабатывает аналитическую систему, которая должна формировать отчеты о двух типах данных - пользователях (UserData) и продажах (SalesData). Отчеты должны быть доступны в трех форматах - JSON, XML и CSV. Кроме того, мы хотим, чтобы наша система была гибкой и легко расширяемой, чтобы в будущем мы могли добавлять новые типы отчетов и форматы без значительных изменений в существующем коде.

Решение:

Для решения этой задачи мы решили использовать паттерн "Абстрактная фабрика". Этот паттерн предоставляет интерфейс для создания семейств взаимосвязанных или взаимозависимых объектов, не специфицируя их конкретные классы.

Код:

1. Определяем интерфейсы:

Сначала мы определяем два интерфейса - `DataFactory` и `DataType`. В Go интерфейсы можно определить с помощью ключевого слова `interface`. Интерфейс `DataFactory` содержит один метод `CreateData()`, который должен возвращать объект, реализующий интерфейс `DataType`. Интерфейс `DataType` содержит два метода - `GetData()` и `SetFormat(format string)`. Метод `GetData()` должен возвращать отчет в выбранном формате, а метод `SetFormat(format string)` устанавливает формат отчета.

```go
type DataFactory interface {
    CreateData() DataType
}

type DataType interface {
    GetData() (string, error)
    SetFormat(format string)
}
```

2. Реализуем конкретные фабрики:

Затем мы реализуем две конкретные фабрики - `UserDataFactory` и `SalesDataFactory`, которые реализуют интерфейс `DataFactory`. Метод `CreateData()` в каждой фабрике возвращает объект конкретного типа данных - `UserData` или `SalesData`.

```go
type UserDataFactory struct{}

func (f *UserDataFactory) CreateData() DataType {
    return &UserData{
        userData: []map[string]string{
            {"name": "John", "age": "30"},
            {"name": "Jane", "age": "25"},
        },
    }
}

type SalesDataFactory struct{}

func (f *SalesDataFactory) CreateData() DataType {
    return &SalesData{
        salesData: []map[string]string{
            {"product": "Book", "price": "20"},
            {"product": "Pen", "price": "5"},
        },
    }
}
```

3. Реализуем конкретные типы данных:

Далее мы реализуем два конкретных типа данных - `UserData` и `SalesData`, которые реализуют интерфейс `DataType`. В каждом типе данных мы реализуем методы `GetData()` и `SetFormat(format string)`. Метод `GetData()` формирует отчет о данных в выбранном формате с помощью стандартных пакетов Go `encoding/json`, `encoding/xml` и `encoding/csv`. Метод `SetFormat(format string)` устанавливает формат отчета.

```go
type UserData struct {
    format     string
    userData   []map[string]string
}

func (d *UserData) GetData() (string, error) {
    switch d.format {
    case "JSON":
        data, err := json.Marshal(d.userData)
        return string(data), err
    case "XML":
        data, err := xml.Marshal(d.userData)
        return string(data), err
    case "CSV":
        var b strings.Builder
        w := csv.NewWriter(&b)
        err := w.WriteAll(d.userData)
        return b.String(), err
    default:
        return "", errors.New("invalid format")
    }
}

func (d *UserData) SetFormat(format string) {
    d.format = format
}

type SalesData struct {
    format      string
    salesData   []map[string]string
}

func (d *SalesData) GetData() (string, error) {
    switch d.format {
    case "JSON":
        data, err := json.Marshal(d.salesData)
        return string(data), err
    case "XML":
        data, err := xml.Marshal(d.salesData)
        return string(data), err
    case "CSV":
        var b strings.Builder
        w := csv.NewWriter(&b)
        err := w.WriteAll(d.salesData)
        return b.String(), err
    default:
        return "", errors.New("invalid format")
    }
}

func (d *SalesData) SetFormat(format string) {
    d.format = format
}
```

4. Реализуем класс для формирования отчетов:

Наконец, мы реализуем класс `Report`, который использует интерфейсы `DataFactory` и `DataType` для формирования отчетов. В классе `Report` мы определяем два поля - `factory` и `data`, которые соответствуют фабрике и типу данных, используемым для формирования отчета. Мы также определяем три метода - конструктор `NewReport(factory DataFactory)`, метод `GenerateReport() (string, error)`, который формирует и возвращает отчет, и метод `SetFormat(format string)`, который устанавливает формат отчета.

```go
type Report struct {
    factory DataFactory
    data    DataType
}

func NewReport(factory DataFactory) *Report {
    return &Report{
        factory: factory,
        data:    factory.CreateData(),
    }
}

func (r *Report) GenerateReport() (string, error) {
    // Здесь должна быть логика формирования отчета
    return r.data.GetData()
}

func (r *Report) SetFormat(format string) {
    r.data.SetFormat(format)
}
```

5. Используем класс `Report` для формирования отчетов:

В конце мы создаем два отчета - `userDataReport` и `salesDataReport`, используя класс `Report` и соответствующие фабрики. Затем мы устанавливаем формат отчетов с помощью метода `SetFormat(format string)` и формируем отчеты с помощью метода `GenerateReport() (string, error)`.

```go
userDataReport := NewReport(&UserDataFactory{})
userDataReport.SetFormat("JSON")
report, err := userDataReport.GenerateReport()
if err != nil {
    fmt.Println(err)
} else {
    fmt.Println(report)
}

salesDataReport := NewReport(&SalesDataFactory{})
salesDataReport.SetFormat("XML")
report, err = salesDataReport.GenerateReport()
if err != nil {
    fmt.Println(err)
} else {
    fmt.Println(report)
}
```

Надеюсь, этот пример поможет вам лучше понять, как можно реализовать паттерн "Абстрактная фабрика" на Go и как он может быть полезен в разработке гибких и расширяемых систем.

{% code overflow="wrap" lineNumbers="true" fullWidth="false" %}
```go
package main

import (
	"encoding/json"
	"encoding/xml"
	"fmt"
	"strings"
)

// Интерфейсы
type DataFactory interface {
	createData() DataType
}

type DataType interface {
	getData() (string, error)
	setFormat(format string)
}

// Конкретные фабрики
type UserDataFactory struct{}

func (u *UserDataFactory) createData() DataType {
	return &UserData{}
}

type SalesDataFactory struct{}

func (s *SalesDataFactory) createData() DataType {
	return &SalesData{}
}

// Конкретные типы данных
type UserData struct {
	format string
	// Здесь должны быть поля с данными о пользователях
}

func (u *UserData) getData() (string, error) {
	switch u.format {
	case "JSON":
		return json.Marshal(u)
	case "XML":
		return xml.Marshal(u)
	case "CSV":
		return u.toCSV()
	default:
		return "", fmt.Errorf("invalid format: %s", u.format)
	}
}

func (u *UserData) setFormat(format string) {
	u.format = format
}

func (u *UserData) toCSV() (string, error) {
	// Здесь должна быть логика преобразования данных в CSV
	return "", nil
}

type SalesData struct {
	format string
	// Здесь должны быть поля с данными о продажах
}

func (s *SalesData) getData() (string, error) {
	switch s.format {
	case "JSON":
		return json.Marshal(s)
	case "XML":
		return xml.Marshal(s)
	case "CSV":
		return s.toCSV()
	default:
		return "", fmt.Errorf("invalid format: %s", s.format)
	}
}

func (s *SalesData) setFormat(format string) {
	s.format = format
}

func (s *SalesData) toCSV() (string, error) {
	// Здесь должна быть логика преобразования данных в CSV
	return "", nil
}

// Класс для формирования отчетов
type Report struct {
	factory DataFactory
	data    DataType
}

func NewReport(factory DataFactory) *Report {
	return &Report{factory: factory}
}

func (r *Report) generateReport() (string, error) {
	r.data = r.factory.createData()
	// Здесь должна быть логика формирования отчета
	return r.data.getData()
}

func (r *Report) setFormat(format string) {
	r.data.setFormat(format)
}

func main() {
	userDataReport := NewReport(&UserDataFactory{})
	userDataReport.setFormat("JSON")
	report, err := userDataReport.generateReport()
	if err != nil {
		fmt.Println(err)
		return
	}
	fmt.Println(string(report))

	salesDataReport := NewReport(&SalesDataFactory{})
	salesDataReport.setFormat("XML")
	report, err = salesDataReport.generateReport()
	if err != nil {
		fmt.Println(err)
		return
	}
	fmt.Println(string(report))
}
```
{% endcode %}
