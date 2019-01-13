<?php

class Application_Model_DbTable_User extends Zend_Db_Table_Abstract
{

    protected $_name = 'hapta_user_fb';
    protected $_primary = 'idUserFb';
    
    public function getUser($userId){
	    $row = $this->fetchRow('idUserFb = ' . $userId);
	    if(!$row){
		    throw new Exception("Utilisateur non trouvé : " . $userId);
	    }
	    return $row;
    }
    
    public function editUser($data, $userId){
	    $this->update($data, 'idUserFb = '.$userId);
    }

}

