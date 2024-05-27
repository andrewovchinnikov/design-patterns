# Определяем абстрактный класс Payment для оплаты, который содержит метод pay() для выполнения оплаты.
# Затем мы создаем конкретные реализации этого класса для оплаты картой (CardPayment) и Яндекс.Деньгами (YandexMoneyPayment),
# которые реализуют метод pay() для выполнения конкретного вида оплаты.
class Payment:
    def __init__(self, amount):
        self.amount = amount

    # Метод для выполнения оплаты
    def pay(self):
        pass

# Конкретный класс для оплаты картой
class CardPayment(Payment):
    def __init__(self, amount, card_number, card_holder, expiration_date, cvv):
        super().__init__(amount)
        self.card_number = card_number
        self.card_holder = card_holder
        self.expiration_date = expiration_date
        self.cvv = cvv

    def pay(self):
        # Код для выполнения оплаты картой
        print(f"Платеж картой на сумму {self.amount} выполнен успешно.")

# Конкретный класс для оплаты Яндекс.Деньгами
class YandexMoneyPayment(Payment):
    def __init__(self, amount, wallet_number):
        super().__init__(amount)
        self.wallet_number = wallet_number

    def pay(self):
        # Код для выполнения оплаты Яндекс.Деньгами
        print(f"Платеж Яндекс.Деньгами на сумму {self.amount} выполнен успешно.")

# Определяем абстрактный класс PaymentFactory для фабрики оплаты, который содержит метод create_payment(*params) для создания объекта оплаты.
# Затем мы создаем конкретные реализации этого класса для фабрики оплаты картой (CardPaymentFactory) и Яндекс.Деньгами (YandexMoneyPaymentFactory),
# которые реализуют метод create_payment(*params) для создания конкретного объекта оплаты.
class PaymentFactory:
    # Метод для создания объекта оплаты
    def create_payment(self, *params):
        pass

# Конкретный класс для фабрики оплаты картой
class CardPaymentFactory(PaymentFactory):
    def create_payment(self, *params):
        # Создание объекта оплаты картой
        return CardPayment(*params)

# Конкретный класс для фабрики оплаты Яндекс.Деньгами
class YandexMoneyPaymentFactory(PaymentFactory):
    def create_payment(self, *params):
        # Создание объекта оплаты Яндекс.Деньгами
        return YandexMoneyPayment(*params)

# В примере использования мы создаем фабрику оплаты картой и выполняем оплату с помощью созданного объекта.
# Затем мы создаем фабрику оплаты Яндекс.Деньгами и выполняем оплату аналогичным образом.
amount = 1000  # Сумма оплаты

# Создание фабрики оплаты картой
factory = CardPaymentFactory()
payment = factory.create_payment(amount, '1234 5678 9012 3456', 'Иван Иванов', '12/24', '123')
payment.pay()

# Создание фабрики оплаты Яндекс.Деньгами
factory = YandexMoneyPaymentFactory()
payment = factory.create_payment(amount, '4100112333445566')
payment.pay()
