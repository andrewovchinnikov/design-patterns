# PHP

Представьте, что мы — команда разработчиков, которая создает систему для обработки и отображения уведомлений. Наша система должна поддерживать несколько способов отправки уведомлений: электронная почта, СМС и Telegram. Мы хотим, чтобы наша система была гибкой и легко расширяемой, чтобы в будущем можно было добавить новые способы отправки уведомлений без изменения основного кода.

Для этого мы решили использовать паттерн "Мост" (Bridge). Этот паттерн позволяет разделить абстракцию и её реализацию так, чтобы они могли изменяться независимо друг от друга. В нашем случае абстракцией будет сам процесс отправки уведомлений, а реализацией — конкретные системы для уведомлений (электронная почта, СМС, Telegram).

**Абстрактный класс уведомлений (Notification)**

```php
abstract class Notification {
    // Метод для отправки уведомления
    abstract public function sendNotification(string $message);
}
```

**Конкретные реализации уведомлений**

```php
class EmailNotification extends Notification {
    public function sendNotification(string $message) {
        // Логика отправки уведомления по электронной почте
        echo "Sending email: $message\n";
    }
}

class SMSNotification extends Notification {
    public function sendNotification(string $message) {
        // Логика отправки уведомления через СМС
        echo "Sending SMS: $message\n";
    }
}

class TelegramNotification extends Notification {
    public function sendNotification(string $message) {
        // Логика отправки уведомления через Telegram
        echo "Sending Telegram message: $message\n";
    }
}
```

**Абстрактный класс отправителя уведомлений (NotificationSender)**

```php
abstract class NotificationSender {
    protected $notification;

    public function setNotification(Notification $notification) {
        $this->notification = $notification;
    }

    abstract public function send(string $message);
}
```

**Конкретные реализации отправителей уведомлений**

```php
class BasicNotificationSender extends NotificationSender {
    public function send(string $message) {
        // Логика отправки уведомления с использованием базового отправителя
        $this->notification->sendNotification($message);
    }
}

class AdvancedNotificationSender extends NotificationSender {
    public function send(string $message) {
        // Логика отправки уведомления с использованием продвинутого отправителя
        $this->notification->sendNotification($message);
    }
}
```

**Пример использования**

```php
// Создаем объекты уведомлений
$emailNotification = new EmailNotification();
$smsNotification = new SMSNotification();
$telegramNotification = new TelegramNotification();

// Создаем объект отправителя уведомлений
$basicSender = new BasicNotificationSender();

// Устанавливаем уведомление и отправляем сообщение
$basicSender->setNotification($emailNotification);
$basicSender->send("Hello via Email!");

$basicSender->setNotification($smsNotification);
$basicSender->send("Hello via SMS!");

$basicSender->setNotification($telegramNotification);
$basicSender->send("Hello via Telegram!");
```

#### Объяснение кода

1. **Абстрактный класс `Notification`**:
   * Это базовый класс для всех типов уведомлений. Он содержит абстрактный метод `sendNotification`, который должен быть реализован в конкретных классах уведомлений.
2. **Конкретные реализации уведомлений**:
   * `EmailNotification`, `SMSNotification`, `TelegramNotification` — это конкретные классы, которые реализуют метод `sendNotification` для отправки уведомлений через электронную почту, СМС и Telegram соответственно.
3. **Абстрактный класс `NotificationSender`**:
   * Это базовый класс для всех отправителей уведомлений. Он содержит метод `setNotification` для установки конкретного типа уведомления и абстрактный метод `send` для отправки уведомления.
4. **Конкретные реализации отправителей уведомлений**:
   * `BasicNotificationSender` и `AdvancedNotificationSender` — это конкретные классы, которые реализуют метод `send` для отправки уведомлений с использованием базового и продвинутого отправителей соответственно.
5. **Пример использования**:
   * Мы создаем объекты уведомлений и отправителя уведомлений. Затем устанавливаем конкретное уведомление для отправителя и отправляем сообщение.

#### UML диаграмма

<figure><img src="../../../../../.gitbook/assets/image (1).png" alt=""><figcaption><p>UML диаграмма для паттерна "Мост"</p></figcaption></figure>

```plant-uml
@startuml

abstract class Notification {
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

#### Вывод

Таким образом, мы можем легко добавлять новые типы уведомлений и отправителей, не изменяя основной код, что делает нашу систему гибкой и расширяемой.
