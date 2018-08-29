<?php
require '../vendor/autoload.php';

require '../config.php';
require '../data/generated-conf/config.php';

$app = new \Slim\App(['settings'=>$config]);

$container = $app->getContainer();
$container['view'] = new \Slim\Views\PhpRenderer("../app/views/");

// Define app routes
$app->get('/', function ($request, $response, $args) {
  $this->view->render($response,'index.php', ['router'=>$this->router]);
});

// Run app
$app->run();
