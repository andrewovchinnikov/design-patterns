# PHP

Представьте, что мы работаем в компании, которая разрабатывает программное обеспечение для управления финансовыми операциями. Наша задача — создать систему, которая позволяет выполнять различные транзакции в базе данных, такие как перевод денег между счетами, снятие наличных и пополнение счета. Мы хотим, чтобы наша система была гибкой и легко расширяемой, чтобы в будущем можно было добавлять новые типы транзакций без изменения существующего кода.

### Описание

Паттерн Команда (Command) позволяет инкапсулировать запрос на выполнение операции в виде объекта. Это позволяет параметризовать объекты с операциями, задавать очередь операций, хранить историю выполнения операций и поддерживать отмену операций.

### Пример кода на PHP

**1. Интерфейс команды**

{% code overflow="wrap" lineNumbers="true" %}
```php
<?php

interface Command {
    public function execute();
    public function undo();
}
```
{% endcode %}

**2. Конкретные команды**

{% code overflow="wrap" lineNumbers="true" %}
```php
<?php

class TransferMoneyCommand implements Command {
    private $accountFrom;
    private $accountTo;
    private $amount;

    public function __construct($accountFrom, $accountTo, $amount) {
        $this->accountFrom = $accountFrom;
        $this->accountTo = $accountTo;
        $this->amount = $amount;
    }

    public function execute() {
        // Логика перевода денег
        echo "Перевод $this->amount с $this->accountFrom на $this->accountTo\n";
    }

    public function undo() {
        // Логика отмены перевода
        echo "Отмена перевода $this->amount с $this->accountFrom на $this->accountTo\n";
    }
}

class WithdrawMoneyCommand implements Command {
    private $account;
    private $amount;

    public function __construct($account, $amount) {
        $this->account = $account;
        $this->amount = $amount;
    }

    public function execute() {
        // Логика снятия денег
        echo "Снятие $this->amount с $this->account\n";
    }

    public function undo() {
        // Логика отмены снятия
        echo "Отмена снятия $this->amount с $this->account\n";
    }
}

class DepositMoneyCommand implements Command {
    private $account;
    private $amount;

    public function __construct($account, $amount) {
        $this->account = $account;
        $this->amount = $amount;
    }

    public function execute() {
        // Логика пополнения счета
        echo "Пополнение $this->amount на $this->account\n";
    }

    public function undo() {
        // Логика отмены пополнения
        echo "Отмена пополнения $this->amount на $this->account\n";
    }
}
```
{% endcode %}

**3. Вызывающий объект (Invoker)**

{% code overflow="wrap" lineNumbers="true" %}
```php
<?php

class TransactionInvoker {
    private $commands = [];

    public function addCommand(Command $command) {
        $this->commands[] = $command;
    }

    public function executeCommands() {
        foreach ($this->commands as $command) {
            $command->execute();
        }
    }

    public function undoCommands() {
        foreach (array_reverse($this->commands) as $command) {
            $command->undo();
        }
    }
}
```
{% endcode %}

**4. Пример использования**

{% code overflow="wrap" lineNumbers="true" %}
```php
<?php

$invoker = new TransactionInvoker();

$transferCommand = new TransferMoneyCommand('Account1', 'Account2', 100);
$withdrawCommand = new WithdrawMoneyCommand('Account1', 50);
$depositCommand = new DepositMoneyCommand('Account2', 150);

$invoker->addCommand($transferCommand);
$invoker->addCommand($withdrawCommand);
$invoker->addCommand($depositCommand);

$invoker->executeCommands();
$invoker->undoCommands();
```
{% endcode %}

### UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (89).png" alt=""><figcaption><p>UML диаграмма для паттерна "Команда"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plantuml
@startuml

interface Command {
    +execute()
    +undo()
}

class TransferMoneyCommand {
    -accountFrom: string
    -accountTo: string
    -amount: float
    +__construct(accountFrom: string, accountTo: string, amount: float)
    +execute()
    +undo()
}

class WithdrawMoneyCommand {
    -account: string
    -amount: float
    +__construct(account: string, amount: float)
    +execute()
    +undo()
}

class DepositMoneyCommand {
    -account: string
    -amount: float
    +__construct(account: string, amount: float)
    +execute()
    +undo()
}

class TransactionInvoker {
    -commands: Command[]
    +addCommand(command: Command)
    +executeCommands()
    +undoCommands()
}

Command <|-- TransferMoneyCommand
Command <|-- WithdrawMoneyCommand
Command <|-- DepositMoneyCommand
TransactionInvoker --> Command

@enduml
```
{% endcode %}

### Вывод для кейса

Использование паттерна Команда позволяет нам гибко управлять различными транзакциями в базе данных. Мы можем легко добавлять новые типы транзакций, не изменяя существующий код. Это делает нашу систему более модульной и удобной для расширения. Кроме того, паттерн Команда позволяет нам легко реализовать функции отмены операций, что является важным аспектом для финансовых систем.
