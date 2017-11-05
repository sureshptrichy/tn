# Application Rules

This document outlines the business and visibility rules of the application.

## Visibility Modifiers
Only **Super User** and **Property Manager** may modify visibility, and these modifiers exist at the Property level (set on the *Settings/Properties* page).

## Filter Modifiers
The filters affect large portions of the application in various ways. During creation of an Objective, unattached Strategy or User, the new object is assigned to the Property (and optionally the Division and Department, depending on the user's role) specified by the current filters.

Changing the filters typically modifies the information visible on screen. For example, a **Property Manager** can select a specific Division or Division/Department combination in order to limit what Objectives or unattached Strategies are shown on screen.

The User filter is visible at each filter level below your role. For example, a **Division Manager** will only see the User filter once they have selected a specific Department to view. A **Super User** will see the User filter once a Property is selected (it is actually impossible to *not* select a Property, so the **Super User** will always see the User filter).

In essence, the filters allow the user to have the pages populated as if they were a member of the Division, Department and User selected in the filters.

The User drop-down is further affected by the Visibility Modifiers, depending on which page is being viewed. If Objective visibility is being restricted, for example, the User drop-down will also follow the modifier (in this case, only showing yourself and users with a lower role).

----------------------------------------------------------------------------

# Annual Strategic Plan

## *New Objective*
* only **Super User**, **Property Manager**, **Division Director** and **Department Manager** may add Objectives
* Objective is visible to all users of Property
	* unless `private` flag is set, making Objective only visible to Objective creator

#### Database
* record is added to `Objective` table
* record is added to `Competency_Objective` table
* record is added to `Property_Objective` table
* if there is a current Division, record is also added to `Division_Objective` table
* if there is a current Department, record is also added to `Department_Objective` table


## *New Strategy*
* only the Objective creator and higher roles may add a Strategy to an Objective
* Strategy is visible to anyone who can see the parent Objective, as well as the user assigned to the Strategy regardless of Objective visibility

#### Database
* record is added to `Strategy` table
* record is added to `Objective_Strategy` table
* record is added to `User_Strategy` table
* record is added to `Property_Strategy` table
* if there is a current Division, record is also added to `Division_Strategy` table
* if there is a current Department, record is also added to `Department_Strategy` table


## Visibility Modifiers
* hide Objectives created by users above the current user
	* Strategy exception noted above will override this setting
	* User Filter will only show the current user, and users with a lower role
* hide Strategies assigned to users above the current user

----------------------------------------------------------------------------

# Strategies & Tactics

## *New Strategy*
* Anyone may add a Strategy
* a Strategy may only be assigned to a user lower than the Strategy creator, or to the Strategy creator
* Strategy is visible to all members of a Property
	* unless `private` flag is set, making Strategy only visible to Strategy creator and assignee

#### Database
* record is added to `Strategy` table
* record is added to `Competency_Strategy` table
* record is added to `User_Strategy` table
* record is added to `Property_Strategy` table
* if there is a current Division, record is also added to `Division_Strategy` table
* if there is a current Department, record is also added to `Department_Strategy` table


## *New Tactic*
* only Strategy creator and higher roles, and the Strategy assignee may add a Tactic to a Strategy
* Tactic is visible to anyone who can see the parent Strategy

#### Database
* record is added to `Tactic` table
* record is added to `Strategy_Tactic` table


## Visibility Modifiers
* hide Strategies assigned to users above the current user
	* User Filter will only show the current user, and users with a lower role
