<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;


$loader = require __DIR__ . '/app/autoload.php';
Debug::enable();

$kernel = new AppKernel( 'dev', true );
$kernel->loadClassCache();
$request = Request::createFromGlobals();

$kernel->boot();

$container = $kernel->getContainer();
$container->enterScope( 'request' );
$container->set( 'request', $request );

//setup is done

$templating = $container->get( 'templating' );

use EventBundle\Entity\Event;

$event=new Event();

$event->setName('surprise birthday party');
$event->setLocation('Moon');
$event->setTime(new DateTime());
$event->setDetails(':(');

$em=$container->get('doctrine')->getManager();
$em->persist($event);
$em->flush($event);


