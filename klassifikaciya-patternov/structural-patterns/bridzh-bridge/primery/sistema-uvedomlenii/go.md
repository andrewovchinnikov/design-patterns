# Go

Представьте, что мы — команда разработчиков, которая создает систему для обработки и отображения уведомлений. Наша система должна поддерживать несколько способов отправки уведомлений: электронная почта, СМС и Telegram. Мы хотим, чтобы наша система была гибкой и легко расширяемой, чтобы в будущем можно было добавить новые способы отправки уведомлений без изменения основного кода.

Для этого мы решили использовать паттерн "Мост" (Bridge). Этот паттерн позволяет разделить абстракцию и её реализацию так, чтобы они могли изменяться независимо друг от друга. В нашем случае абстракцией будет сам процесс отправки уведомлений, а реализацией — конкретные системы для уведомлений (электронная почта, СМС, Telegram).

**Интерфейс уведомлений (Notification)**

{% code overflow="wrap" lineNumbers="true" %}
```go
package main

import "fmt"

type Notification interface {
    sendNotification(message string)
}
```
{% endcode %}

**Конкретные реализации уведомлений**

{% code overflow="wrap" lineNumbers="true" %}
```go
type EmailNotification struct{}

func (e *EmailNotification) sendNotification(message string) {
    // Логика отправки уведомления по электронной почте
    fmt.Printf("Sending email: %s\n", message)
}

type SMSNotification struct{}

func (s *SMSNotification) sendNotification(message string) {
    // Логика отправки уведомления через СМС
    fmt.Printf("Sending SMS: %s\n", message)
}

type TelegramNotification struct{}

func (t *TelegramNotification) sendNotification(message string) {
    // Логика отправки уведомления через Telegram
    fmt.Printf("Sending Telegram message: %s\n", message)
}
```
{% endcode %}

**Абстрактный класс отправителя уведомлений (NotificationSender)**

{% code overflow="wrap" lineNumbers="true" %}
```go
type NotificationSender struct {
    notification Notification
}

func (n *NotificationSender) setNotification(notification Notification) {
    n.notification = notification
}

func (n *NotificationSender) send(message string) {
    n.notification.sendNotification(message)
}
```
{% endcode %}

**Конкретные реализации отправителей уведомлений**

{% code overflow="wrap" lineNumbers="true" %}
```go
type BasicNotificationSender struct {
    NotificationSender
}

type AdvancedNotificationSender struct {
    NotificationSender
}
```
{% endcode %}

**Пример использования**

{% code overflow="wrap" lineNumbers="true" %}
```go
func main() {
    // Создаем объекты уведомлений
    emailNotification := &EmailNotification{}
    smsNotification := &SMSNotification{}
    telegramNotification := &TelegramNotification{}

    // Создаем объект отправителя уведомлений
    basicSender := &BasicNotificationSender{}

    // Устанавливаем уведомление и отправляем сообщение
    basicSender.setNotification(emailNotification)
    basicSender.send("Hello via Email!")

    basicSender.setNotification(smsNotification)
    basicSender.send("Hello via SMS!")

    basicSender.setNotification(telegramNotification)
    basicSender.send("Hello via Telegram!")
}
```
{% endcode %}

#### Объяснение кода

1. **Интерфейс `Notification`**:
   * Это базовый интерфейс для всех типов уведомлений. Он содержит метод `sendNotification`, который должен быть реализован в конкретных структурах уведомлений.
2. **Конкретные реализации уведомлений**:
   * `EmailNotification`, `SMSNotification`, `TelegramNotification` — это конкретные структуры, которые реализуют метод `sendNotification` для отправки уведомлений через электронную почту, СМС и Telegram соответственно.
3. **Абстрактный класс `NotificationSender`**:
   * Это базовая структура для всех отправителей уведомлений. Она содержит метод `setNotification` для установки конкретного типа уведомления и метод `send` для отправки уведомления.
4. **Конкретные реализации отправителей уведомлений**:
   * `BasicNotificationSender` и `AdvancedNotificationSender` — это конкретные структуры, которые наследуют базовую структуру `NotificationSender`.
5. **Пример использования**:
   * Мы создаем объекты уведомлений и отправителя уведомлений. Затем устанавливаем конкретное уведомление для отправителя и отправляем сообщение.



UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (1) (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для паттерна "Мост"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml

interface Notification {
    +sendNotification(message: String)
}

class EmailNotification {
    +sendNotification(message: String)
}

class SMSNotification {
    +sendNotification(message: String)
}

class TelegramNotification {
    +sendNotification(message: String)
}

abstract class NotificationSender {
    -notification: Notification
    +setNotification(notification: Notification)
    +send(message: String)
}

class BasicNotificationSender {
    +send(message: String)
}

class AdvancedNotificationSender {
    +send(message: String)
}

Notification <|-- EmailNotification
Notification <|-- SMSNotification
Notification <|-- TelegramNotification

NotificationSender <|-- BasicNotificationSender
NotificationSender <|-- AdvancedNotificationSender

NotificationSender --> Notification

@enduml
```
{% endcode %}

#### Вывод

Таким образом, мы можем легко добавлять новые типы уведомлений и отправителей, не изменяя основной код, что делает нашу систему гибкой и расширяемой.
