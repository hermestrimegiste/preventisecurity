# 🏥 MediCare: Multi-Tenant Medical Clinic Platform

MediCare is a professional, multi-tenant web application designed for managing patient appointments across multiple organizations (clinics/hospitals).

This project demonstrates expertise in building complex, production-ready applications with strict **data isolation** and **Role-Based Access Control (RBAC)**, using a modern Laravel/Vue stack.

---


## 🚀 Live Demo & Repository

| Deliverable | URL |
| :--- | :--- |
| **Deployed Application** | **[https://medicare.aourisis.org](https://medicare.aourisis.org)** |
| **API Documentation (Swagger)** | **[https://medicare.aourisis.org/api/documentation](https://medicare.aourisis.org/api/documentation)** |
| **GitHub Repository** | **[https://github.com/hermestrimegiste/medicare](https://github.com/hermestrimegiste/medicare)** |

---
## ✨ Features Implemented (MediCare - Option 2)

### Core Multi-Tenancy
* **Organization Isolation:** All core data (Patients, Appointments, MedicalRecords) is strictly isolated by `organization_id` using **Laravel Global Scopes** applied to the Eloquent models.
* **Organization Switching:** Users affiliated with multiple clinics (Doctors) can switch their active context instantly via the UI without logging out.

### Role-Based Access Control (RBAC)
* **Two User Roles:** Implemented using `spatie/laravel-permission`:
    * `Admin`: Manages the Organization's settings and members.
    * `Doctor`: Manages Patients, Appointments, and Medical Records.
    * `Patient`: Manages their own profile and appointments.

### Business Features
* **Patient Management:** Full CRUD operations for patients (isolated per organization).
* **Appointment Scheduling:** Creation, calendar viewing (filtered by doctor/date), and status management (Scheduled, Completed, Cancelled).

---
## 🛠️ Technology Stack Justification

The stack was chosen to demonstrate proficiency in a **robust, production-ready, full-stack environment**, prioritizing **developer velocity, maintainability, and security**—especially critical for 
a multi-tenant application.

### Backend & Core Framework
| Dependency | Rationale |
| :--- | :--- |
| **Laravel (PHP)** | Chosen for its **stability, security, and architectural maturity**, making it the ideal choice to enforce strict **multi-tenant data isolation** (via Global Scopes). |
| **MySQL** | A robust relational database selected for its superior **data integrity** and transactional safety, essential for sensitive medical data. |
| **Inertia.js** | Used to create a modern **Monolith/Hybrid application**. It drastically accelerates development by using Laravel's routing/validation with Vue's reactivity, avoiding the 
complexity of a separate API. |

### Backend Libraries for Quality & Security
| Dependency | Rationale |
| :--- | :--- |
| **Laravel Breeze** | Provides essential, minimal **authentication scaffolding**, allowing immediate focus on core business logic rather than boilerplate security setup. |
| **Spatie/laravel-permission** | A professional standard for **Role-Based Access Control (RBAC)**, used to clearly enforce permissions between Admin and Doctor users. |
| **DarkaOnline/L5-Swagger** | **(Bonus Feature)** Automatically generates live **OpenAPI/Swagger** documentation from controller annotations, fulfilling the API documentation requirement and 
enabling contract testing. |
| **Pest / PHPUnit** | Used for writing **functional tests**, primarily to validate that the multi-tenant logic correctly prevents cross-organization data access. |

### Frontend & User Experience (UX)
| Dependency | Rationale |
| :--- | :--- |
| **Vue.js** | A lightweight and progressive framework perfect for building dynamic, reactive components like the Appointment Calendar. |
| **Tailwind CSS** | Chosen for its **utility-first approach**, enabling rapid, high-quality, and consistent styling to meet the "polished" visual design requirement. |
| **Headless UI** | Provides highly accessible, unstyled Vue components. Used to build complex, accessible UI elements like the **Organization Switcher** and Modals. |
| **v-calendar** | A dedicated Vue component for visualizing schedules, crucial for the core **Appointment Scheduling** feature. |

---
## ⚙️ Setup and Installation Instructions

These instructions assume you have PHP (>= 8.2), Composer, and Node.js installed.

1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/hermestrimegiste/medicare.git]
    or
    git clone [git@github.com:hermestrimegiste/medicare.git]
    cd medicare
    ```

2.  **Install PHP and Composer Dependencies:**
    ```bash
    composer install
    ```

3.  **Install Node.js Dependencies (Vue/Tailwind):**
    ```bash
    npm install
    or
    yarn install
    or 
    bun install
    ```

4.  **Configure Environment:**
    * Copy the example environment file: `cp .env.example .env`
    * Set your database credentials in `.env` (ensure it points to your PostgreSQL/MySQL server).
    * Copy the example environment file to  `.env.testing` (ensure it points to your PostgreSQL/MySQL server).
    * Generate the application key: `php artisan key:generate`

5.  **Run Migrations and Seed Data:**
    ```bash
    php artisan migrate --seed
    php artisan migrate:fresh --seed --env=testing

    ```
    *(The seed script creates demo organizations and test users for immediate validation of multi-tenancy).*

6.  **Compile Assets & Run Server:**
    ```bash
    npm run dev  # To watch for frontend changes
    php artisan serve
    ```

The application will be accessible at `http://127.0.0.1:8000`.

---
## 🔑 populate Demo data
```bash
    php artisan tinker
    $users = User::factory()->count(10)->create();
    $organizations = Organization::factory()->count(10)->create();
    $appointments = Appointment::factory()->count(10)->create();
    #$medicalRecords = MedicalRecord::factory()->count(10)->create();
    $patients = Patient::factory()->count(50)->create();
    exit;
```

## test 
```bash
    php artisan test
```

## 👤 Test Credentials

| Role | Email | Password | Organization(s) |
|------|-------|----------|-----------------|
| **Admin** | `admin@demo.com` | `password` | Clinic Alpha |
| **Doctor (Multi-Org)** | `doctor@demo.com` | `password` | Clinic Alpha, Clinic Beta |
| **Doctor (Beta)** | `doctor.beta@demo.com` | `password` | Clinic Beta |
| **Admin (Metro)** | `admin.metro@demo.com` | `password` | Metropolitan Hospital |
| **Doctor (Metro)** | `doctor.metro@demo.com` | `password` | Metropolitan Hospital |
