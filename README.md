# 🚀 Rocket – Vehicle Rental Management System  
**08/2024 – 06/2025 · Functional Analyst, Developer & Architect**  

<br>

**Título en español**: Rocket – Sistema de Gestión de Alquiler de Vehículos

<br><br>

## 🧭 Overview | Visión General

<br>

https://github.com/user-attachments/assets/574a08e0-953d-44a0-9c51-9c4841075759

<br><br>

**EN**  
Rocket is a modular, web-based management platform for vehicle rental management and operations, enabling reservation and rental management, fleet oversight, and multi-user access controls. The system integrates eight core modules: Vehicles, Customers, Vehicle Reservations, Vehicle Rental Contracts, Vehicle deliveries, vehicle returns, Suppliers, and Supplier Orders. My team and I architected a three-layer solution with PHP-powered business logic, a MySQL database optimized for high-volume queries, and responsive interfaces built with HTML, CSS, Bootstrap, and JavaScript. We also integrated advanced statistical reporting using Highcharts, and implemented comprehensive asset listing and export features for PDF documents, CSV datasets, Excel spreadsheets, and printing.

Leveraging the functional-analysis documentation we authored for the project, we developed modular services, created and optimized database schemas and query structures, and performed comparative assessments of CSS and JavaScript implementations to ensure consistent design and behavior of the information system. Iterative UI prototypes in Figma guided refinements that enhanced usability and acceptance, reduced user booking errors, and streamlined reservation and contract workflows.

The project showcases end-to-end system design - from comprehensive functional and non-functional requirements gathering, business processes, and UML-modeled workflows, to code development and optimization within Agile development cycles (Scrum), including functional testing and quality assurance using Behavior-Driven Development (BDD) and Gherkin syntax. This integrated approach ensured alignment with operational needs, business processes, and supplier integration workflows, positioning Rocket as a scalable and versatile software solution for a wide range of companies across the automotive sector.

<br>

**ES**  
Rocket es una plataforma web modular para la gestión y operación de alquiler de vehículos, que permite la gestión de reservas y alquileres, la supervisión de flotas y el control de acceso multiusuario. El sistema integra ocho módulos principales: Vehículos, Clientes, Reservas de Vehículos, Contratos de Alquiler de Vehículos, Entregas de Vehículos, Devoluciones de Vehículos, Proveedores y Pedidos a Proveedores. Mi equipo y yo diseñamos una solución de tres capas con lógica de negocio basada en PHP, una base de datos MySQL optimizada para consultas de alto volumen e interfaces responsivas basadas en HTML, CSS + Bootstrap, y JavaScript. También integramos informes estadísticos avanzados con Highcharts y otras librerías adicionales, e implementamos funciones completas de listado y exportación de activos para documentos PDF, conjuntos de datos CSV, hojas de cálculo de Excel, e impresión.

Aprovechando la documentación de análisis funcional que elaboramos para el proyecto, desarrollamos servicios modulares, creamos y optimizamos esquemas de bases de datos y estructuras de consulta, y realizamos evaluaciones comparativas de implementaciones de CSS y JavaScript para garantizar la coherencia en el diseño y el comportamiento del sistema de información. Los prototipos iterativos de interfaz de usuario en Figma guiaron los refinamientos que mejoraron la usabilidad y la aceptación, reduciendo errores de reserva de los usuarios, y agilizando los flujos de trabajo de reservas y contratos.

El proyecto incluyó el diseño integral del sistema, desde la recopilación exhaustiva de requerimientos funcionales y no funcionales, de los procesos de negocio, y los flujos de trabajo modelados en UML, hasta el desarrollo y la optimización de código dentro de ciclos de desarrollo ágiles (Scrum), incluyendo pruebas funcionales y control de calidad mediante Desarrollo Orientado al Comportamiento (BDD) y sintaxis Gherkin. Este enfoque integrado garantizó la alineación con las necesidades operativas, los procesos de negocio, y los workflows de integración de proveedores, posicionando a Rocket como una solución de software escalable y versátil para una amplia gama de empresas del sector automotriz.

---

<br>

## 🔑 General Summary | Resumen General

<br>

- **Multi-module system** for rental workflows, fleet management, and supplier coordination. <br> _Sistema multi-módulo para flujos de alquiler, gestión de flotas y coordinación con proveedores._

- **Three-layer architecture:** Presentation (HTML/CSS/JS), Business Logic (PHP), Data Layer (MySQL). <br>**Arquitectura en tres capas:** _Presentación (HTML/CSS/JS), Lógica de Negocio (PHP), Capa de Datos (MySQL)._

- **Responsive UI** with Figma-guided prototyping and iterative refinement. <br> _Interfaz responsiva con prototipado en Figma y refinamiento iterativo._

- **Advanced reporting** using Highcharts and exportable formats (PDF, CSV, Excel). <br> _Reportes avanzados con Highcharts y formatos exportables (PDF, CSV, Excel)._

- **Agile development** with Scrum, BDD testing, and stakeholder simulation. <br> _Desarrollo ágil con Scrum, pruebas BDD y simulación de feedback de usuarios._

---

<br>

## 🧱 System Architecture | Arquitectura del Sistema

<br>

- Modular separation of concerns for maintainability and scalability. <br> _Separación modular de responsabilidades para mantenibilidad y escalabilidad._

- PHP-powered backend with reusable services and controller logic. <br> _Backend en PHP con servicios reutilizables y lógica de controladores._

- MySQL schema optimized for high-volume queries and relational integrity. <br> _Esquema MySQL optimizado para consultas de alto volumen e integridad relacional._

- Centralized utilities for validation, sanitization, and error handling. <br> _Utilidades centralizadas para validación, sanitización y manejo de errores._

- Asset export engine supporting PDF, CSV, Excel, and print-ready formats. <br> _Motor de exportación de activos con soporte para PDF, CSV, Excel e impresión._

---

<br>

## 💻 Core Modules | Módulos Principales

<br>

| Module                     | Description (EN)                                                                 | Descripción (ES)                                                                 |
|---------------------------|----------------------------------------------------------------------------------|----------------------------------------------------------------------------------|
| **Vehicles**              | Fleet registration, availability tracking, attribute queries                     | Registro de flota, seguimiento de disponibilidad, consultas por atributos        |
| **Customers**             | User profiles, contact details                                                   | Perfiles de usuario, datos de contacto                                           |
| **Vehicle Reservations**  | Booking workflows, availability validation, scheduling                           | Flujos de reserva, validación de disponibilidad, calendarización                 |
| **Vehicle Rental Contracts** | Contract generation, pricing logic, lifecycle tracking                        | Generación de contratos, lógica de precios, seguimiento de ciclo de vida         |
| **Vehicle Deliveries**    | Delivery scheduling, status updates                                              | Programación de entregas, actualizaciones de estado                              |
| **Vehicle Returns**       | Return processing, condition assessment, closure workflows                       | Procesamiento de devoluciones, evaluación de estado, cierre de flujo             |
| **Suppliers**             | Supplier registration, contact management, asset sourcing                        | Registro de proveedores, gestión de contactos, abastecimiento                    |
| **Supplier Orders**       | Order creation, tracking, and supplier integration                               | Creación de pedidos, seguimiento e integración con proveedores                   |

---

<br>

## 📊 Reporting & Data Visualization | Reportes y Visualización de Datos

<br>

- Dynamic charts for fleet usage, contract metrics, and operational KPIs (Key Performance Indicators). <br> _Gráficos dinámicos del uso de la flota, métricas de contratos y KPIs operativos (Indicadores Clave de Rendimiento)._

- Descriptive statistical indicators for business intelligence. <br> _Indicadores estadísticos descriptivos para inteligencia empresarial._

- Exportable reports in multiple formats: <br> _Reportes exportables en múltiples formatos:_

<br>

| Format | Use Case | Casos    |
|--------|----------|----------|
| PDF    | Multiple PDF exports associated with reservations, contracts, deliveries, returns, suppliers, orders | Múltiples exportaciones en formato PDF asociadas a reservas, contratos, entregas, devoluciones, proveedores, órdenes a proveedores |
| CSV    | Bulk data entries for contracts and use of the fleet | Para las entradas de datos asociadas a contratos y uso de la flota  |
| Excel  | Structured datasets for analysis and reporting | Conjuntos de datos estructurados para análisis y reporting |
| Print  | On-demand simple and complex listings for operational workflows | Listados simples y complejos a pedido, asociados a flujos de trabajo operativos |

---

<br>

## 📁 Asset Listings & Exportation | Listados y Exportación de Activos

<br>

- Centralized export engine for all modules. <br> _Motor de exportación centralizado para todos los módulos._

- Supports structured formatting. Future expansions will be able to support multilingual labels. <br> _Soporta formato estructurado. Futuras expansiones podrán soportar etiquetas multilingües._

- Includes pagination and filtering for large datasets. <br> _Incluye paginación y filtrado para grandes volúmenes de datos._

---

<br>

## 🎨 User Interface & UX | Interfaz de Usuario y Experiencia de Usuario

<br>

- Responsive design for desktop and mobile environments. <br> _Diseño responsivo para entornos de escritorio y móviles._

- UI prototyping and iteration using Figma. <br> _Prototipado e iteración de interfaz con Figma._

- Comparative assessments of CSS and JS for consistent behavior. <br> _Evaluaciones comparativas de CSS y JS para comportamiento consistente._

- Streamlined workflows to reduce booking errors and improve usability. <br> _Flujos optimizados para reducir errores de reserva y mejorar la usabilidad._

---

<br>

## 📐 Modeling & Documentation | Modelado y Documentación

<br>

- Functional analysis and requirements documentation authored in-house. <br> _Análisis funcional y documentación de requerimientos desarrollados internamente._

- UML-modeled workflows for system structure, behavior, and module interactions. <br> _Flujos modelados en UML asociados a la estructura del sistema, su comportamiento, e interacción de los módulos._

- Alignment with business processes and operational logic. <br> _Alineación del sistema con los procesos de negocio y la lógica operativa._

- Includes diagrams, use cases, implementation and deployment notes. <br> _Incluye diagramas, casos de uso, y notas de implementación y despliegue._

---

<br>

## 🧪 Testing & Quality Assurance | Pruebas y Aseguramiento de Calidad

<br>

- Functional testing cycles integrated into development sprints. <br> _Ciclos de prueba funcional integrados en los sprints de desarrollo._

- Behavior-Driven Development (BDD) using Gherkin syntax. <br> _Desarrollo guiado por comportamiento (BDD) con sintaxis Gherkin._

- Manual test scenarios aligned with real-world use cases. <br> _Escenarios de prueba manual alineados con casos reales._

- QA documentation and test logs in Zephyr available for review. <br> _Documentación de QA y registros de prueba en Zephyr disponibles para su revisión._

---

<br>

## 🔄 Development Methodology | Metodología de Desarrollo

<br>

- Agile development using Scrum. <br> _Desarrollo ágil utilizando Scrum._

- Iterative sprints with continuous refinement and stakeholder feedback simulations. <br> _Sprints iterativos con refinamiento continuo y simulaciones de feedback de clientes y tenedores de participación de la compañía._

- Feature alignment with operational needs and business workflows. <br> _Alineación de las funcionalidades del sistema con las necesidades operativas y los flujos de trabajo del negocio._

- Git-based version control with modular commits and branching. <br> _Control de versiones con Git, commits modulares y ramificación_.

---

<br>

## 📎 Deployment & Hosting | Despliegue y Hosting

<br>

- Local deployment via Apache web servers and MySQL stack. <br> _Despliegue local con stack Apache y MySQL._

- Ready for cloud migration and containerization (Docker-ready architecture). <br> _Preparado para migración a la nube y contenerización (arquitectura compatible con Docker)._

---

<br>

## 📺 Demonstrations | Demostraciones

<br>

### 🔐 Login and Main Dashboard | Login y Panel principal

https://github.com/user-attachments/assets/574a08e0-953d-44a0-9c51-9c4841075759

<br>

### 🚗 Vehicle Management | Gestión de Vehículos

https://github.com/user-attachments/assets/4452fa36-4107-404c-b65f-db312e701a14

<br>

### 👤 Client Management | Gestión de Clientes

https://github.com/user-attachments/assets/b988b3d9-2f2c-4318-9a15-ab68fda6aaea

<br>

### 📅 Vehicle Reservation Management | Gestión de Reservas de Vehículos

https://github.com/user-attachments/assets/98dd4133-3b3d-4f86-af04-5a1a69d5236c

<br>

### 📄 Rental Contract Management | Gestión de Contratos de Alquiler

https://github.com/user-attachments/assets/20dd46a5-37b9-4765-8e37-275935b383f7

https://github.com/user-attachments/assets/3f43a2d0-4ed4-49d6-9626-bae00123eeb1

<br>

### 📦 Vehicle Delivery Management | Gestión de Entregas de Vehículos

https://github.com/user-attachments/assets/bb1d4643-bdf2-4e5a-88a9-fedb4942a212

<br>

### 🔁 Vehicle Return Management | Gestión de Devoluciones de Vehículos

https://github.com/user-attachments/assets/ad7679b8-0aaa-4b69-ae94-f4296abe9522

<br>

### 🧑‍💼 Supplier Management | Gestión de Proveedores

https://github.com/user-attachments/assets/9b8d6527-8096-479e-8b79-08ca93dea9e2

<br>

### 📝 Supplier Order Management | Gestión de Pedidos a Proveedores

https://github.com/user-attachments/assets/4c6f8c77-adeb-4b50-bb4b-0701e8b15579

https://github.com/user-attachments/assets/ca217c39-1131-44fa-97ef-cf9f5c53b7eb

<br> <br>

### 🎥 YouTube Reviews & Demos (Spanish) 

<br>

#### Documentation & Functionalities Review

<br>

**EN**<br>
Complete review including documentation in Confluence, work management in Jira, test cases in Zephyr using BDD and Gherkin syntax, and system functionalities.

📺 [Watch the review on YouTube](https://www.youtube.com/watch?v=b8RnsQvW8ns)

<br>

**ES**<br>
Review completa incluyendo documentación en Confluence, gestión del trabajo en Jira, casos de prueba en Zephyr usando BDD y sintaxis Gherkin, y funcionalidades del sistema.

📺 [Mirá la revisión en YouTube](https://www.youtube.com/watch?v=b8RnsQvW8ns)

<br>

#### Rocket Reports Review

<br>

**EN**<br>
A quick tour through some of the sections of Reports on Rocket.

📺 [Watch the review on YouTube](https://www.youtube.com/watch?v=IDcO-afSXdo)

<br>

**ES**<br>
Un recorrido rápido por algunas de las secciones de Reportes de Rocket.

📺 [Mirá la revisión en YouTube](https://www.youtube.com/watch?v=IDcO-afSXdo)

<br> <br>

---

<br>

## 📚 Documentation Links | Enlaces a la Documentación

<br>

- [Functional Analysis (Confluence)](link-to-docs)

- [Database Schema](link-to-schema)  

- [UML Diagrams](link-to-uml)  

- [Test Cases (BDD/Gherkin)](link-to-tests)

- [Deployment](link-to-desployment-model)

---

<br>

## 🧰 Tech Stack | Tecnologías Utilizadas

<br>

### 🖥️ Frontend

- HTML5, CSS3, JavaScript
- Bootstrap for responsive UI components | _Bootstrap para componentes de interfaz de usuario responsivos_
- Custom modular UI elements for dashboard and forms | _Elementos de interfaz de usuario modulares personalizados para paneles y formularios._

<br>

### ⚙️ Backend

- PHP 8.x (Object-Oriented + Procedural) | _PHP 8.x (Orientado a Objetos + Procedimental)_
- MySQL 8.x with optimized queries and relational integrity | _MySQL 8.x con consultas optimizadas e integridad relacional_

<br>

### 🧪 Testing & QA

- Manual and functional testing cycles integrated into development sprints | _Ciclos de pruebas manuales y funcionales integradas en los sprints de desarrollo_
- Acceptance testing with BDD/TDD principles | _Pruebas de aceptación con principios BDD/TDD_
- Quality assurance using Behavior-Driven Development (BDD) and Gherkin syntax | _Aseguramiento de Calidad mediante Desarrollo Guiado por Comportamiento (BDD) y sintaxis Gherkin_
- Manual test scenarios aligned with real-world use cases | _Escenarios de prueba manuales alineados con casos de uso realistas del negocio_

<br>

### 🔐 Security & Auth

- Session-based authentication with role-based access control support | _Autenticación basada en sesiones (variable `session`) con soporte paraeel control de acceso basado en roles_
- Input sanitization and protection against code injections | _Saneamiento de entradas y protección contra inyecciones de código_
- Encrypted password storage (soon) | _Almacenamiento de contraseñas cifradas (próximamente)_

---

<br>

## 📄 License | Licencia

<br>

**MIT License.** Extremely permissive. Allows use, modification, distribution, and private/commercial use. Requires attribution.

Copyright (c) 2025 Nicolás Damián Servidio, Bruno Carossi, Eduardo Facundo Mota

---

<br>

## 🤝 Contact | Contacto

<br>

**Nicolás Damián Servidio**  
📧 nicolasservidio.dm@gmail.com  
🔗 [LinkedIn](https://www.linkedin.com/in/nicolas-servidio-del-monte) · [GitHub](https://github.com/nicolasservidio)

<br>

**Bruno Carossi**  
📧 mail aquí
🔗 [LinkedIn](https://www.linkedin.com/in/nicolas-servidio-del-monte) · [GitHub](https://github.com/nicolasservidio)

<br>

**Eduardo Facundo Mota**  
📧 mail aquí  
🔗 [LinkedIn](https://www.linkedin.com/in/nicolas-servidio-del-monte) · [GitHub](https://github.com/nicolasservidio)

---

