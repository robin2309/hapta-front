<?php

class Application_Model_DbTable_TypePrice extends Zend_Db_Table_Abstract
{

    protected $_name = 'hapta_type_price';

    public function getTypes(){
	    return $this->fetchAll();
    }    

}

