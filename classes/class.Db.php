<?php
    class Db
    {
//        public static $_host = "localhost";
//        public static $_db = "blackhawk";
//        public static $_login = "root";
//        public static $_pass = "";
//        public static $_host = "mysql.cba.pl";
//        public static $_db = "musec_tk";
//        public static $_login = "blhouse";
//        public static $_pass = "skomp3l";
        
        protected $_Hnd = NULL;
        public $_query;
        private $_table;
        
        protected function query($_Hnd, $query)
        {
            return $_Hnd->query($query);
        }
        protected function multiquery($_Hnd, $query)
        {
            return $_Hnd->multi_query($query);
        }
        public function  __construct($table = "_realizations", $bNoQueries = FALSE)
        {
            $this->_table = $table;
            
            $this -> _Hnd = @new mysqli(DB_HOST, DB_LOGIN, DB_PASS, DB_NAME);

            if(mysqli_connect_error () != NULL)
            {
                echo mysqli_connect_errno();
            }
            else
            {
                if(!$bNoQueries)
                {
                    @$this -> query ($this -> _Hnd, 'SET NAMES utf8');
                    @$this -> query ($this -> _Hnd, "
                        CREATE TABLE IF NOT EXISTS _realizations(`id` INT( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                        `title` VARCHAR( 22 ) NOT NULL ,
                        `text` TEXT NOT NULL ,
                        `date` VARCHAR( 20 ) NOT NULL ,
                        `introduction` VARCHAR( 60 ) NOT NULL ,
                        `image` VARCHAR ( 60 ) NOT NULL ,
                        `url` VARCHAR ( 60 ),
                        `used_technologies` VARCHAR ( 60 ) NOT NULL
                        ) ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
                    @$this -> query ($this -> _Hnd, "
                        CREATE TABLE IF NOT EXISTS _slider_slides(`id` INT PRIMARY KEY AUTO_INCREMENT,
                        `title` VARCHAR(30) NOT NULL, 
                        `content` TEXT NOT NULL,
                        `image` VARCHAR(40) NOT NULL
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
                    @$this -> query ($this -> _Hnd, "
                        CREATE TABLE IF NOT EXISTS _main_menu(`id` INT PRIMARY KEY AUTO_INCREMENT,
                        `label` VARCHAR(50) NOT NULL, 
                        `name` VARCHAR(30) NOT NULL,
                        `count` INT(11) DEFAULT 0 NOT NULL
                        ) ENGINE = INNODB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");

                    if($this->_table == 'news')
                    {
                        $this->_query = @$this->query($this->_Hnd, 'SELECT * FROM ' . $this->_table . ' ORDER BY data DESC, tytul ASC');
                    }
                    else
                    {
                        $this->_query = @$this->query($this->_Hnd, 'SELECT * FROM ' . $this->_table);
                    }
                }
            }
        }
        public function  __destruct()
        {
            //db disconnect
            $this -> _Hnd -> close();
            //handler destroy
            $this -> _Hnd = null;
        }
        
        public function saveRow($aData)
        {
            $aColumnNames = array();
            $aDataToInsert = array();
            $i = 0;
            
            foreach($aData as $sColumnName => $sColumnValue)
            {
                $aColumnNames[$i] = $sColumnName;
                $aDataToInsert[$sColumnName] = $sColumnValue;
                $i++;
            }
            
            $sQuery = "INSERT INTO `" . $this->_table . '` (';
            $sValuesQueryPart = " VALUES(";
            $iColumnNumber = count($aColumnNames);
            $i = 1;
            
            foreach($aColumnNames as $sColumnName)
            {
                $sQuery .= "`" . $sColumnName . "`";
                if(!($iColumnNumber == $i))
                {
                    $sQuery .= ", ";
                }
                
                $sValuesQueryPart .= "'" . $aDataToInsert[$sColumnName] . "'";
                if(!($iColumnNumber == $i))
                {
                    $sValuesQueryPart .= ", ";
                }
                
                $i++;
            }
            
            $sQuery .= ")" . $sValuesQueryPart . ");";
            
            return $this->query($this->_Hnd, $sQuery);
        }
        
        public function deleteRow($iId)
        {
            $sQuery = "DELETE FROM `" . $this->_table . "`
                WHERE `id` = " . $iId;
            
            return $this->query($this->_Hnd, $sQuery);
        }
    }

?>