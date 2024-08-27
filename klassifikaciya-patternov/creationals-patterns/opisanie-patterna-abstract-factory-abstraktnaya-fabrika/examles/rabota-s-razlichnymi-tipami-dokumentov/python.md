# Python

<figure><img src="../../../../../.gitbook/assets/image (2) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Абстрактная фабрика" в ERP системе</p></figcaption></figure>

Этот пример кода на Python реализует паттерн абстрактная фабрика для создания семейств связанных объектов, не завися от конкретных классов этих объектов.

* Интерфейс `DocumentInterface` определяет методы для работы с документами. В Python интерфейсы можно реализовать с помощью абстрактных классов из модуля `abc`.
* Классы `InvoiceDocument` и `DeliveryNoteDocument` реализуют интерфейс `DocumentInterface` и предоставляют конкретные реализации этих методов.
* Интерфейс `DocumentFactoryInterface` определяет метод `create_document()`, который возвращает объект, реализующий интерфейс `DocumentInterface`. В Python интерфейсы можно реализовать с помощью абстрактных классов из модуля `abc`.
* Классы `InvoiceFactory` и `DeliveryNoteFactory` реализуют интерфейс `DocumentFactoryInterface` и предоставляют конкретные реализации метода `create_document()`, создающие объекты соответствующих типов документов.
* В функции `main()` создаются экземпляры конкретных фабрик и с их помощью создаются объекты документов. Затем вызываются методы этих объектов для создания, редактирования, удаления и печати документов.

Паттерн абстрактная фабрика позволяет создавать семейства связанных объектов, не завися от конкретных классов этих объектов. Это позволяет легко добавлять новые типы объектов и фабрик, не изменяя существующий код. Кроме того, паттерн абстрактная фабрика позволяет гибко настраивать систему, выбирая нужные фабрики и создавая объекты нужных типов.

Общие преимущества паттерна абстрактная фабрика:

* Позволяет создавать семейства связанных объектов, не завися от конкретных классов этих объектов.
* Объединяет группу интерфейсов с одной стороны и группу их реализаций - с другой.
* Позволяет легко добавлять новые типы объектов и фабрик, не изменяя существующий код.
* Позволяет гибко настраивать систему, выбирая нужные фабрики и создавая объекты нужных типов.
* Упрощает код, вынося логику создания объектов в отдельные классы-фабрики.

{% code overflow="wrap" lineNumbers="true" %}
```python
from abc import ABC, abstractmethod

# Интерфейс для работы с документами
class DocumentInterface(ABC):
    @abstractmethod
    def create(self):
        pass

    @abstractmethod
    def edit(self):
        pass

    @abstractmethod
    def delete(self):
        pass

    @abstractmethod
    def print(self):
        pass

# Конкретная реализация для работы со счетами-фактурами
class InvoiceDocument(DocumentInterface):
    def create(self):
        print("Создание счета-фактуры")

    def edit(self):
        print("Редактирование счета-фактуры")

    def delete(self):
        print("Удаление счета-фактуры")

    def print(self):
        print("Печать счета-фактуры")

# Конкретная реализация для работы с накладными
class DeliveryNoteDocument(DocumentInterface):
    def create(self):
        print("Создание накладной")

    def edit(self):
        print("Редактирование накладной")

    def delete(self):
        print("Удаление накладной")

    def print(self):
        print("Печать накладной")

# Интерфейс абстрактной фабрики для работы с документами
class DocumentFactoryInterface(ABC):
    @abstractmethod
    def create_document(self) -> DocumentInterface:
        pass

# Конкретная фабрика для работы со счетами-фактурами
class InvoiceFactory(DocumentFactoryInterface):
    def create_document(self) -> DocumentInterface:
        return InvoiceDocument()

# Конкретная фабрика для работы с накладными
class DeliveryNoteFactory(DocumentFactoryInterface):
    def create_document(self) -> DocumentInterface:
        return DeliveryNoteDocument()

def main():
    # Создаем экземпляры конкретных фабрик
    invoice_factory = InvoiceFactory()
    delivery_note_factory = DeliveryNoteFactory()

    # Создаем объекты документов с помощью фабрик
    invoice_document: DocumentInterface = invoice_factory.create_document()
    delivery_note_document: DocumentInterface = delivery_note_factory.create_document()

    # Вызываем методы объектов для создания, редактирования, удаления и печати документов
    invoice_document.create()
    invoice_document.edit()
    invoice_document.delete()
    invoice_document.print()

    delivery_note_document.create()
    delivery_note_document.edit()
    delivery_note_document.delete()
    delivery_note_document.print()

if __name__ == "__main__":
    main()
```
{% endcode %}
