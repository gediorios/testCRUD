<?php
namespace Application\Orm\Book\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Delete;
use Zend\Db\Sql\Select;


use Application\Orm\Book\ApplicationBook;

class ApplicationBookDataTable extends AbstractTableGateway
{
    protected $table;
    public function __construct(Adapter $adapter) 
    {
        $this->table = "books";
    	$this->adapter = $adapter;
    }
    
    public function fetchAllBooks() 
    {
    	$resultSet = $this->select(function(Select $select) 
                                    {
                                    	$select->order('date_added ASC');
                                    });
    	$books = array();
    	foreach ($resultSet as $row) 
    	{
    		$book = new ApplicationBook();
    		$book->setId($row->id)
            		->setTitle($row->title)
            		    ->setAuthor($row->author)
            		        ->setDate($row->date_added);
    		$books[] = $book;
    	}
    	return $books;
    }
    
    public function getBookById($id) {
    	$row = $this->select(array('id' => (int)$id))->current();
    	if(!$row)
    	{
    	    return false;
    	}
    	$book = new ApplicationBook(array(
    			'id' => $row->id,
    			'title' => $row->title,
    			'author' => $row->author,
    	        'date_added' =>  $row->date_added
    	));
    	return $book;
    }
    public function getBooksFromLibrary($id)
    {
        $id = (int)$id;
        $select = new Select($this->table);
        $select->join(
        		'lib2book',
        		'id = lib2book.book_id',
                 array(),
                 $select::JOIN_LEFT);
        $select->where('lib2book.library_id='.$id);
        $resultSet = $this->selectWith($select);
        $books = array();
        foreach ($resultSet as $row)
        {
        	$book = new ApplicationBook();
        	$book->setId($row->id)
        	->setTitle($row->title)
        	->setAuthor($row->author)
        	->setDate($row->date_added);
        	$books[] = $book;
        }
        return $books;
    }
    
    public function saveBook(ApplicationBook $book) 
    {
    	$data = array(
    			'title' => $book->getTitle(),
    	        'author' => $book->getAuthor(),
    			'date_added' => $book->getDate(),
    	);
    
    	$id = (int)$book->getId();
    
    	if($id == 0) 
    	{
    		$data['date_added'] = date("Y-m-d H:i");
    		if(!$this->insert($data))
    		{
    		    return false;
    		}	
    		else return $this->getLastInsertValue();
    	}
    	elseif($this->getBook($id)) 
    	{
    		if (!$this->update($data, array('id' => $id)))
    		{
    		    return false;
    		}
    		else return $id;
    	}
    	else return false;
    }
    
    public function removeBookById($id) 
    {
        $id = (int)$id;
        $delete = new Delete();
        $delete->from('lib2book');
        $delete->where('lib2book.book_id='.$id);
        $sql = new Sql($this->adapter);
        
        $isDeleteBook = $this->delete(array('id' => (int)$id));
        if($isDeleteBook == 1)
        {
            $results = $sql->prepareStatementForSqlObject($delete)->execute();
        }
        return $isDeleteBook;
    }
    
}

?>