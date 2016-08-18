# MassForms Custom Workflow #

This module serves as a scaffold for creating one or more workflows that can be used by a "state" field.

The scaffolding consists of two .yml files:
* module.workflow_groups.yml -- Defines the type(s) of entity(ies) to which one or more workflows may apply.  This should not require much customization, if any.
* module.workflows.yml -- Defines one or more workflows.  Each workflow has some identifying information, but the bulk of the customization is done in the list of "states" and "transitions".  
  - States is the list of statuses in which a form may be; e.g. "Draft" or "Submitted" or "Approved."  
  - Transitions is the list of possible routes from one state to another. Each transition can have only one destination ("to") state, but may come from any one or more source ("from") states.  For instance, an application could move to stage 1 review only from the submitted state, but could move to the denied state from stage 1 review or final review.```
  
For more detail, see the state_machine documentation at [https://github.com/bojanz/state_machine].