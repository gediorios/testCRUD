<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Application\Orm\ApplicationOrm;

class Module
{

    private $sessionManager;
    public function onBootstrap (MvcEvent $e)
    {
        header('Content-Type: text/html;charset=utf-8');
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $this->eventManagerAttaches($eventManager);
        $this->serviceManagerAttaches($e);
        $this->bootstrapSession($e); 
    }
    private function eventManagerAttaches($em)
    {
    	$em->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'error404PreDispath'), 1);
    	$em->attach(MvcEvent::EVENT_DISPATCH, array($this,'permissionPreDispatch'), 2);
    }
    private function serviceManagerAttaches($e)
    {
    	$serviceManager = $e->getApplication()->getServiceManager();
    }
    private function bootstrapSession ($e)
    {
    	
    }

    public function error404PreDispath(MvcEvent $e)
    {

    }
    public function permissionPreDispatch (MvcEvent $e)
    {
        
    }

    public function getConfig ()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig ()
    {
        return array(
            'factories' => array(
                'Application\Orm\ApplicationOrm' => function($sm)
                {
                	$adapter = $sm->get('Zend\Db\Adapter\Adapter');
                	$renderer = $sm->get('Zend\View\Renderer\PhpRenderer');
                	$orm = new ApplicationOrm($sm);
                	return $orm;
                },
            )
        );
    }

    public function getAutoloaderConfig ()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            ),
		 /*'Zend\Loader\StandardAutoloader' => array(
			 'namespaces' => array(
				 __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
			 ),
		 ),*/
		);
    }
}
