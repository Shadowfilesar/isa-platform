# ISA GIT WORKFLOW
Version 1.0

==================================================
PURPOSE
==================================================

Git is the recovery system of ISA.

Every stable state must be recoverable.

Never work for hours without creating a stable checkpoint.

==================================================
BRANCHES
==================================================

main

Production Ready

Always Stable

Never experimental.

----------------------------

dev

Development Branch

All work happens here.

==================================================
WORKFLOW
==================================================

New Task

↓

Architecture Review

↓

Implementation

↓

Testing

↓

Git Commit

↓

Continue

==================================================
COMMIT RULE
==================================================

Never create one huge commit.

Every completed feature receives one commit.

Correct

Foundation Stable

Players Stable

Mission Codes Stable

Cases Stable

Board Stable

Authentication Stable

Admin UI Stable

Wrong

Update

Fix

Changes

Work

==================================================
BEFORE COMMIT
==================================================

Check

Routes

Views

Controllers

Database

Run application

Verify feature

Only then commit.

==================================================
EMERGENCY RULE
==================================================

If something breaks

STOP

Never continue coding.

Recover previous stable commit.

Then investigate.

==================================================
RECOVERY
==================================================

Git exists to recover.

Never manually rebuild broken code.

==================================================
GOLDEN RULE
==================================================

No Stable Commit

=

No Further Development
