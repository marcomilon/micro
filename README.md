# Micro

[![Latest Stable Version](https://poser.pugx.org/fullstackpe/micro/v/stable)](https://packagist.org/packages/fullstackpe/micro) [![Build Status](https://travis-ci.org/marcomilon/micro.svg?branch=master)](https://travis-ci.org/marcomilon/micro)

Micro is a lightweight PHP router.

### Installation

First you need to install Composer. You may do so by following the instructions at [getcomposer.org](https://getcomposer.org/download/). After that run

> composer require fullstackpe/micro

If you prefer you can create a composer.json in your project folder.

```json
{
    "require": {
        "fullstackpe/micro": "^1.1"
    }
}
```

### How it works?

Micro use a php router. It matchs urls with PHP classes (Controllers).

#### Directory structure

To use a url like this: **index.php?r=controllerName/viewName** your directory structure should be:

```
/controllers/
    ControllerClass.php
/views/
    viewFile.php
/web/
    webassets 
    index.php
```

To use a url like this: **index.php?r=moduleName/controllerName/viewName** your directory structure should be:

```
/modules/
    modulesName1/
        controllers/
            ControllerClass.php
        views/
            viewFile.php 
    modulesName2/
        controllers/
            ControllerClass.php
        views/
            viewFile.php 
/web/
    webassets 
    index.php
```

Please be note that the only directory that needs to be public is the **web** directory.           

#### Application 

The Application class is the single point of entry. The constructor have one parameter as an array where you can pass configuration 
key for example to setup a database connection. 

For example:

```php
<?php 

$config = [
    'key' => 'Config value'
];

$app = new \micro\Application($config);
$queryString = $_GET;
$app->run($queryString);

```


#### Controllers

Controllers classes are stored in the controller directory and has to extends the core Controller class. A typical controller looks like this:

```php
<?php 

namespace app\controller;

use micro\Controller;

class CustomCtrl extends Controller
{
    public function index() 
    {
        return $this->render('index');
    }
    
    public function home($arg1, $arg2) 
    {
        return $this->render('home', [
            'arg1' => $arg1,
            'arg2' => $arg2
        ]);
    }
}

```

#### Views

Controllers are use for render views. Views are stored in a directory that has the 
same name of the controller inside the view directory.

The render function has two parameters: the name of the view file and the variables to be rendered in the view. The function will search for a render file with name equals to its first argument. 

For example

Controllers are use for render views. Views are stored in a directory with the 
same name of the controller inside the view directory.

The render function has two parameters: the name of the view file and the variables to be rendered in the view. The function will search for a render file with name equals to its first argument. 

For example

```php
<?php 
return $this->render('home', [
    'arg1' => $arg1,
    'arg2' => $arg2
]);

```
Will search for a view file named "home" in the controllers directory inside the
view folder.

#### Running Micro

You can run micro with php Built-in web server. Run the following command:

> php -S localhost:8080 -t web

Open localhost:8080 in your browser:

> http://localhost:8080

#### Why [micro](https://en.wikipedia.org/wiki/Transport_in_Lima)?

The word micro is used in common-day Peruvian Spanish as an abbreviation for microbus (minibus). 
Micros race from one street corner to another along all the major arterial city roads. They run fast just like this framework.

![alt text](https://raw.githubusercontent.com/marcomilon/micro-basic-app/master/web/img/micro.jpg)

### Contribution

Feel free to contribute! Just create a new issue or a new pull request.

### License

This library is released under the MIT License.

