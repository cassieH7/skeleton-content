<?php
error_reporting(E_ALL);

chdir(dirname(__DIR__));

//Setup autoloading
require 'vendor/autoload.php';

//instantiation
$app = new \Slim\Slim(array(
	'templates.path' => './views',
	'view' => new \Slim\Views\Twig()
));

//bridge slim and twig
$view = $app->view();
$view->parserOptions = array(
	'debug' => true,
	'cache' => 'data/cache/'
);

//routing
$app->get('/', function () use ($app) {
	$app->render('home.twig');
});

//catch all routing
$app->get('/:method', function ($method) use ($app) {
	try {
		$app->render($method . '.twig');
	} catch (Twig_Error_Loader $e) {
		$app->notFound();
	}
})->conditions(array('method' => '.+'));

$app->notFound(function() use($app) {
	$app->render('404.twig');
});

$app->run();





