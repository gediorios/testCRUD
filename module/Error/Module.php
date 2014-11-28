<?php
namespace Error;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\MvcEvent;
use Error\Handler\ErrorHandler;
//use Zend\Mvc\ModuleRouteListener;

class Module implements AutoloaderProviderInterface
{
    public function onBootstrap (MvcEvent $e)
    {
    	$this->serviceManagerAttaches($e);
    }
    private function serviceManagerAttaches($e)
    {
    	$serviceManager = $e->getApplication()->getServiceManager();
    	$serviceManager->setService('Error\Handler\ErrorHandler',new ErrorHandler($e));
    }
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            /*'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),*/
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

}
