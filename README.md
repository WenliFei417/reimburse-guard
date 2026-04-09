# ReimburseGuard

A lightweight Symfony platform for healthcare reimbursement record validation.

Built as a portfolio project demonstrating PHP/Symfony development, MySQL, TDD, and CI/CD practices.

---

## Screenshots

![Dashboard](docs/screenshot1.jpg)
![Dashboard Exception List](docs/screenshot2.jpg)
![Import CSV](docs/screenshot3.jpg)

---

## Tech Stack

- **PHP 8.5 / Symfony 7.2**
- **MySQL 8.0** / Doctrine DBAL
- **PHPUnit 13**
- **GitHub Actions** (CI)
- **Twig** templates
- Developed with **PhpStorm**

---

## Features

- **CSV Import** — Upload reimbursement records via CSV file
- **Validation Engine** — 5 automated validation rules:
  - Missing required fields
  - Invalid or future service date
  - Zero or negative billed amount
  - Reimbursed amount exceeds billed amount
  - Duplicate records (same patient + date + claim type)
- **Exception Dashboard** — View all flagged records with rule breakdown summary
- **Review Workflow** — Update exception status (New / In Review / Resolved) with notes

---

## Project Structure

```
src/
├── Controller/
│   ├── DashboardController.php   # Exception dashboard
│   ├── ImportController.php      # CSV upload + trigger validation
│   └── ReviewController.php      # Update exception status
├── Service/
│   ├── CsvImporter.php           # Parse and store CSV records
│   └── ValidationEngine.php      # Orchestrate all validators
└── Validator/
    ├── MissingFieldValidator.php
    ├── InvalidDateValidator.php
    ├── InvalidAmountValidator.php
    ├── ReimbursementExceedsBilledValidator.php
    └── DuplicateRecordValidator.php

tests/
└── Validator/                    # PHPUnit unit tests for each rule

.github/
└── workflows/
    └── ci.yml                    # GitHub Actions CI pipeline
```

---

## Local Setup

**Requirements:** PHP 8.5, Composer, MySQL 8.0, Symfony CLI

```bash
git clone https://github.com/WenliFei417/reimburse-guard.git
cd reimburse-guard
composer install
```

Configure your `.env` file:

```env
DATABASE_URL="mysql://root:yourpassword@127.0.0.1:3306/reimburse_guard?serverVersion=8.0&charset=utf8mb4"
```

Create the database and tables:

```bash
mysql -u root -p -e "CREATE DATABASE reimburse_guard CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p reimburse_guard < schema.sql
```

Start the development server:

```bash
symfony serve
```

Visit `http://127.0.0.1:8000`

---

## Running Tests

```bash
php bin/phpunit tests/Validator/
```

Expected output:

```
OK (14 tests, 14 assertions)
```

---

## CI/CD

GitHub Actions automatically installs dependencies and runs all PHPUnit tests on every push to `main`.

See `.github/workflows/ci.yml`.

---

## Sample CSV Format

```csv
record_id,patient_id,provider_name,service_date,claim_type,billed_amount,reimbursed_amount,status
R001,P001,General Hospital,2024-03-01,inpatient,1000.00,800.00,pending
R002,P002,City Clinic,2024-03-02,outpatient,500.00,600.00,pending
R003,P003,Health Center,,outpatient,0.00,100.00,pending
R004,P001,General Hospital,2024-03-01,inpatient,1000.00,800.00,pending
R005,P005,Downtown Medical,2026-12-01,inpatient,-200.00,100.00,pending
```

The sample above intentionally includes records that trigger all 5 validation rules.

---

## Database Schema

See `schema.sql` for the full table definitions.

Two tables:
- `records` — imported reimbursement records
- `exceptions` — flagged validation results with review status
