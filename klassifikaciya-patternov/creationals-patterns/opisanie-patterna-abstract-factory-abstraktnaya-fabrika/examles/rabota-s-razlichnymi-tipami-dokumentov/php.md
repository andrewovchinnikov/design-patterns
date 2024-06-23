# PHP

<figure><img src="../../../../../.gitbook/assets/image (2) (1) (1).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Абстрактная фабрика" в ERP системе</p></figcaption></figure>

1. Определяем интерфейс `DocumentInterface`, который содержит методы для работы с документами: `create()`, `edit()`, `delete()` и `print()`.
2. Определяем конкретные реализации интерфейса `DocumentInterface`: `InvoiceDocument` для работы со счетами-фактурами и `DeliveryNoteDocument` для работы с накладными. В этих классах реализуем методы интерфейса `DocumentInterface`.
3. Определяем интерфейс абстрактной фабрики `DocumentFactoryInterface`, который содержит метод `createDocument()`, возвращающий объект, реализующий интерфейс `DocumentInterface`.
4. Определяем конкретные реализации интерфейса `DocumentFactoryInterface`: `InvoiceFactory` для работы со счетами-фактурами и `DeliveryNoteFactory` для работы с накладными. В этих классах реализуем метод `createDocument()`, возвращающий объект соответствующего типа документа.
5. Создаем экземпляры конкретных фабрик и с их помощью создаем объекты документов. Затем вызываем методы этих объектов для создания, редактирования, удаления и печати документов.

Паттерн абстрактная фабрика позволяет создавать семейства связанных объектов, не завися от конкретных классов этих объектов. В данном примере, мы создали две фабрики: `InvoiceFactory` и `DeliveryNoteFactory`, которые создают объекты соответствующих типов документов. При этом, код, который создает объекты, не зависит от конкретных классов этих объектов, а работает с ними через интерфейс `DocumentInterface`.

Это позволяет легко добавлять новые типы документов и фабрик, не изменяя существующий код. Например, если мы захотим добавить новый тип документа - счет-фактура на возврат товара, то нам достаточно будет создать новый класс, реализующий интерфейс `DocumentInterface`, и новую фабрику, реализующую интерфейс `DocumentFactoryInterface`, которая будет создавать объекты нового типа документа.

Кроме того, паттерн абстрактная фабрика позволяет гибко настраивать систему, выбирая нужные фабрики и создавая объекты нужных типов. Например, в зависимости от типа пользователя или роли, мы можем выбирать разные фабрики и создавать объекты с разным функционалом или ограничениями.

Общие преимущества паттерна абстрактная фабрика:

* Позволяет создавать семейства связанных объектов, не завися от конкретных классов этих объектов.
* Объединяет группу интерфейсов с одной стороны и группу их реализаций - с другой.
* Позволяет легко добавлять новые типы объектов и фабрик, не изменяя существующий код.
* Позволяет гибко настраивать систему, выбирая нужные фабрики и создавая объекты нужных типов.
* Упрощает код, вынося логику создания объектов в отдельные классы-фабрики.

{% code overflow="wrap" lineNumbers="true" fullWidth="false" %}
```php
<?php
// Интерфейс для работы с документами
interface DocumentInterface
{
    public function create();
    public function edit();
    public function delete();
    public function print();
}

// Конкретная реализация для работы со счетами-фактурами
class InvoiceDocument implements DocumentInterface
{
    public function create()
    {
        echo 'Создание счета-фактуры' . PHP_EOL;
    }

    public function edit()
    {
        echo 'Редактирование счета-фактуры' . PHP_EOL;
    }

    public function delete()
    {
        echo 'Удаление счета-фактуры' . PHP_EOL;
    }

    public function print()
    {
        echo 'Печать счета-фактуры' . PHP_EOL;
    }
}

// Конкретная реализация для работы с накладными
class DeliveryNoteDocument implements DocumentInterface
{
    public function create()
    {
        echo 'Создание накладной' . PHP_EOL;
    }

    public function edit()
    {
        echo 'Редактирование накладной' . PHP_EOL;
    }

    public function delete()
    {
        echo 'Удаление накладной' . PHP_EOL;
    }

    public function print()
    {
        echo 'Печать накладной' . PHP_EOL;
    }
}

// Интерфейс абстрактной фабрики для работы с документами
interface DocumentFactoryInterface
{
    public function createDocument(): DocumentInterface;
}

// Конкретная фабрика для работы со счетами-фактурами
class InvoiceFactory implements DocumentFactoryInterface
{
    public function createDocument(): DocumentInterface
    {
        return new InvoiceDocument();
    }
}

// Конкретная фабрика для работы с накладными
class DeliveryNoteFactory implements DocumentFactoryInterface
{
    public function createDocument(): DocumentInterface
    {
        return new DeliveryNoteDocument();
    }
}

// Использование
$invoiceFactory = new InvoiceFactory();
$invoiceDocument = $invoiceFactory->createDocument();
$invoiceDocument->create();
$invoiceDocument->edit();
$invoiceDocument->delete();
$invoiceDocument->print();

echo PHP_EOL;

$deliveryNoteFactory = new DeliveryNoteFactory();
$deliveryNoteDocument = $deliveryNoteFactory->createDocument();
$deliveryNoteDocument->create();
$deliveryNoteDocument->edit();
$deliveryNoteDocument->delete();
$deliveryNoteDocument->print();

```
{% endcode %}
