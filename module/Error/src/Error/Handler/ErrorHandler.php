<?php
namespace Error\Handler;

use Zend\Http\Response;
use Zend\View\Model\ViewModel;

class ErrorHandler extends Response
{
    protected $MvcEvent;
    private $ruMessages = array();
    function __construct ($e)
    {
        $this->MvcEvent = $e;
        $this->ruMessages[401] = 'Для просмотра этой страницы вы должны быть авторизованы.';
        $this->ruMessages[200] = 'Страница успешно загружена';
        $this->ruMessages[404] = 'Ошибка 404 - страница не найдена';
    }
    private function setErrorCode($code)
    {   
        $this->setStatusCode($code);
        if(isset($this->ruMessages[$code]))
        {
            $this->setReasonPhrase( $this->ruMessages[$code]);
        }
    }
    private function getErrorMessage($code)
    {
    	$this->setErrorCode($code);
    	return $this->getReasonPhrase();
    }
    public function printError($code)
    { 
    	$message = $this->getErrorMessage($code);
    	$errorViewModel = new ViewModel(array('errorMessage' => $message));
    	$errorViewModel->setTemplate('error/error/index.phtml');

    	$renderer = $this->MvcEvent->getApplication()->getServiceManager()->get('Zend\View\Renderer\PhpRenderer');
    	$layoutViewModel =  $this->MvcEvent->getApplication()->getMvcEvent()->getViewModel();

    	$errorPage = $renderer->render($errorViewModel);
    	$layoutViewModel->content = $errorPage;
    	
    	$layoutPage = $renderer->render($layoutViewModel);
    	echo $layoutPage;
    	die();
    }

    
}

?>