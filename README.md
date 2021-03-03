# flying-fw
Custom light PHP framework (mvc)

Why yet another framework? Because I had time and it was fun :)

------------------------------------------
Installation:
1. copy code on server
2. update file: app/config/custom.php
3. run all sql scripts in app/dbschemas
4. default super admin login: test@test.test / test

Module builder:
1. open builder/index
2. set source destination (db table / schema file / create new - write a name)
3. choose options to be created
4. confirm  
If all options selected there should be created table in db/sql schema file, controller, model, index view, update view, views added to menu

Workflow:  
- Controller, module, view for module goes into app/content. Front-end in public folder.  
- Custom module Board is added for example in app/content/ folder.
