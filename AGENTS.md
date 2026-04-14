# AGENTS.md

## Project

Deny Trans Office Dashboard

## Stack

- Laravel 13
- Filament 5
- MySQL
- Spatie laravel-permission
- Midtrans Snap

## Product context

This is an internal office dashboard for a shuttle/travel company operating Jakarta <-> Cianjur routes.
Internal roles:

- admin
- finance
- owner

## Architecture preferences

- Prefer one Filament internal panel
- Use role-based navigation visibility
- Use enums for statuses
- Use service classes for business logic
- Use policies and permissions for authorization
- Keep business logic out of Filament resource classes when possible
- Prefer clean, maintainable Laravel conventions

## Core business rules

- Prevent vehicle schedule conflicts
- Prevent driver schedule conflicts
- Prevent overbooking
- Generate ticket only after successful payment
- Booking and payment statuses must stay synchronized
- Keep payment webhook handling idempotent

## Coding rules

- Make incremental changes
- Inspect existing code before editing
- Avoid unnecessary abstractions
- Avoid duplicated logic
- Prefer explicit names over short clever names
- Add comments only where necessary
- Keep README updated when setup changes

## Validation checklist

Before finishing a task:

- run migrations if needed
- run relevant tests if present
- check for syntax/runtime errors
- verify authorization behavior
- verify seeders still run
- summarize files changed
