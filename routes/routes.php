<?php
use Core\Router;
use Core\View;


Router::get('/', function () {
    $view = new View();
    $view->render("home");

});