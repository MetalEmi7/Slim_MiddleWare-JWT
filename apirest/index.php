<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../composer/vendor/autoload.php';
require '../composer/vendor/paragonie/random_compat/psalm-autoload.php';

      //PHP 7.1.9
      require_once dirname(__FILE__).'/classes/AccesoDatos.php';
      require_once dirname(__FILE__).'/classes/AuthJWT.php';
      require_once dirname(__FILE__).'/classes/MWCORS.php';
      require_once dirname(__FILE__).'/classes/MWAuth.php';
      require_once dirname(__FILE__).'/classes/personaApi.php';
      
      
      /*    //PHP 5.3.0
      require_once '/classes/AccesoDatos.php';
      require_once '/classes/AuthJWT.php';
      require_once '/classes/MWCORS.php';
      require_once '/classes/MWAuth.php';
      require_once '/classes/personaApi.php';
      */

      
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);


$app->group('/personas', function () {
 
  $this->get('/', \personaApi::class . ':getAll');
 
  $this->get('/{id}', \personaApi::class . ':getById');

  $this->post('/insert', \personaApi::class . ':insert');

  $this->post('/delete', \personaApi::class . ':delete');

  $this->post('/update', \personaApi::class . ':update');

  $this->post('/subirFoto', \personaApi::class . ':Subir');
     
})->add(\MWCORS::class . ':enableCORS');



$app->group('/login', function () {
  
   $this->post('/signin', \personaApi::class . ':validatePersona');
  
   $this->post('/signup', \personaApi::class . ':registerPersona');
 
 })->add(\MWCORS::class . ':enableCORS');


$app->run();