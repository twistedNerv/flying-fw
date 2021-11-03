# flying-fw
**Custom light PHP MVC framework** *(could be that it is slowly evolving in sort of CMS direction)*

Including: 
- installation wizzard
- module builder 
- user and user-groups management 
- user rights system integrated
- logging with logs viewer
- menu management
- board module
- default theme
- ...

------------------------------------------

Why yet another framework? Because I had time and it was fun :)

------------------------------------------

Installation:
1. Clone or copy code on server
2. Run http://yourBaseUrl/install
3. Fill form and press Install. After install you'll be redirected to main/login page
4. Default super-admin login: test@test.test / test

------------------------------------------

Module builder:
1. Open builder/index
2. Set source destination (db table / schema file / create new - write a name)
3. Choose options to be created
4. Confirm   


When all options selected it will be created: 
- DB table *(if doesn't exist)*
- SQL schema file *(if doesn't exist)*
- controller file *(including basic code)*
- model file *(including basic code)*
- index view *(including start code)*
- update view *(including basic code)*
- add record in the menu DB table

------------------------------------------

[TODO -> workflow description] 
- Controllers, models, views for module are in folder app/content/*[ controller, model, view ]*/*[module name]*
- Assets are in public folder
- Config data can be manually set or reset in app/config/custom.php  
- Module Board is added as example in folders app/content/*[ controller, model, view ]*/board 

------------------------------------------

Other libs used:
- jQuery
- Bootstrap
- Fontawesome
- Easyeditor
