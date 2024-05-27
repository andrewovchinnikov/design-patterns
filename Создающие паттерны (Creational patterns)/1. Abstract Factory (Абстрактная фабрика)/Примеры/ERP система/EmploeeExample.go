// Определяем абстрактный интерфейс Employee для сотрудника, который содержит метод Work() для выполнения работы сотрудником.
// Затем мы создаем конкретные типы для менеджера (Manager), разработчика (Developer) и дизайнера (Designer),
// которые реализуют интерфейс Employee и метод Work() для выполнения конкретного вида работы.
type Employee interface {
    Work()
}

// Конкретный тип для менеджера
type Manager struct {
    Name        string
    Salary      int
    Skills      string
    Experience   string
}

func (m *Manager) Work() {
    // Код для выполнения работы менеджером
    fmt.Printf("Менеджер %s выполняет работу по управлению персоналом.\n", m.Name)
}

// Конкретный тип для разработчика
type Developer struct {
    Name        string
    Salary      int
    Skills      string
    Experience   string
}

func (d *Developer) Work() {
    // Код для выполнения работы разработчиком
    fmt.Printf("Разработчик %s выполняет работу по написанию кода.\n", d.Name)
}

// Конкретный тип для дизайнера
type Designer struct {
    Name        string
    Salary      int
    Skills      string
    Experience   string
}

func (d *Designer) Work() {
    // Код для выполнения работы дизайнером
    fmt.Printf("Дизайнер %s выполняет работу по созданию дизайна.\n", d.Name)
}

// Определяем абстрактный интерфейс EmployeeFactory для фабрики сотрудников, который содержит метод CreateEmployee(name string, salary int, skills string, experience string)
// Employee для создания объекта сотрудника. Затем мы создаем конкретные типы для фабрики менеджеров (ManagerFactory),
// фабрики разработчиков (DeveloperFactory) и фабрики дизайнеров (DesignerFactory), которые реализуют интерфейс EmployeeFactory и
// метод CreateEmployee(name string, salary int, skills string, experience string) Employee для создания конкретного объекта сотрудника.
type EmployeeFactory interface {
    CreateEmployee(name string, salary int, skills string, experience string) Employee
}

// Конкретный тип для фабрики менеджеров
type ManagerFactory struct{}

func (f *ManagerFactory) CreateEmployee(name string, salary int, skills string, experience string) Employee {
    // Создание объекта менеджера
    return &Manager{Name: name, Salary: salary, Skills: skills, Experience: experience}
}

// Конкретный тип для фабрики разработчиков
type DeveloperFactory struct{}

func (f *DeveloperFactory) CreateEmployee(name string, salary int, skills string, experience string) Employee {
    // Создание объекта разработчика
    return &Developer{Name: name, Salary: salary, Skills: skills, Experience: experience}
}

// Конкретный тип для фабрики дизайнеров
type DesignerFactory struct{}

func (f *DesignerFactory) CreateEmployee(name string, salary int, skills string, experience string) Employee {
    // Создание объекта дизайнера
    return &Designer{Name: name, Salary: salary, Skills: skills, Experience: experience}
}

// В примере использования мы создаем фабрики для каждого типа сотрудников и выполняем работу с помощью созданных объектов.
func main() {
    managerFactory := &ManagerFactory{}
    manager := managerFactory.CreateEmployee("Иван Иванов", 50000, "управление персоналом", "5 лет")
    manager.Work()

    developerFactory := &DeveloperFactory{}
    developer := developerFactory.CreateEmployee("Петр Петров", 40000, "PHP, JavaScript", "3 года")
    developer.Work()

    designerFactory := &DesignerFactory{}
    designer := designerFactory.CreateEmployee("Мария Иванова", 45000, "Photoshop, Figma", "2 года")
    designer.Work()
}
