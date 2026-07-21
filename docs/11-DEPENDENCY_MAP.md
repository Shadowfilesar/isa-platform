# ISA DEPENDENCY MAP

==================================================
FOUNDATION
==================================================

Layouts
│
├── Admin Dashboard
├── Players
├── Cases
├── Mission Codes
├── Board
└── Reports

==================================================

Routes
│
├── Authentication
├── Dashboard
├── Players
├── Cases
├── Mission Codes
└── Board

==================================================

Shared Components
│
├── Buttons
├── Cards
├── Tables
├── Forms
├── Alerts
└── Modals

==================================================

Business Logic
│
├── Controllers
│     └── Services
│              └── Models
│                       └── Database

==================================================

RULE

Changing a parent node requires
review of every child node.

Changing a child node must never
modify the parent.

==================================================