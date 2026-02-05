# 🔒 vCISO Platform: Cybersecurity Assessment for SMEs

vCISO is a comprehensive cybersecurity self-assessment platform designed for small and medium enterprises (SMEs). It enables businesses to quickly evaluate their security posture and receive AI-generated actionable recommendations.

This project demonstrates expertise in building complex, production-ready applications with **multi-tenant architecture**, **Role-Based Access Control (RBAC)**, and **AI integration**, using a modern Laravel/Vue stack.

---

## 🚀 Project Overview

### Problem Statement

- Low cybersecurity awareness among SMEs
- Delayed decisions due to lack of clear, quantified business-oriented diagnostics
- Difficulty qualifying leads for cybersecurity consultants

### Solution

A web platform that enables:

1. **Self-Assessment**: Fill out a questionnaire (5-20 min depending on level)
2. **AI-Generated Report**: Automatic executive report (PDF + web page) via AI
3. **Expert Consultation**: Schedule a video call with a consultant to take action

---

## ✨ Key Features (Planned)

### Two Assessment Levels

#### Level 1: Express Diagnostic (5 minutes)

- **Target**: CEO, CFO, COO (non-technical profiles)
- **Questions**: 6 strategic business-oriented questions
- **Output**: Light executive report (2 pages) + global score + strong CTA

#### Level 2: Detailed Self-Assessment (15-20 minutes)

- **Target**: CIO, CISO, IT Managers (technical profiles)
- **Questions**: 8 sections with sub-questions and dependencies
- **Format**: Interactive mindmap with explanatory tooltips
- **Output**: Comprehensive technical report (6-10 pages) + roadmap + recommended pentest

### Core Multi-Tenancy

- **Organization Isolation**: All data strictly isolated by `organization_id` (consultancy firms)
- **Organization Switching**: Consultants affiliated with multiple firms can switch context instantly

### Role-Based Access Control (RBAC)

- **Admin**: Manages organization settings and members
- **Consultant**: Manages leads, assessments, and reports
- **Respondent**: SME users filling out assessments (public access)

### Business Features (Planned)

- **Assessment Management**: Express and detailed questionnaires with dependencies
- **AI Report Generation**: Powered by OpenAI GPT-4 for personalized recommendations
- **Scoring Engine**: Risk assessment with maturity levels per domain
- **Booking System**: Integration with Cal.com/Calendly for consultant appointments
- **Consultant Dashboard**: Lead management with filters, notes, and exports

---

## 🛠️ Technology Stack

### Backend & Core Framework

| Dependency           | Purpose                                                                |
| :------------------- | :--------------------------------------------------------------------- |
| **Laravel (PHP)**    | Robust framework for multi-tenant data isolation and security          |
| **PostgreSQL/MySQL** | Relational database for structured assessment data                     |
| **Inertia.js**       | Monolith architecture combining Laravel backend with Vue.js reactivity |

### Backend Libraries

| Dependency                    | Purpose                          |
| :---------------------------- | :------------------------------- |
| **Laravel Breeze**            | Authentication scaffolding       |
| **Spatie/laravel-permission** | Role-Based Access Control (RBAC) |
| **OpenAI API**                | AI-powered report generation     |
| **Laravel PDF**               | PDF report generation            |
| **Redis**                     | Queue management and caching     |

### Frontend & UX

| Dependency       | Purpose                                         |
| :--------------- | :---------------------------------------------- |
| **Vue.js**       | Reactive components for interactive assessments |
| **Tailwind CSS** | Utility-first styling for modern design         |
| **Headless UI**  | Accessible, unstyled components                 |
| **v-calendar**   | Appointment scheduling visualization            |

---

## ⚙️ Setup and Installation

### Prerequisites

- PHP >= 8.2
- Composer
- Node.js >= 18
- PostgreSQL or MySQL

### Installation Steps

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/hermestrimegiste/vciso-platform.git
    cd vciso-platform
    ```

2.  **Install PHP Dependencies:**

    ```bash
    composer install
    ```

3.  **Install Node.js Dependencies:**

    ```bash
    npm install
    # or
    yarn install
    # or
    bun install
    ```

4.  **Configure Environment:**

    ```bash
    cp .env.example .env
    # Edit .env with your database credentials
    php artisan key:generate
    ```

5.  **Run Migrations and Seed Data:**

    ```bash
    php artisan migrate:fresh --seed
    ```

6.  **Compile Assets & Start Server:**
    ```bash
    npm run dev  # Watch for frontend changes
    php artisan serve
    ```

The application will be accessible at `http://127.0.0.1:8000`.

---

## 🔑 Test Credentials

| Role           | Email                 | Password   | Organization(s)  |
| -------------- | --------------------- | ---------- | ---------------- |
| **Admin**      | `admin@demo.com`      | `password` | Acham Consulting |
| **Consultant** | `consultant@demo.com` | `password` | Acham Consulting |

---

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --filter=AuthTest
```

---

## 📋 Project Status

This project is currently in **Phase 1: Cleanup & Foundation**. The medical domain code (vCISO) has been removed, and the foundation for the vCISO platform is being established.

### Completed

- ✅ Multi-tenant architecture (organizations)
- ✅ Authentication system (Laravel Breeze)
- ✅ RBAC with Spatie Permission
- ✅ Clean codebase foundation

### In Progress

- 🚧 Database schema for assessments
- 🚧 Assessment questionnaires (Express & Detailed)
- 🚧 AI integration for report generation

### Planned

- ⏳ Scoring engine
- ⏳ PDF report generation
- ⏳ Booking system integration
- ⏳ Consultant dashboard

---

## 📄 License

This project is proprietary software developed for cybersecurity assessment services.

---

## 📞 Contact

For questions or collaboration inquiries, please contact:

- Email: [contact information]
- Project: vCISO Platform by Acham Consulting
