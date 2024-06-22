# Python

Разработать приложение, которое позволяет отправлять и получать данные через сетевые сокеты, используя пул сокетов для оптимизации ресурсов. Приложение должно включать классы для представления сокета и пула сокетов, а также демонстрировать их использование.

1. **Класс `Socket`**:
   * Представляет собой сетевой сокет.
   * Принимает адрес хоста и номер порта в конструкторе.
   * Предоставляет методы для отправки, получения и закрытия сокета.

{% code overflow="wrap" lineNumbers="true" %}
```python
import socket

class Socket:
    def __init__(self, host, port):
        self.sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        self.sock.connect((host, port))

    def send(self, data):
        self.sock.sendall(data.encode())

    def receive(self):
        data = self.sock.recv(8192)
        return data.decode()

    def close(self):
        self.sock.close()
```
{% endcode %}

1. **Класс `SocketPool`**:
   * Представляет собой пул объектов `Socket`.
   * Принимает максимальный размер пула в конструкторе и создает заданное количество объектов `Socket`.
   * Предоставляет методы для получения и возвращения сокетов в пул.

{% code overflow="wrap" lineNumbers="true" %}
```python
class SocketPool:
    def __init__(self, host, port, max_size):
        self.host = host
        self.port = port
        self.max_size = max_size
        self.sockets = []
        for _ in range(max_size):
            self.sockets.append(Socket(host, port))

    def get_socket(self):
        if self.sockets:
            return self.sockets.pop()
        return Socket(self.host, self.port)

    def release_socket(self, sock):
        if len(self.sockets) < self.max_size:
            self.sockets.append(sock)
        else:
            sock.close()
```
{% endcode %}

1. **Использование**:

{% code overflow="wrap" lineNumbers="true" %}
```python
if __name__ == "__main__":
    pool = SocketPool('localhost', 80, 10)

    # Получаем сокет из пула
    sock = pool.get_socket()

    # Отправляем данные
    sock.send('GET / HTTP/1.1\r\nHost: localhost\r\n\r\n')

    # Получаем ответ
    response = sock.receive()
    print(response)

    # Закрываем сокет
    sock.close()

    # Возвращаем сокет в пул
    pool.release_socket(sock)
```
{% endcode %}

**Диаграмма классов:**

<figure><img src="../../../../../.gitbook/assets/image (43).png" alt=""><figcaption><p>UML диаграмма для паттерна "Пул объектов"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
class Socket {
    -sock: socket.socket
    +__init__(host: str, port: int): void
    +send(data: str): void
    +receive(): str
    +close(): void
}

class SocketPool {
    -host: str
    -port: int
    -max_size: int
    -sockets: list
    +__init__(host: str, port: int, max_size: int): void
    +get_socket(): Socket
    +release_socket(sock: Socket): void
}

SocketPool --> Socket
@enduml
```
{% endcode %}

Эта диаграмма отображает взаимосвязь между классами `Socket` и `SocketPool`. `SocketPool` содержит пул объектов `Socket` и управляет их жизненным циклом, позволяя повторно использовать объекты вместо создания новых.

\
