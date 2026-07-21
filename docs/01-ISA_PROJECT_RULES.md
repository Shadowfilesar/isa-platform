# ISA PROJECT RULES
Version: 1.0
Status: OFFICIAL

---

# Philosophy

ISA is not developed by patching code.

ISA is developed by architecture.

Every modification must preserve the architecture.

Every feature must be isolated.

The project must always remain expandable.

---

# Golden Rule

Never modify a file outside the layer where the problem exists.

If a feature belongs to the UI,
do not modify Controllers.

If a feature belongs to Controllers,
do not modify Layouts.

If a feature belongs to Database,
do not modify Views.

---

# Layers

Layer 1
Foundation

Layer 2
Design System

Layer 3
Feature Modules

Layer 4
Business Logic

Every file belongs to exactly one layer.

---

# Foundation

Foundation files are LOCKED.

Nobody modifies them during feature development.

If a task requires Foundation changes:

STOP

Explain why.

Wait for approval.

---

# Design System

Contains only reusable UI.

Examples:

Buttons

Cards

Tables

Forms

Inputs

Badges

Breadcrumbs

Filters

Search

Empty States

Typography

Spacing

Colors

Icons

No business logic.

---

# Feature Modules

Every feature is independent.

Examples:

Players

Cases

Mission Codes

Board

Reports

Each feature modifies ONLY its own files.

Never another module.

---

# Business Logic

Controllers

Services

Models

Policies

Requests

Business Logic must never be modified for UI requests.

---

# Components

No duplicated HTML.

No duplicated Blade.

No duplicated CSS.

If something appears twice

Create Component.

---

# CSS

Shared CSS goes inside

resources/css/components/

Feature CSS goes inside

resources/css/admin/

Never place CSS inside Blade.

Never inline CSS.

---

# Layout

Layouts are Foundation.

Never modify them during feature work.

---

# Before Coding

Always perform:

1 Inventory

2 Architecture Check

3 Dependency Check

4 Impact Analysis

5 Approval

6 Implementation

7 Testing

8 Git Commit

Never skip these steps.

---

# Git

Every stable milestone gets a commit.

Example

Foundation Stable

Players Stable

Mission Codes Stable

Cases Stable

Board Stable

Never continue working without a recovery point.

---

# AI Rules

Before any AI writes code:

Read this document.

Read Architecture.

Read Feature Checklist.

Only then generate code.

---

# Final Principle

Architecture first.

Code second.

Always.