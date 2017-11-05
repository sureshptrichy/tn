# Database Operations

This document describes what happens with the database when various actions are committed in the application.

In all cases, an **Edit** operation first reverses any non-root-table (e.g. `Property_Competency` is a non-root table, but `Property` and `Compentency` are root tables) operations, then performs a **New** operation using an `UPDATE` instead of `INSERT` query for the root table.

In all cases, a **Delete** operation simply changes the `status` flag in the root table to `0`, leaving non-root-tables unchanged.

---

## Settings Pages
### New Competency
* record is added to `Competency` table
* if user is **Super User** or **Administration**:
	* if the `default` flag is *not* set, record is also added to `Property_Competency` table
* if user is anything else:
	* if the `default` flag is *not* set, record is also added to `User_Competency` table

### New Property
* record is added to `Property` table

### New Division
* record is added to `Division` table
* if the `default` flag is *not* set, record is also added to `Property_Division` table

### New Department
* record is added to `Department`
* if the `default` flag is *not* set, record is also added to `Division_Department` table

### New User
* if new user role is **Super User**, record is added to `User` table
* if new user role is anything else, record is *also* added to `Property_User` table
* if new user role is **Division Director**, record is *also* added to `Division_User` table
* if new user role is **Department Manager** or lower, record is *also* added to `Department_User` table
* record is added to `User_Role` table

### New Role
* record is added to `Acl_Role` table
* record is added to `Acl` table

---

## Annual Strategic Plan Page
### New Objective
* record is added to `Objective` table
* record is added to `Property_Objective` table
* if user is **Division Director**, record is also added to `Division_Objective` table
* if user is **Department Manager**, record is also added to `Department_Objective` table
* lower users cannot add Objectives

### New Strategy
* record is added to `Strategy` table
* record is added to `Objective_Strategy` table
* record is added to `User_Strategy` table

### New Tactic
* record is added to `Tactic` table
* record is added to `Strategy_Tactic` table

---

## Strategies & Tactics Page
### New Strategy
* record is added to `Strategy` table
* record is added to `User_Strategy` table
* if user is **Super User** or **Administration**, record is also added to `Property_Strategy` table
* if user is **Division Director**, record is also added to `Division_Strategy` table
* if user is **Deparment Manager**, record is also added to `Department_Strategy` table

### New Tactic
* record is added to `Tactic` table
* record is added to `Strategy_Tactic` table
