Modular Laravel + Vue Application — Development Specification
Context

You are assisting in the development of a Laravel (MySQL) application using the Vue starter kit.
The goal is to modularize the application into four functional modules, while keeping the code clean, DRY, and easily extensible.

🧱 Application Modules

The application must be structured around the following four modules:

Sales

HR

COGS

Budget

Each module is logically independent and includes:

Its own routes

Its own Vue components, pages, and menus

Its own dashboard

Its own backend logic and controllers

Its own permission definitions

Modules must be visible and accessible based on permissions.

⚙️ Core Functional Goals

Dynamic Module System

Each module is self-contained and can be registered dynamically.

The system should support adding or removing modules without touching the core app.

Module Switching

Replace the default “Switch Team” functionality in the sidebar with a “Switch Module” option.

Switching a module updates the current dashboard, menus, routes, and pages.

The switcher should show only the modules the current user has permission to access.

Permissions

Each module defines its own permission set (e.g., view, manage, edit).

The permission system controls which modules and routes a user can see or interact with.

Integrate with Laravel’s permission handling (e.g., Spatie Permissions or a native equivalent).

Frontend Modularity

Each module contains its own Vue routes, components, and menu definitions.

When the active module changes, only that module’s frontend routes and menus are loaded.

Maintain clear separation between module UI and global layout components.

Backend Modularity

Each module holds its own controllers, models, migrations, and routes.

The backend must auto-discover and register module resources at runtime.

Modules can define their own configuration and localization files.

DRY and Scalable Design

Follow DRY principles across frontend and backend.

Keep module interfaces consistent to simplify development and maintenance.

Provide a single pattern that all future modules can replicate.

📂 Folder and File Organization

A standard structure should be followed for all modules:

app/
 └── Modules/
      ├── Sales/
      ├── HR/
      ├── COGS/
      └── Budget/


Each module includes:

A configuration or manifest file (module.json or config.php)

A Http directory with routes and controllers

A Models directory

A Views directory for Blade or Inertia templates

A front-end module folder under resources/js/modules/<ModuleName>/

🔁 Module Loading Logic

On application boot, Laravel should automatically register all available modules.

Each module’s routes, views, and configurations are dynamically loaded.

On the frontend, the active module determines which Vue routes, menus, and dashboard are rendered.

The module switcher updates the active module both on the frontend (state) and backend (user preference).

🎨 Frontend Behavior

Vue dynamically loads the module’s routes and menus when the module is activated.

Each module’s dashboard is independent.

Menus should reflect the active module context.

Users should only see modules they have permission for.

The frontend router and sidebar must respond to module switching events without requiring a full page reload (if possible).

🔐 Access Control

Each module’s permissions are defined in a module configuration file.

Permissions are merged into the global permission registry during module registration.

A user’s available modules and menus are determined by these permissions.

🧠 Expected Assistant Behavior

When coding or refactoring:

Maintain strict modular boundaries between the four modules.

Ensure all dynamic behaviors (routes, menus, dashboards) depend on the currently active module.

Generate code that is DRY, self-documenting, and consistent across modules.

Use naming conventions and folder structures that make it easy to add new modules in the future.

Apply Laravel’s service container and Vue composition patterns where applicable.

Respect permission checks both on backend routes and frontend UI elements.

✅ Deliverables for Code Generation

The assistant should generate or update:

A module registration system in Laravel.

A frontend dynamic routing system in Vue.

A permission-based module switcher integrated into the existing sidebar.

Separate dashboards, menus, and route groups per module.

A consistent module structure for backend and frontend.

🚀 Goal

After implementation:

The user can switch between modules using the sidebar.

Each module loads its own independent dashboard and routes.

Access to modules and routes is controlled by user permissions.

The structure allows easy expansion with new modules.