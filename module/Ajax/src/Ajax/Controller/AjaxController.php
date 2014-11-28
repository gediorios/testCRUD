<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Ajax for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Ajax\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Ajax\Model\AjaxModel;

class AjaxController extends AbstractActionController
{
    public function indexAction()
    {
        if(!$this->getRequest()->isXmlHttpRequest())
        {
            return $this->redirect()->toRoute('home');
        }
        
        $classToInvoke = $this->getRequest()->getPost()->class;
        $params = $this->getRequest()->getPost()->params;  
        if($this->getServiceLocator()->has($classToInvoke))
        {
            $obj = $this->getServiceLocator()->get($classToInvoke);
            $ajax = new AjaxModel($obj,$params);
            $result = $ajax->getJSON();
        }
        else $result = 'false';
        //Да, я понимаю, что не совсем канонично устанавливать HTTP-заголовок
        //в обход зенда через header, да и еще после этого убивать весь движок, но так реально проще и быстрей работает 
        header('content-type:application/json;charset=utf-8');
        die($result);      
    }
}
