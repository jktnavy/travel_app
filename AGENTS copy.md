# AGENTS.md

## Project
Deny Trans

## Main architecture
This project is split into two applications:

1. Internal office dashboard
- Laravel 13
- Filament 5
- MySQL
- Spatie permission
- Midtrans

2. Passenger-facing mobile web / PWA
- Laravel backend API or shared backend
- Mobile-first frontend
- Must not use Filament for customer-facing booking flow

## Domain rules
- Route focus: Jakarta <-> Cianjur
- Prevent vehicle conflicts
- Prevent driver conflicts
- Prevent overbooking
- Generate ticket only after successful payment
- Keep webhook handling idempotent
- Keep booking status and payment status synchronized

## Roles
- admin
- finance
- owner

## Coding approach
- Work incrementally
- Inspect before editing
- Keep business logic out of UI resource classes when possible
- Use enums for statuses
- Use service classes for payment and ticketing
- Prefer explicit readable names
- Update README when setup changes

## Delivery
At the end of each batch:
- summarize changed files
- mention commands run
- mention next recommended step
