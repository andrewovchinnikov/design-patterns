# Go

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Строитель"</p></figcaption></figure>

Тимлид сформировал задачу на разработку нового модуля для существующей ERP системы, который будет отвечать за формирование и обработку договоров с поставщиками. Разработчик, взявшийся за эту задачу, столкнулся с тем, что объект "Договор" имеет сложную структуру и содержит множество различных данных, таких как информация о стоимости, сроках выполнения, обязанностях сторон и т.д. Кроме того, договор может быть связан с другими объектами бизнес-логики, такими как заказы, счета и т.д.

Разработчик решил использовать паттерн "Строитель" для создания объектов "Договор". Этот паттерн позволяет создавать сложные объекты с помощью последовательного вызова методов, добавляющих необходимые данные и устанавливающих связи с другими объектами. При этом сам процесс создания объекта вынесен в отдельный класс "Builder", что позволяет избежать избыточной сложности кода и улучшить его гибкость и расширяемость.

Ниже приведен пример кода, реализующего паттерн "Строитель" для создания объектов "Договор":

<pre class="language-python" data-overflow="wrap" data-line-numbers><code class="lang-python"><strong>import (
</strong>    "fmt"
    "time"
)

// Order - заглушка для фактического класса Order в вашей ERP-системе
type Order struct{}

// Invoice - заглушка для фактического класса Invoice в вашей ERP-системе
type Invoice struct{}

// Contract - представляет объект Договор
type Contract struct {
    cost         float64
    deadline      time.Time
    obligations   []string
    order         *Order
    invoice       *Invoice
}

func (c *Contract) getCost() float64 {
    return c.cost
}

func (c *Contract) getDeadline() time.Time {
    return c.deadline
}

func (c *Contract) getObligations() []string {
    return c.obligations
}

func (c *Contract) getOrder() *Order {
    return c.order
}

func (c *Contract) getInvoice() *Invoice {
    return c.invoice
}

// ContractBuilder - отвечает за создание объектов Договор
type ContractBuilder struct {
    contract *Contract
}

func (cb *ContractBuilder) setCost(cost float64) *ContractBuilder {
    cb.contract.cost = cost
    return cb
}

func (cb *ContractBuilder) setDeadline(deadline time.Time) *ContractBuilder {
    cb.contract.deadline = deadline
    return cb
}

func (cb *ContractBuilder) addObligation(obligation string) *ContractBuilder {
    cb.contract.obligations = append(cb.contract.obligations, obligation)
    return cb
}

func (cb *ContractBuilder) setOrder(order *Order) *ContractBuilder {
    cb.contract.order = order
    return cb
}

func (cb *ContractBuilder) setInvoice(invoice *Invoice) *ContractBuilder {
    cb.contract.invoice = invoice
    return cb
}

func (cb *ContractBuilder) build() *Contract {
    result := cb.contract
    cb.contract = &#x26;Contract{} // Сбросить значения для создания нового объекта
    return result
}

func main() {
    // Создаем объект "Заказ"
    order := &#x26;Order{}
    // Создаем объект "Счет"
    invoice := &#x26;Invoice{}

    // Используем Builder для создания Договора с определенной стоимостью, сроком выполнения, обязанностями и ссылками на Заказ и Счет
    contract := &#x26;ContractBuilder{contract: &#x26;Contract{}}}.
        setCost(1000.0).
        setDeadline(time.Now().Add(30 * 24 * time.Hour)).
        addObligation("Поставка товара в срок").
        addObligation("Соответствие товара требованиям заказа").
        setOrder(order).
        setInvoice(invoice).
        build()

    fmt.Printf("Стоимость договора: %.2f\n", contract.getCost())
    fmt.Printf("Срок договора: %v\n", contract.getDeadline())
    fmt.Printf("Обязанности сторон: %v\n", contract.getObligations())
    fmt.Printf("Связанный заказ: %v\n", contract.getOrder())
    fmt.Printf("Связанный счет: %v\n", contract.getInvoice())
}
</code></pre>

В этом коде определены три структуры: `Order`, `Invoice` и `Contract`.&#x20;

`Order` и `Invoice` являются заглушками для фактических классов, которые будут существовать в вашей ERP-системе.&#x20;

`Contract` представляет объект Договор и имеет атрибуты для стоимости, срока выполнения, обязанностей и ссылок на Заказ и Счет. Он также имеет методы для получения этих атрибутов.

`ContractBuilder` является структурой, отвечающей за создание объектов Договор. Он имеет методы для установки или добавления к каждому атрибуту Договора. Эти методы возвращают сам объект Builder, что позволяет использовать цепочку методов. Метод `build` финализирует объект Договор и сбрасывает состояние Builder для создания новых объектов.

В функции `main` создаются объекты `Order` и `Invoice`, а затем используется `ContractBuilder` для создания `Contract` с определенной стоимостью, сроком выполнения, обязанностями и ссылками на `Order` и `Invoice`. Затем выводятся атрибуты `Contract` на экран.
