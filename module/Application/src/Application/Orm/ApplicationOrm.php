<?php
namespace Application\Orm;

use Application\Orm\Library\Model\ApplicationLibraryDataTable;
use Application\Orm\Book\Model\ApplicationBookDataTable;
use Ajax\Model\ajaxInterFace;
use Zend\View\Model\ViewModel;

class ApplicationOrm implements ajaxInterFace
{
    private $viewTemplate;
    private $serviceManager;
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
    public function ajax($params = array())
    {
        $post = $this->serviceManager->get('Application')->getRequest()->getPost();
        $post = $post->toArray();
        //если звать этот класс асинхронно, с нужными параметрами в POST'е, то можно 
        //вызывать любой набор действий и для библиотеки и для книги и хоть для обоих разом
        //в зависимости от логики приложения. ORM соответствует CRUD; 
        if(isset($post['lib']))
        {
        	if(isset($post['lib']['create']))
        	{
        		
        	}
            if(isset($post['lib']['update']))
        	{
        		
        	}
        	if(isset($post['lib']['delete']))
        	{
        	
        	}
        }
        if(isset($post['book']))
        {
            if(isset($post['lib']['create']))
            {
            
            }
            if(isset($post['lib']['update']))
            {
            
            }
            if(isset($post['lib']['delete']))
            {
            	 
            }
        }
        if(empty($post['lib']) || empty($post['book']) || (empty($post['lib']) && empty($post['book'])))
        {
            $view = $this->serviceManager->get('Zend\View\Renderer\PhpRenderer')->render($this->getOrmViewModel());
            return array('view'=>$view);
        }      
    }
    private function getOrmViewModel()
    {
    	$view = new ViewModel(array('libraries' =>$this->library->fetchAllLibraries()));
    	$view->setTemplate($this->viewTemplate);
    	return $view;
    }
}

?>