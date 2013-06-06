<?php
    class Db
    {
        public static $_host = "localhost";
        public static $_db = "blackhawk";
        public static $_login = "root";
        public static $_pass = "";
//        public static $_host = "mysql.cba.pl";
//        public static $_db = "musec_tk";
//        public static $_login = "blhouse";
//        public static $_pass = "skomp3l";
        /*public static $_host = "mysql.cba.pl";
        public static $_db = "blackhawkshouse_pl";
        public static $_login = "blackhawk90";
        public static $_pass = "skomp3l";*/
        private $_Hnd = NULL;
        public $_query;
        private $_table;
        
        private function query($_Hnd, $query)
        {
            return $_Hnd->query($query);
        }
        private function multiquery($_Hnd, $query)
        {
            return $_Hnd->multi_query($query);
        }
        public function  __construct($table = "_realizations")
        {
            $this->_table = $table;
            
            $this -> _Hnd = @new mysqli(Db::$_host, Db::$_login, Db::$_pass, Db::$_db);

            if(mysqli_connect_error () != NULL)
            {
                echo mysqli_connect_errno();
            }
            else
            {
                @$this -> query ($this -> _Hnd, 'SET NAMES utf8');
                @$this -> query ($this -> _Hnd, "
                    CREATE TABLE IF NOT EXISTS _realizations(`id` INT( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                    `tytul` VARCHAR( 22 ) NOT NULL ,
                    `tekst` TEXT NOT NULL ,
                    `data` VARCHAR( 20 ) NOT NULL ,
                    `zajawka` VARCHAR( 60 ) NOT NULL ,
                    `obrazek` VARCHAR ( 60 ) NOT NULL ,
                    `url` VARCHAR ( 60 ),
                    `used_technologies` VARCHAR ( 60 ) NOT NULL
                    ) ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
                @$this -> query ($this -> _Hnd, "
                    CREATE TABLE IF NOT EXISTS _users(`id` INT PRIMARY KEY AUTO_INCREMENT,
                    `login` VARCHAR(50) NOT NULL, `password` VARCHAR(40) NOT NULL, 
                    `role` ENUM('admin','user','reporter') NOT NULL
                    ) ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
                @$this -> query ($this -> _Hnd, "
                    CREATE TABLE IF NOT EXISTS _config(`id` INT PRIMARY KEY AUTO_INCREMENT,
                    `label` VARCHAR(30) NOT NULL, `value` VARCHAR(20) NOT NULL
                    ) ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");

                if($this->_table == 'news')
                {
                    $this->_query = @$this->query($this->_Hnd, 'SELECT * FROM ' . $this->_table . ' ORDER BY data DESC, tytul ASC');
                }
                else if($this->_table == 'imieniny')
                {
                    $this->_query = @$this->query($this->_Hnd, 'SELECT MONTH(`data`) AS `miesiac`, DAY(`data`) AS `dzien`, imiona FROM ' . $this->_table);
                }
                else
                {
                    $this->_query = @$this->query($this->_Hnd, 'SELECT * FROM ' . $this->_table);
                }
            }
        }
        public function  __destruct()
        {
            $this->_Hnd->close();
        }
        
        public function getUserData($id)
        {
            if($id != NULL)
            {
                return $this->_query = @$this->query($this->_Hnd, 'SELECT login, password, role FROM users WHERE id = ' . $id);
            }
            else
            {
                return "You must create an object with id!";
            }
        }
        
        public function getUsersData()
        {
            $this->_query = @$this->query($this->_Hnd, 'SELECT * FROM _users');
        }
        
        public function getRealizationById($id = null)
        {
            if($id != null)
            {
                return $this->_query = @$this->query($this->_Hnd, 'SELECT tytul, tekst, data, url, obrazek, used_technologies FROM ' . $this->_table . ' WHERE id = ' . $id);
            }
        }
    }

?>
