# ISA CODING STANDARD
Version: 1.0

==================================================
GENERAL
==================================================

Readable code.

Small methods.

Meaningful names.

No duplicated logic.

==================================================
CONTROLLERS
==================================================

Controllers coordinate.

They do not contain business logic.

Business logic belongs to Services.

==================================================
SERVICES
==================================================

Services contain business rules.

Controllers call Services.

==================================================
MODELS
==================================================

Models represent data.

Avoid placing business workflows inside Models.

==================================================
VIEWS
==================================================

Views display data only.

No database queries.

No business logic.

No large PHP blocks.

==================================================
CSS
==================================================

Feature CSS stays inside feature.

Shared CSS stays inside components.

Never inline CSS.

==================================================
JAVASCRIPT
==================================================

One responsibility per file.

Avoid global variables.

Prefer event delegation when possible.

==================================================
DATABASE
==================================================

Never edit old migrations after production.

Create new migrations for schema changes.

==================================================
NAMING
==================================================

Controllers

PlayerController

CaseController

MissionCodeController

Services

PlayerService

CaseService

MissionCodeService

==================================================
COMMENTS
==================================================

Comment WHY.

Do not comment WHAT.

==================================================
GOAL
==================================================

Every developer should write code
that looks like it was written
by the same person.