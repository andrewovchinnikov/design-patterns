# Go

<figure><img src="../../../../../.gitbook/assets/image (2) (1) (1) (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Абстрактная фабрика" в ERP системе</p></figcaption></figure>

Этот пример кода на Go реализует паттерн абстрактная фабрика для создания семейств связанных объектов, не завися от конкретных классов этих объектов.

* Интерфейс `DocumentInterface` определяет методы для работы с документами.
* Структуры `InvoiceDocument` и `DeliveryNoteDocument` реализуют интерфейс `DocumentInterface` и предоставляют конкретные реализации этих методов.
* Интерфейс `DocumentFactoryInterface` определяет метод `createDocument()`, который возвращает объект, реализующий интерфейс `DocumentInterface`.
* Структуры `InvoiceFactory` и `DeliveryNoteFactory` реализуют интерфейс `DocumentFactoryInterface` и предоставляют конкретные реализации метода `createDocument()`, создающие объекты соответствующих типов документов.
* В функции `main()` создаются экземпляры конкретных фабрик и с их помощью создаются объекты документов. Затем вызываются методы этих объектов для создания, редактирования, удаления и печати документов.

Паттерн абстрактная фабрика позволяет создавать семейства связанных объектов, не завися от конкретных классов этих объектов. Это позволяет легко добавлять новые типы объектов и фабрик, не изменяя существующий код. Кроме того, паттерн абстрактная фабрика позволяет гибко настраивать систему, выбирая нужные фабрики и создавая объекты нужных типов.

Общие преимущества паттерна абстрактная фабрика:

* Позволяет создавать семейства связанных объектов, не завися от конкретных классов этих объектов.
* Объединяет группу интерфейсов с одной стороны и группу их реализаций - с другой.
* Позволяет легко добавлять новые типы объектов и фабрик, не изменяя существующий код.
* Позволяет гибко настраивать систему, выбирая нужные фабрики и создавая объекты нужных типов.
* Упрощает код, вынося логику создания объектов в отдельные классы-фабрики.

{% code overflow="wrap" lineNumbers="true" fullWidth="false" %}
```go
package main

import "fmt"

// Интерфейс для работы с документами
type DocumentInterface interface {
    create()
    edit()
    delete()
    print()
}

// Конкретная реализация для работы со счетами-фактурами
type InvoiceDocument struct {}

func (d *InvoiceDocument) create() {
    fmt.Println("Создание счета-фактуры")
}

func (d *InvoiceDocument) edit() {
    fmt.Println("Редактирование счета-фактуры")
}

func (d *InvoiceDocument) delete() {
    fmt.Println("Удаление счета-фактуры")
}

func (d *InvoiceDocument) print() {
    fmt.Println("Печать счета-фактуры")
}

// Конкретная реализация для работы с накладными
type DeliveryNoteDocument struct {}

func (d *DeliveryNoteDocument) create() {
    fmt.Println("Создание накладной")
}

func (d *DeliveryNoteDocument) edit() {
    fmt.Println("Редактирование накладной")
}

func (d *DeliveryNoteDocument) delete() {
    fmt.Println("Удаление накладной")
}

func (d *DeliveryNoteDocument) print() {
    fmt.Println("Печать накладной")
}

// Интерфейс абстрактной фабрики для работы с документами
type DocumentFactoryInterface interface {
    createDocument() DocumentInterface
}

// Конкретная фабрика для работы со счетами-фактурами
type InvoiceFactory struct {}

func (f *InvoiceFactory) createDocument() DocumentInterface {
    return &InvoiceDocument{}
}

// Конкретная фабрика для работы с накладными
type DeliveryNoteFactory struct {}

func (f *DeliveryNoteFactory) createDocument() DocumentInterface {
    return &DeliveryNoteDocument{}
}

func main() {
    // Создаем экземпляры конкретных фабрик
    invoiceFactory := &InvoiceFactory{}
    deliveryNoteFactory := &DeliveryNoteFactory{}

    // Создаем объекты документов с помощью фабрик
    invoiceDocument := invoiceFactory.createDocument()
    deliveryNoteDocument := deliveryNoteFactory.createDocument()

    // Вызываем методы объектов для создания, редактирования, удаления и печати документов
    invoiceDocument.create()
    invoiceDocument.edit()
    invoiceDocument.delete()
    invoiceDocument.print()

    deliveryNoteDocument.create()
    deliveryNoteDocument.edit()
    deliveryNoteDocument.delete()
    deliveryNoteDocument.print()
}

```
{% endcode %}
