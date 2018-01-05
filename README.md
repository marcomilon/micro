# Micro php framework

[![Latest Stable Version](https://poser.pugx.org/fullstackpe/micro/v/stable)](https://packagist.org/packages/fullstackpe/micro)
[![Build Status](https://travis-ci.org/marcomilon/micro.svg?branch=master)](https://travis-ci.org/marcomilon/micro)

Micro is a PHP framework.

It only has three files:

1. Application.php
2. Controller.php
3. Response.php

## Installing via Composer 

## Installing Composer

First you need to install Composer. You may do so by following the instructions at [getcomposer.org](https://getcomposer.org/download/).

## Installing Micro

With Composer installed, you can install a Micro basic application template by running the following command under a Web-accessible folder:

> composer create-project --prefer-dist fullstackpe/micro-basic-app basic

## How it works?

Micro use the MVC pattern. There are two important directories: controllers and views.

#### Controllers
Controllers are store in the controller directory and has to extends the core controller class. A typical controller looks like

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
Controllers are use for render views.

The render function has two parameters: the name of the view file and the variables to be rendered in the view. The function will search for a render file with name equals to its first argument. For example

```php

<?php 
return $this->render('home', [
    'arg1' => $arg1,
    'arg2' => $arg2
]);

```
Will search for a view file named "home".

## Running Micro

You can run micro with php Built-in web server. Run the following command:

> php -S localhost:8080 -t web

Open localhost:8080 in your browser:

> http://localhost:8080

#### Why [micro](https://en.wikipedia.org/wiki/Transport_in_Lima)?

The word micro is used in common-day Peruvian Spanish as an abbreviation for microbus (minibus). 
Micros race from one street corner to another along all the major arterial city roads. They run fast just like this framework.

![alt text](https://raw.githubusercontent.com/marcomilon/micro-basic-app/master/web/img/micro.jpg)

#### Credits

Made in Perú. By [fullstack.pe](https://www.fullstack.pe/)

