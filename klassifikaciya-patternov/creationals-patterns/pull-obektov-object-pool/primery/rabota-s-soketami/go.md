# Go

Разработать приложение, которое позволяет отправлять и получать данные через сетевые сокеты, используя пул сокетов для оптимизации ресурсов. Приложение должно включать классы для представления сокета и пула сокетов, а также демонстрировать их использование.

**Структуры и функции на Go:**

1. **Структура `Socket`**:
   * Представляет собой сетевой сокет.
   * Принимает адрес хоста и номер порта в конструкторе.
   * Предоставляет методы для отправки, получения и закрытия сокета.

{% code overflow="wrap" lineNumbers="true" %}
```go
package main

import (
    "net"
)

type Socket struct {
    conn net.Conn
}

func NewSocket(host string, port int) (*Socket, error) {
    conn, err := net.Dial("tcp", fmt.Sprintf("%s:%d", host, port))
    if err != nil {
        return nil, err
    }
    return &Socket{conn: conn}, nil
}

func (s *Socket) Send(data string) error {
    _, err := s.conn.Write([]byte(data))
    return err
}

func (s *Socket) Receive() (string, error) {
    buffer := make([]byte, 8192)
    n, err := s.conn.Read(buffer)
    if err != nil {
        return "", err
    }
    return string(buffer[:n]), nil
}

func (s *Socket) Close() error {
    return s.conn.Close()
}
```
{% endcode %}

1. **Структура `SocketPool`**:
   * Представляет собой пул объектов `Socket`.
   * Принимает максимальный размер пула в конструкторе и создает заданное количество объектов `Socket`.
   * Предоставляет методы для получения и возвращения сокетов в пул.

{% code overflow="wrap" lineNumbers="true" %}
```go
package main

import (
    "errors"
    "sync"
)

type SocketPool struct {
    host     string
    port     int
    maxSize  int
    sockets  chan *Socket
    mu       sync.Mutex
}

func NewSocketPool(host string, port int, maxSize int) (*SocketPool, error) {
    pool := &SocketPool{
        host:    host,
        port:    port,
        maxSize: maxSize,
        sockets: make(chan *Socket, maxSize),
    }
    for i := 0; i < maxSize; i++ {
        socket, err := NewSocket(host, port)
        if err != nil {
            return nil, err
        }
        pool.sockets <- socket
    }
    return pool, nil
}

func (p *SocketPool) GetSocket() (*Socket, error) {
    select {
    case socket := <-p.sockets:
        return socket, nil
    default:
        return NewSocket(p.host, p.port)
    }
}

func (p *SocketPool) ReleaseSocket(socket *Socket) {
    p.mu.Lock()
    defer p.mu.Unlock()
    if len(p.sockets) < p.maxSize {
        p.sockets <- socket
    } else {
        socket.Close()
    }
}
```
{% endcode %}

1. **Использование**:

{% code overflow="wrap" lineNumbers="true" %}
```go
package main

import (
    "fmt"
    "log"
)

func main() {
    pool, err := NewSocketPool("localhost", 80, 10)
    if err != nil {
        log.Fatalf("Failed to create socket pool: %v", err)
    }

    // Получаем сокет из пула
    socket, err := pool.GetSocket()
    if err != nil {
        log.Fatalf("Failed to get socket: %v", err)
    }

    // Отправляем данные
    err = socket.Send("GET / HTTP/1.1\r\nHost: localhost\r\n\r\n")
    if err != nil {
        log.Fatalf("Failed to send data: %v", err)
    }

    // Получаем ответ
    response, err := socket.Receive()
    if err != nil {
        log.Fatalf("Failed to receive data: %v", err)
    }
    fmt.Println(response)

    // Закрываем сокет
    err = socket.Close()
    if err != nil {
        log.Fatalf("Failed to close socket: %v", err)
    }

    // Возвращаем сокет в пул
    pool.ReleaseSocket(socket)
}
```
{% endcode %}

**Диаграмма классов:**

<figure><img src="../../../../../.gitbook/assets/image (42).png" alt=""><figcaption><p>UML диаграмма для паттерна "Пулл объектов"</p></figcaption></figure>

{% code overflow="wrap" lineNumbers="true" %}
```plant-uml
@startuml
class Socket {
    -conn: net.Conn
    +NewSocket(host: string, port: int): (*Socket, error)
    +Send(data: string): error
    +Receive(): (string, error)
    +Close(): error
}

class SocketPool {
    -host: string
    -port: int
    -maxSize: int
    -sockets: chan *Socket
    -mu: sync.Mutex
    +NewSocketPool(host: string, port: int, maxSize: int): (*SocketPool, error)
    +GetSocket(): (*Socket, error)
    +ReleaseSocket(socket: *Socket): void
}

SocketPool --> Socket
@enduml
```
{% endcode %}

Эта диаграмма отображает взаимосвязь между классами `Socket` и `SocketPool`. `SocketPool` содержит пул объектов `Socket` и управляет их жизненным циклом, позволяя повторно использовать объекты вместо создания новых.
