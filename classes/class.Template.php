<?php

class Template
{
    public $assign;
    private $parsed;
    
    /**
     * Generates menu from database
     * 
     * @return string Generated menu <b>HTML</b>
     */
    public function getMenu()
    {
        $oMenu = new Menu();
        $menuData = $oMenu->getMainMenuItems();
        
        $sReturnHTML = '';
        
        if($menuData != NULL)
        {
            while(($menuItem = $menuData->fetch_assoc()) != NULL)
            {
                if($menuItem['count'] != 0)
                {
                    $sReturnHTML .= ((isset($_GET['view']) && $_GET['view'] == $menuItem['name']) ? '<li class="select">' : '<li>') .
                                        '<a href="?view=' . $menuItem['name'] . '">' . strtoupper($menuItem['label']) . '</a>
                                    </li>';
                }
            }
        }
        
        return $sReturnHTML;
    }
    
    /**
     * Parses view template to HTML site ready to view in browser<br />
     * 
     * Errors:
     * <ul>
     *  <li><b>0</b> - file not exists</li>
     * </ul>
     * 
     * @param string $file_name Template file name in templates folder which is parsed to view
     * @return string Parsed from template HTML site
     */
    public function parse($file_name)
    {

        //sprawdzenie czy plik istnieje
        if(!file_exists($file_name))
        {
            return 0;
        }
        
        //wczytanie pliku do stringu
        $this->parsed = file_get_contents($file_name, 500000);

        if(isset($this->assign))
        {
            //zerowanie licznika
            $i = 0;
            //petla odczytujaca pseudoznaczniki i ich wartosci
            foreach($this->assign as $key => $value)
            {
                $source[$i] = "{\$".$key."}";
                $destination[$i] = $value;
                $i++;
            }
        }
        if(isset($source))
        {
            //podmiana znacznikow na ich wartosci
            $this->parsed = str_replace($source, $destination, $this->parsed);
            return $this->parsed;
        }
        else
        {
            return $this->parsed;
        }
    }
    
}
?>
