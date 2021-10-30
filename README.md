# flying-fw
**Custom light PHP MVC framework** including
*(could be that it is slowly evolving in some sort of CMS)*

- installation wizzard
- module builder wizzard
- user and user-groups management 
- user rights system integrated
- logging with logs viewer
- menu management
- board module (sample)
- default theme
- ...

------------------------------------------

Why yet another framework? Because I had time and it was fun :)

------------------------------------------

**Installation:**
1. Clone or copy code on server
2. Go to http://[yourBaseUrl]/install
3. Fill the form and confirm. After you'll be redirected to the main/login page
4. Default super-admin login: test@test.test / test

------------------------------------------

**Module builder:**
1. Open builder/index
2. Set source destination (db table / schema file / create new - write a name)
3. Choose options to be created
4. Confirm   


When all options selected it will be created: 
- DB table *(if doesn't exist)*
- SQL schema file *(if doesn't exist)*
- controller file *(including basic code)*
- model file *(including basic code)*
- index view *(including basic code)*
- update view *(including basic code)*
- add record in the menu DB table

------------------------------------------

[TODO -> workflow description] 
- Controllers, models, views for the module are in folder app/content/*[ controller, model, view ]*/*[module name]*
- Assets are in public folder
- Config data can be manually set or reset in app/config/custom.php  
- Module "Board" is added as an example located in folders app/content/*[ controller, model, view ]*/board 

------------------------------------------

Other libs included:
- jQuery
- Bootstrap
- Fontawesome
- Easyeditor
