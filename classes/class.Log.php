<?php

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
        $oUser = new User();
        $oUserData = $oUser->getUsersData();

        while (($aUser = $oUserData->fetch_assoc()) != NULL) {
            if (($this->_login == $aUser['login'] && md5($this->_password) == $aUser['password'])) {
                $_SESSION['login'] = $this->_login;
                $_SESSION['role'] = $aUser['role'];

                return true;
            }
        }

        return false;
    }
}
?>
