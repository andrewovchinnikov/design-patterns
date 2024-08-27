# Python

Представьте, что мы — команда разработчиков, которая создает систему для обработки и отображения уведомлений. Наша система должна поддерживать несколько способов отправки уведомлений: электронная почта, СМС и Telegram. Мы хотим, чтобы наша система была гибкой и легко расширяемой, чтобы в будущем можно было добавить новые способы отправки уведомлений без изменения основного кода.

Для этого мы решили использовать паттерн "Мост" (Bridge). Этот паттерн позволяет разделить абстракцию и её реализацию так, чтобы они могли изменяться независимо друг от друга. В нашем случае абстракцией будет сам процесс отправки уведомлений, а реализацией — конкретные системы для уведомлений (электронная почта, СМС, Telegram).

**1.**&#x20;

**Интерфейс уведомлений (Notification)**

{% code overflow="wrap" lineNumbers="true" %}
```python
from abc import ABC, abstractmethod

class Notification(ABC):
    @abstractmethod
    def send_notification(self, message: str):
        pass
```
{% endcode %}

**Конкретные реализации уведомлений**

{% code overflow="wrap" lineNumbers="true" %}
```python
class EmailNotification(Notification):
    def send_notification(self, message: str):
        # Логика отправки уведомления по электронной почте
        print(f"Sending email: {message}")

class SMSNotification(Notification):
    def send_notification(self, message: str):
        # Логика отправки уведомления через СМС
        print(f"Sending SMS: {message}")

class TelegramNotification(Notification):
    def send_notification(self, message: str):
        # Логика отправки уведомления через Telegram
        print(f"Sending Telegram message: {message}")
```
{% endcode %}

**Абстрактный класс отправителя уведомлений (NotificationSender)**

{% code overflow="wrap" lineNumbers="true" %}
```python
class NotificationSender(ABC):
    def __init__(self):
        self.notification = None

    def set_notification(self, notification: Notification):
        self.notification = notification

    @abstractmethod
    def send(self, message: str):
        pass
```
{% endcode %}

**Конкретные реализации отправителей уведомлений**

{% code overflow="wrap" lineNumbers="true" %}
```python
class BasicNotificationSender(NotificationSender):
    def send(self, message: str):
        # Логика отправки уведомления с использованием базового отправителя
        self.notification.send_notification(message)

class AdvancedNotificationSender(NotificationSender):
    def send(self, message: str):
        # Логика отправки уведомления с использованием продвинутого отправителя
        self.notification.send_notification(message)
```
{% endcode %}

**Пример использования**

{% code overflow="wrap" lineNumbers="true" %}
```python
def main():
    # Создаем объекты уведомлений
    email_notification = EmailNotification()
    sms_notification = SMSNotification()
    telegram_notification = TelegramNotification()

    # Создаем объект отправителя уведомлений
    basic_sender = BasicNotificationSender()

    # Устанавливаем уведомление и отправляем сообщение
    basic_sender.set_notification(email_notification)
    basic_sender.send("Hello via Email!")

    basic_sender.set_notification(sms_notification)
    basic_sender.send("Hello via SMS!")

    basic_sender.set_notification(telegram_notification)
    basic_sender.send("Hello via Telegram!")

if __name__ == "__main__":
    main()
```
{% endcode %}

#### Объяснение кода

1. **Интерфейс `Notification`**:
   * Это базовый интерфейс для всех типов уведомлений. Он содержит абстрактный метод `send_notification`, который должен быть реализован в конкретных классах уведомлений.
2. **Конкретные реализации уведомлений**:
   * `EmailNotification`, `SMSNotification`, `TelegramNotification` — это конкретные классы, которые реализуют метод `send_notification` для отправки уведомлений через электронную почту, СМС и Telegram соответственно.
3. **Абстрактный класс `NotificationSender`**:
   * Это базовый класс для всех отправителей уведомлений. Он содержит метод `set_notification` для установки конкретного типа уведомления и абстрактный метод `send` для отправки уведомления.
4. **Конкретные реализации отправителей уведомлений**:
   * `BasicNotificationSender` и `AdvancedNotificationSender` — это конкретные классы, которые реализуют метод `send` для отправки уведомлений с использованием базового и продвинутого отправителей соответственно.
5. **Пример использования**:
   * Мы создаем объекты уведомлений и отправителя уведомлений. Затем устанавливаем конкретное уведомление для отправителя и отправляем сообщение.



UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (2) (1) (1) (1) (1) (1) (1) (1) (1) (1) (1).png" alt=""><figcaption><p>UML диаграмма для паттерна "Мост"</p></figcaption></figure>

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



Таким образом, мы можем легко добавлять новые типы уведомлений и отправителей, не изменяя основной код, что делает нашу систему гибкой и расширяемой.
