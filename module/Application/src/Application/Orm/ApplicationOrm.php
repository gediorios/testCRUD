<?php
namespace Application\Orm;

use Application\Orm\Library\Model\ApplicationLibraryDataTable;
use Application\Orm\Book\Model\ApplicationBookDataTable;
use Ajax\Model\ajaxInterFace;
use Zend\View\Model\ViewModel;
use Zend\Server\Reflection;

class ApplicationOrm implements ajaxInterFace
{
    private $viewTemplate;
    private $serviceManager;
    private $entityNeedRender = false;
    public $library;
    public $book;
    
    public function __construct($sm)
    {
        $this->viewTemplate = 'application/orm/orm.phtml';
        $this->book = new ApplicationBookDataTable($sm->get('Zend\Db\Adapter\Adapter'));
    	$this->library = new ApplicationLibraryDataTable($sm->get('Zend\Db\Adapter\Adapter'));
        $this->library->setBookDataTable($this->book);
        $this->serviceManager = $sm;
    }
    public function invokeEntity($objName = NULL, $action = NULL,$params = NULL) 
    {
       $sortedParams = array();
        $obj = $this->$objName;
        if(is_object($obj))
        {
            $reflection = new \ReflectionClass($obj);
            if($reflection->hasMethod($action))
            {
                foreach ($reflection->getMethod($action)->getParameters() as $key => $value)
                {
                	if(empty($params[$value->name]))
                	{
                		return false;
                	}
                	else 
                	{
                	    $pos = $value->getPosition();
                		$sortedParams[$pos] = $params[$value->name];
                	}
                }
                if($reflection->hasMethod('getTemplateFor') && $obj->getTemplateFor($action) != false)
                {
                    $this->entityNeedRender = true;
                }
                $sortedParams = implode($sortedParams);     
                return $obj->$action($sortedParams);
            }
            else return false;
        }
        else return false;
    }
    public function ajax($params = array())
    {
        $post = $this->serviceManager->get('Application')->getRequest()->getPost();
        //$post->entity;
        //$post->method;
        //$post->methodParams;
        //если звать этот класс асинхронно, с нужными параметрами в POST'е, то можно 
        //вызывать любой набор действий и для библиотеки и для книги
        //в зависимости от логики приложения. ORM соответствует CRUD; 
        if(isset($post->entity) && isset($post->method))
        {
            $result = $this->invokeEntity($post->entity,$post->method,$post->methodParams);
            if($this->entityNeedRender)
            {
                $view = $this->getOrmViewModelFor($post->entity[$post->method],$result);
            }
            else if(is_object($result))
            {
                $view = array('message'=>'объект не требующий отрисовки');
            }
            else if(is_array($result))
            {
                $view = $result;
            }
            else $view = array('message'=> $result);
        }
        else
        {
            $view = $this->getOrmViewModelByDefault(); 
        }
        return array('view'=>$view);
    }
    private function getOrmViewModelFor($template,$method,$result)
    {
    	$viewModel = new ViewModel(array($entity => $result));
    	$viewModel->setTemplate($template);
    	$view = $this->serviceManager->get('Zend\View\Renderer\PhpRenderer')->render($viewModel);
    	return $view;
    }
    private function getOrmViewModelByDefault()
    {
    	$viewModel = new ViewModel(array('libraries' =>$this->library->fetchAllLibraries()));
    	$viewModel->setTemplate($this->viewTemplate);
    	$view = $this->serviceManager->get('Zend\View\Renderer\PhpRenderer')->render($viewModel);
    	return $view;
    }
}

?>