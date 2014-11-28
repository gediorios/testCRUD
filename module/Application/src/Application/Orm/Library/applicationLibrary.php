<?php
namespace Application\Orm\Library;

class applicationLibrary
{

    protected $id;
    protected $title;
    protected $books;
    protected $date_added;
    
    public function __construct(array $options = null) 
    {
        if (is_array($options)) 
        {
            $this->setOptions($options);
        }
    }  
    public function __get($name)
    {
    	$method = 'get'.$name;
    	if (!method_exists($this, $method)) {
    		//throw new Exception('Invalid Method');
    	}
    	return $this->$method();
    }   
    public function __set($name, $value) 
    {
        $method = 'set'.$name;
        if (!method_exists($this, $method)) 
        {
           // throw new Exception('Invalid Method');
        }
        $this->$method($value);
    }
    
    public function setOptions(array $options) 
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) 
        {
            $method = 'set'.ucfirst($key);
            if (in_array($method, $methods)) 
            {
                $this->$method($value);
            }
        }
        return $this;
    }
    
    public function getId() 
    {
        return $this->id;
    }
    public function setId($id) 
    {
        $this->id = $id;
        return $this;
    }
    
    public function getTitle() 
    {
        return $this->title;
    }
    public function setTitle($title) 
    {
        $this->title = $title;
        return $this;
    }
    
    public function getBooks()
    {
    	return $this->books;
    }
    public function setBooks($books)
    {
    	$this->books = $books;
    	return $this;
    }
    
    public function getDate() 
    {
        return $this->date_added;
    } 
    public function setDate($date) 
    {
        $this->date_added = $date;
        return $this;
    }

}
?>