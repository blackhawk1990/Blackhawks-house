<?php
class Template
{
    public $assign;
    private $parsed;

    public function parse($file_name)
    {

        //sprawdzenie czy plik istnieje
        if(!file_exists($file_name))
        {
            echo "File not exists!";
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
