<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 DEMO Project Template</h1>
    <br>
</p>


DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

### Install via Composer

Installation:

Step 1: clone the repo

``` $ sudo git clone https://github.com/shimuldas72/yii2_demo.git ```

Step 2: update composer

``` $ sudo composer update ```

Step 3:  set permission for directory `web/assets` and `runtime`
  
``` $ sudo chmod -R 777 web/assets ```

``` $ sudo chmod -R 777 runtime/ ```

Step 4: create database and import `demo_db.sql` file from `DB` directory

Step 5: Update database name, username and password 

``` $ sudo nano config/db.php ```

Step 6: Run the site in your browser `http://localhost/yii2_demo/web`



CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

**NOTES:**
- as like as step 5


