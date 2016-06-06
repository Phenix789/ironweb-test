Iron Web Test
=============

What's inside?
--------------
You can look to **IronwebBundle** to find the source code.

I use many community bundle like :

  * **friendsofsymfony/rest-bundle** For the REST Api
  * **jms/serializer-bundle** For the serialization
  * **nelmio/api-doc-bundle** For the documentation and an user interface with Swagger UI
  * **doctrine/doctrine-migrations-bundle** For create database migration
  * **doctrine/doctrine-fixtures-bundle** For create fake data
  * **fzaninotto/faker** For *beautiful* fake data
  * ... and some others

Install
-------

You can set the project with : *php composer.phar install*

[*composer*](https://getcomposer.org/)

Databases
---------

You can create database schema with command : *php bin/console doctrine:migrations:migrate*

PHPUnit
-------

You can launch unit test with command : *php vendor/phpunit/phpunit/phpunit.php*

Fixtures
--------

You can load data on database with : *php bin/console doctrine:fixtures:load --fixtures=tests/IronwebBundle/DataFixtures/*

Swagger UI
----------

You can explore the REST API via an url : <host>/api/doc
