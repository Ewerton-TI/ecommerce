<?php 
 
require_once("vendor/autoload.php");

use \Site\page;
use \Slim\Slim;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
        
    $page = new Page();
    
    $page->setTpl("index");
});

$app->run();

 ?>