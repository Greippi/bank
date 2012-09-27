Dumpomatic Bank Webservice
====

This is a application that will change how you look the banking business.
It all about experimentation. It is made by using Zend 1.2 framework, MySQL,
Apache and PHP. It is a result of experimentation and learning process. So this
in not really nothing production ready code..

Supported output formats are:
====
*  JSON
*  HTML
*  XML
*  CSV

Database Setting (/application/configs/application.ini)
================================
```
resources.db.adapter = "pdo_mysql"
resources.db.params.host = "localhost"
resources.db.params.username = "pankkiiri"
resources.db.params.password = "123asdfasdo93kkaxf"
resources.db.params.dbname = "safe"
resources.db.params.charset = "utf8"
```
Virtual Host
================================
```
Listen 20000

<VirtualHost *:20000>
    ServerName bank.local
    DocumentRoot C:\xampp\htdocs\bank\public
    SetEnv APPLICATION_ENV "development"     
      
    <Directory "C:\xampp\htdocs\bank\public">
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>
```

Creating Database
================================

To run the application you need mysql database. If you all ready have it
you can create a database with next queries by using the mysql-console. 
Login to the console and run the queries.
```
mysql -u root --password
```
Create database:
```
CREATE DATABASE safe;
```
Create user:
```
CREATE USER 'pankkiiri'@'localhost' IDENTIFIED BY '123asdfasdo93kkaxf';
```

Grant needed rights to use database:
```
GRANT SELECT, INSERT, DELETE ON safe.* TO dumpo@'localhost';
```
And then refresh privileges:
```
FLUSH PRIVILEGES;
```
Change current database to 'safe':
```
use safe;
```

Create tables by running SQL-script:
```
/docs/resources/safe.sql
```

```
    ___                 _                        _   _      
   /   \_   _ _ __ ___ | |__   ___   /\/\   __ _| |_(_) ___ 
  / /\ / | | | '_ ` _ \| '_ \ / _ \ /    \ / _` | __| |/ __|
 / /_//| |_| | | | | | | |_) | (_) / /\/\ \ (_| | |_| | (__ 
/___,'  \__,_|_| |_| |_|_.__/ \___/\/    \/\__,_|\__|_|\___|

```
Authors
=========
*  Kilosoft Oy
*  Teemu Puukko