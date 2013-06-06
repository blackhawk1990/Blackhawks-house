<?php

require_once 'class.Db.php';

class Log 
{
    private $_login;
    private $_password;
    
    public function __construct($sLogin, $sPassword) 
    {   
        $this->_login = $sLogin;
        $this->_password = $sPassword;
    }
    
    public function login()
    {
        $db = new Db();
        $db->getUsersData();

        while (($user = $db->_query->fetch_assoc()) != NULL) {
            if (($this->_login == $user['login'] && md5($this->_password) == $user['password'])) {
                $_SESSION['login'] = $this->_login;
                $_SESSION['role'] = $user['role'];

                return true;
            }
        }

        return false;
    }
}
?>
