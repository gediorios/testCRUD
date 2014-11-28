<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\Orm\Book\ApplicationBook;
use Application\Orm\Library\ApplicationLibrary;

class IndexController extends AbstractActionController
{
    //private $orm;

    
    public function indexAction() 
    {
        
    }
    //это для теста напрямую, не через аякс
    /*protected function getOrm()
    {
    	if (!$this->orm)
    	{
    		$this->orm = $this->getServiceLocator()->get('Application\Orm\ApplicationOrm');
    	}
    	return $this->orm;
    }*/
}
