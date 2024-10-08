# Python

<figure><img src="../../../../../.gitbook/assets/image (12).png" alt=""><figcaption><p>UML диаграмма для примера применения паттерна "Одиночка</p></figcaption></figure>

Разработка веб-приложения для управления личными финансами. Для обеспечения эффективного доступа к данным о финансах и избежания конфликтов при работе с ними необходимо создать единственный экземпляр класса, отвечающего за работу с финансами.

Решение:

Для решения этой задачи мы можем использовать паттерн "Одиночка" (Singleton) для создания единственного экземпляра класса, отвечающего за работу с финансами. Этот экземпляр будет предоставлять доступ к данным о финансах и выполнять операции над ними.

Например, для класса `FinanceManager`, отвечающего за работу с финансами, паттерн "Одиночка" может быть реализован следующим образом на Python:

{% code overflow="wrap" lineNumbers="true" %}
```python
# Класс FinanceManager, отвечающий за работу с финансами
class FinanceManager:
    # Свойство, хранящее текущий баланс счета
    balance = 0
    # Свойство, хранящее массив транзакций
    transactions = []

    # Приватный конструктор, предотвращающий создание экземпляров класса с помощью оператора new
    def __new__(cls, *args, **kwargs):
        # Проверяем, существует ли уже экземплярр класса
        if not hasattr(cls, 'instance'):
            # Если нет, то создаем новый экземплярр класса и сохраняем его в свойстве instance
            cls.instance = super(FinanceManager, cls).__new__(cls, *args, **kwargs)
        # Возвращаем существующий экземплярр класса
        return cls.instance

    # Публичный метод, возвращающий текущий баланс счета
    def get_balance(self):
        return self.balance

    # Публичный метод, добавляющий доход на счет
    def add_income(self, amount: float, description: str = ''):
        # Увеличиваем текущий баланс счета на сумму дохода
        self.balance += amount
        # Добавляем транзакцию в массив транзакций
        self.transactions.append({
            "type":        "income",        // Тип транзакции - доход
            "amount":      amount,          // Сумма транзакции
            "description": description,     // Описание транзакции
            "date":        datetime.now().strftime("%Y-%m-%d %H:%M:%S"), // Дата и время транзакции
        })

    # Публичный метод, добавляющий расход со счета
    def add_expense(self, amount: float, description: str):
        # Проверяем, достаточно ли средств на счету для совершения расхода
        if self.balance >= amount:
            # Уменьшаем текущий баланс счета на сумму расхода
            self.balance -= amount
            # Добавляем транзакцию в массив транзакций
            self.transactions.append({
                "type":        "expense", // Тип транзакции - расход
                "amount":      amount,     // Сумма транзакции
                "description": description,  // Описание транзакции
                "date":        datetime.now().strftime("%Y-%m-%d %H:%M:%S"), // Дата и время транзакции
            })
        else:
            # Если средств на счету недостаточно, то выводим сообщение об ошибке
            print("Недостаточно средств на счету")

    # Публичный метод, возвращающий массив транзакций
    def get_transactions(self):
        return self.transactions

#usage
# Получаем единственный экземплярр класса FinanceManager
finance_manager = FinanceManager()
# Добавляем доход на счет
finance_manager.add_income(10000, "Зарплата")
# Добавляем расходы со счета
finance_manager.add_expense(500, "Еда")
finance_manager.add_expense(2000, "Аренда квартиры")
# Получаем текущий баланс счета
balance = finance_manager.get_balance()
print("Баланс:", balance)
# Получаем массив транзакций
transactions = finance_manager.get_transactions()
print(transactions)
```
{% endcode %}

В этом примере мы создаем класс `FinanceManager`, который отвечает за работу с финансами. Мы используем паттерн "Одиночка" для создания единственного экземпляра класса `FinanceManager`.

Мы объявляем приватное свойство `__instance`, которое будет хранить единственный экземплярр класса. Мы также объявляем приватный конструктор, чтобы предотвратить создание экземпляров класса с помощью оператора `new`.

Метод `__new__()` является приватным и статическим, и он используется для получения единственного экземпляра класса `FinanceManager`. В этом методе мы проверяем, существует ли уже экземплярр класса. Если нет, то создаем новый экземплярр класса и сохраняем его в свойстве `__instance`. В противном случае, мы просто возвращаем существующий экземплярр класса `FinanceManager`.

Методы `get_balance()`, `add_income()`, `add_expense()` и `get_transactions()` используются для выполнения операций над финансами.

Надеюсь, этот пример поможет вам лучше понять, как можно использовать паттерн "Одиночка" для работы с финансами в веб-приложении на Python.

Основанием для использования паттерна "Одиночка" в этом кейсе является необходимость обеспечения эффективного доступа к данным о финансах и избежания конфликтов при работе с ними. Если бы мы создавали несколько экземпляров класса `FinanceManager`, то это могло бы привести к конфликтам при работе с финансами и несогласованности данных. Поэтому мы используем паттерн "Одиночка", чтобы гарантировать, что будет создан только один экземпляр класса `FinanceManager`, и все операции над финансами будут выполняться через этот экземпляр.
