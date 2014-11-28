<?php
namespace Ajax\Model;
use Zend\Json\Json;
class AjaxModel
{
    private $invokedObj ;
    private $params;
    function __construct ($obj,$params)
    {
    	$this->invokedObj = $obj;
    	$this->params = $params;
    }
    
    public function getJSON()
    {
        if($this->params)
        {
            $result = $this->invokedObj->ajax($this->params);
        }
        else
        {
            $result = $this->invokedObj->ajax();
        }
        if(is_string($result) || is_array($result))
        {
            $json = new Json();
            $result = array('answer' =>$result);
            $result = $json->encode($result);
        }
        else $result = 'false';
        return $result;
    }
    
    
    
}

?>