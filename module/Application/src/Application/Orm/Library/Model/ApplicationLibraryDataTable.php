<?php
namespace Application\Orm\Library\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Select;

use Application\Orm\Library\ApplicationLibrary;
use Application\Orm\Book\Model\ApplicationBookDataTable;

class ApplicationLibraryDataTable extends AbstractTableGateway
{
    protected $table;
    private $bookDataTable;
    
    public function __construct(Adapter $adapter) 
    {
        $this->table = "libraries";
    	$this->adapter = $adapter;
    }
    public function setBookDataTable(ApplicationBookDataTable $BookDataTable)
    {
        $this->bookDataTable = $BookDataTable;
    }
    public function fetchAllLibraries() 
    {
    	$resultSet = $this->select(function(Select $select) 
                        {
                        	$select->order('date_added ASC');
                        });
    	$libraries = array();
    	foreach ($resultSet as $row) 
    	{
    		$library = new ApplicationLibrary();
    		$books = $this->bookDataTable->getBooksFromLibrary($row->id);
    		$library->setId($row->id)
        		    ->setTitle($row->title)
        		        ->setBooks($books)
        		            ->setDate($row->date_added);
    		$libraries[] = $library;
    	}
    	return $libraries;
    }
    
    public function getLibrary($id) 
    {
    	$row = $this->select(array('id' => (int)$id))->current();
    	if(!$row)
    	{
    	    return false;
    	}
    	$books = $this->bookDataTable->getBooksFromLibrary($row->id);
    	$library = new ApplicationLibrary(array(
    			'id' => $row->id,
    			'title' => $row->title,
    	        'books' => $books,
    	        'date_added' =>  $row->date_added
    	));
    	return $library;
    }
    
    public function saveLibrary(ApplicationLibrary $library) 
    {
    	$data = array(
    			'title' => $library->getTitle(),
    			'date_added' => $library->getDate(),
    	);
    
    	$id = (int)$library->getId();
    
    	if($id == 0) 
    	{
    		$data['date_added'] = date("Y-m-d H:i");
    		if(!$this->insert($data))
    		{
    		    return false;
    		}	
    		else return $this->getLastInsertValue();
    	}
    	elseif($this->getLibrary($id)) 
    	{
    		if (!$this->update($data, array('id' => $id)))
    		{
    		    return false;
    		}
    		else return $id;
    	}
    	else return false;
    }
    
    public function removeLibraryById($id) 
    {
        $id = (int)$id;
        $delete = new Delete();
        $delete->from('lib2book');
        $delete->where('lib2book.library_id='.$id);
        $sql = new Sql($this->adapter);
        
        $isDeleteLib = $this->delete(array('id' => (int)$id));
        if($isDeleteLib == 1)
        {
        	$sql->prepareStatementForSqlObject($delete)->execute();
        }
        return $isDeleteLib;
    }
    
}

?>