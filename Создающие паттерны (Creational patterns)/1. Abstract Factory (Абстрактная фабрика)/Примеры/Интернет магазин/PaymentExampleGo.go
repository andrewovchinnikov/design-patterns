/*
Определяем абстрактный интерфейс Payment для оплаты, который содержит метод Pay() для выполнения оплаты.
Затем мы создаем конкретные реализации этого интерфейса для оплаты картой (CardPayment) и Яндекс.Деньгами (YandexMoneyPayment),
которые реализуют метод Pay() для выполнения конкретного вида оплаты.
*/
type Payment interface {
    Pay()
}

// Конкретная реализация оплаты картой
type CardPayment struct {
    Amount        float64
    CardNumber    string
    CardHolder    string
    ExpirationDate string
    CVV           string
}

func (p *CardPayment) Pay() {
    // Код для выполнения оплаты картой
    fmt.Printf("Платеж картой на сумму %.2f выполнен успешно.\n", p.Amount)
}

// Конкретная реализация оплаты Яндекс.Деньгами
type YandexMoneyPayment struct {
    Amount     float64
    WalletNumber string
}

func (p *YandexMoneyPayment) Pay() {
    // Код для выполнения оплаты Яндекс.Деньгами
    fmt.Printf("Платеж Яндекс.Деньгами на сумму %.2f выполнен успешно.\n", p.Amount)
}

/*
Определяем абстрактный интерфейс PaymentFactory для фабрики оплаты, который содержит метод CreatePayment(...interface{}) Payment для создания объекта оплаты.
Затем мы создаем конкретные реализации этого интерфейса для фабрики оплаты картой (CardPaymentFactory) и Яндекс.Деньгами (YandexMoneyPaymentFactory),
которые реализуют метод CreatePayment(...interface{}) Payment для создания конкретного объекта оплаты.
*/
type PaymentFactory interface {
    CreatePayment(...interface{}) Payment
}

// Конкретная реализация фабрики оплаты картой
type CardPaymentFactory struct{}

func (f *CardPaymentFactory) CreatePayment(params ...interface{}) Payment {
    // Создание объекта оплаты картой
    amount := params[0].(float64)
    cardNumber := params[1].(string)
    cardHolder := params[2].(string)
    expirationDate := params[3].(string)
    cvv := params[4].(string)
    return &CardPayment{
        Amount:        amount,
        CardNumber:    cardNumber,
        CardHolder:    cardHolder,
        ExpirationDate: expirationDate,
        CVV:           cvv,
    }
}

// Конкретная реализация фабрики оплаты Яндекс.Деньгами
type YandexMoneyPaymentFactory struct{}

func (f *YandexMoneyPaymentFactory) CreatePayment(params ...interface{}) Payment {
    // Создание объекта оплаты Яндекс.Деньгами
    amount := params[0].(float64)
    walletNumber := params[1].(string)
    return &YandexMoneyPayment{
        Amount:     amount,
        WalletNumber: walletNumber,
    }
}

/*
В примере использования мы создаем фабрику оплаты картой и выполняем оплату с помощью созданного объекта.
Затем мы создаем фабрику оплаты Яндекс.Деньгами и выполняем оплату аналогичным образом.
*/
func main() {
    amount := 1000.00 // Сумма оплаты

    // Создание фабрики оплаты картой
    factory := &CardPaymentFactory{}
    payment := factory.CreatePayment(
        amount,
        "1234 5678 9012 3456",
        "Иван Иванов",
        "12/24",
        "123",
    )
    payment.Pay()

    // Создание фабрики оплаты Яндекс.Деньгами
    factory = &YandexMoneyPaymentFactory{}
    payment = factory.CreatePayment(
        amount,
        "4100112333445566",
    )
    payment.Pay()
}
