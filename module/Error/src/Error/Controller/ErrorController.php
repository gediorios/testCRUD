<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Error for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Error\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Error\Handler\ErrorHandler;

class ErrorController extends AbstractActionController
{

    public function indexAction()
    { 
        return $this->redirect()->toRoute('home');
    }

    public function fooAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /error/error/foo
        return array();
    }
}
