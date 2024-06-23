# Мост (Bridge)

Паттерн "Мост" (Bridge) используется для разделения абстракции и реализации, позволяя им изменяться независимо друг от друга. Этот паттерн включает в себя две иерархии классов: одну для абстракции и одну для реализации. Абстракция определяет высокоуровневый контроль, в то время как реализация предоставляет низкоуровневые операции.

### Компоненты

1. Абстракция (Abstraction): Определяет интерфейс абстракции и хранит ссылку на объект типа Implementor.
2. Уточненная абстракция (RefinedAbstraction): Расширяет интерфейс, определенный Abstraction.
3. Реализация (Implementor): Определяет интерфейс для классов реализации. Этот интерфейс не обязательно должен совпадать с интерфейсом Abstraction.
4. Конкретная реализация (ConcreteImplementor): Реализует интерфейс Implementor.

### Преимущества

* Позволяет изменять абстракцию и реализацию независимо друг от друга.
* Улучшает расширяемость и уменьшает связность между компонентами.

### Недостатки

* Может привести к увеличению количества классов в системе.

### Применение

* Когда необходимо избежать постоянной привязки абстракции к реализации.
* Когда и абстракция, и реализация должны быть расширяемыми через подклассы.
* Когда изменения в реализации не должны влиять на клиентский код.

### UML диаграмма

<figure><img src="../../../.gitbook/assets/image (50).png" alt=""><figcaption><p>UML диаграмма для паттерна "Мост"</p></figcaption></figure>

```
@startuml
abstract Abstraction {
    +operation()
}

class RefinedAbstraction extends Abstraction {
    +operation()
}

interface Implementor {
    +operationImpl()
}

class ConcreteImplementorA implements Implementor {
    +operationImpl()
}

class ConcreteImplementorB implements Implementor {
    +operationImpl()
}

Abstraction o-- Implementor
RefinedAbstraction --> Implementor
@enduml
```

Эта диаграмма отображает следующие элементы:

* Abstraction: Абстракция, которая определяет интерфейс и хранит ссылку на Implementor.
* RefinedAbstraction: Уточненная абстракция, которая расширяет интерфейс Abstraction.
* Implementor: Интерфейс для классов реализации.
* ConcreteImplementorA и ConcreteImplementorB: Конкретные реализации интерфейса Implementor.
