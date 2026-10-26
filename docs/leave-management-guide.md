# Leave Management Guide

## Overview

The leave module is one of the central parts of the ELMIS application. It includes configuration, policy setup, leave calculations, and the expected employee leave application flow.

The main leave-related parts already visible in the project include:

- leave types
- financial years and leave periods
- leave entitlements
- leave policies and policy assignments
- holiday lists and holiday entries
- leave application screens and routes

## Main leave entities

### Leave types
Leave types define the categories of leave used by the system, such as annual, sick, maternity, or other HR categories.

The project treats the leave type as the definition layer, while entitlement and allocation logic are tied to financial years and assigned policy rules.

### Financial years and leave periods
These structure the leave cycle and define the time windows in which rules apply.

This is important because the project clearly separates:

- the year definition
- the leave-period rules
- the actual entitlement configuration

### Leave entitlements
Entitlements are the year-specific leave rule values tied to a leave type.

The design in this project is to keep the rule in the entitlement layer rather than mixing it into the leave type definition itself.

### Leave policies and assignments
Leave policies are part of the broader configuration model. They are used to define the conditions under which leave is assigned and calculated.

### Holiday lists
Holiday management is implemented as a persistent list model. The project uses a final design where holiday lists are reusable across financial years, while each holiday row remains linked to a specific year.

## Leave workflow direction

The current project structure shows the intended direction for leave applications:

1. select employee or employee record
2. choose leave type
3. enter period and duration
4. calculate dates and projected balance
5. validate on the backend
6. save only after final business checks

This is the correct pattern because the real logic belongs in the server-side service layer, not only in the UI.

## Business rules already reflected in the code

The project already includes several important leave rules:

- dates are validated and checked carefully
- calendar logic is centralized in service logic
- leave cannot start on a weekend
- calculation methods must be valid
- policy and entitlement rules are separated from basic leave-type definitions

These rules are strong foundations for a reliable leave engine.

## Where the logic sits

The leave system follows the same architecture as the rest of the project:

- `app/Models` - database access and entity records
- `app/Services` - validation and business rules
- `app/Controllers` - request handling and controller actions
- `app/Views` - leave pages and interfaces
- `routes/web.php` - route registration for leave screens

## Key files to know

- `app/Controllers/LeaveController.php` - main leave module controller
- `app/Services/LeaveCalculator.php` - calculation and date logic
- `app/Services/LeaveEntitlementService.php` - entitlement rules
- `app/Services/LeavePolicyService.php` - policy logic and assignments
- `routes/web.php` - leave routes and access points

## Current status

The system has a strong setup layer for leave administration, but the actual employee-facing leave application flow is still the next major milestone.

The project is already capable of configuration and processing setup, while the final transaction layer still needs to be completed and validated end-to-end.

## Summary

The leave module is structurally sound and aligned with the rest of the HR system. The foundation is strong, but the final leave application and approval workflow still needs to be completed to make the feature fully operational.
