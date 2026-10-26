# Project Overview

## Purpose

ELMIS is a custom employee leave and HR management system built in PHP. It is designed to support employee records, department setup, leave policy configuration, leave transactions, and administrative reporting.

## Main modules in the project

### 1. Authentication and access
- login and registration flow
- password reset and email verification
- session handling
- middleware-based access control
- admin and user route protections

### 2. Employee and department management
- employee profiles and records
- department setup and assignment
- employee bulk import support
- deployment and staff organization flows

### 3. Leave management
- leave types
- leave periods
- financial year structure
- leave entitlements
- leave policies and assignments
- holiday lists and holiday management
- leave applications and approval-related flows

### 4. Administration and reports
- dashboard views
- reports screen
- bulk actions and import tools
- system tools and utilities

## Technology stack

- PHP 8.1+
- MySQL / MariaDB
- Composer
- PHPMailer
- custom MVC structure
- PHPUnit for automated tests

## Main project folders

- `app/Controllers` - request handlers for routes
- `app/Core` - shared framework utilities
- `app/Middleware` - auth and role enforcement
- `app/Models` - database entities and queries
- `app/Services` - validation and business logic
- `app/Views` - admin and user interface templates
- `config/` - configuration and SQL schema
- `routes/web.php` - application routes
- `tests/` - project tests
- `docs/` - project documentation

## Core request flow

The app follows a standard pattern:

1. route is registered in `routes/web.php`
2. controller receives the HTTP request
3. controller calls the needed service or model
4. model interacts with the database
5. view renders the final response

This is the default pattern used for most sections of the system.

## Setup

### Install dependencies

```bash
composer install
```

### Configure the database

Import the schema from:

- `config/database.sql`

### Run locally

```bash
php -S localhost:8000 -t public
```

Then open:

```text
http://localhost:8000
```

## Current project position

The project already has a good HR and leave foundation. Most of the base structure is in place, and the remaining work is mostly focused on finalizing business flows, validation, and end-to-end completion rather than starting from scratch.

## Documentation note

Older notes are kept in `docs/archive/` for reference. The active project guide is the set of files in the root of `docs/`.
