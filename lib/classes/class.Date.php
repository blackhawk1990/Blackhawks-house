<?php

class Date 
{
    private $data;
    private $now;
    private $lng;
    private $other;
    private $weekdays_pl = array('Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota');
    private $months_pl = array(
                    'stycznia',
                    'lutego',
                    'marca',
                    'kwietnia',
                    'maja',
                    'czerwca',
                    'lipca',
                    'sierpnia',
                    'września',
                    'października',
                    'listopada',
                    'grudnia'
    );
    
    public function __construct($lang = '', $str = '') //$lang - jezyk np. 'pl' dla polskiego, $str - data wejsciowa do przeksztalcenia
    {
        $this->lng = $lang;
        $this->now = getdate();
        if($str == '') //jesli data wejsciowa pusta to przeksztalcamy dzisiejsza
        {
            if(strlen($this->now['mon']) > 1 && strlen($this->now['mday']) > 1)
            {
                $this->data = $this->now['year'].'-'.$this->now['mon'].'-'.$this->now['mday'];
            }
            else if(strlen($this->now['mon']) > 1)
            {
                $this->data = $this->now['year'].'-'.$this->now['mon'].'-0'.$this->now['mday'];
            }
            else if(strlen($this->now['mday']) > 1)
            {
                $this->data = $this->now['year'].'-0'.$this->now['mon'].'-'.$this->now['mday'];
            }
            else
            {
                $this->data = $this->now['year'].'-0'.$this->now['mon'].'-0'.$this->now['mday'];
            }
        }
        else //jezeli nie przekszatalca date wejsciowa z $str, format: yyyy-mm-dd
        {
            $this->data = substr($str, 0, 10);
            if(strlen($str) > 10) //jezeli $str zawiera cos wiecej niz date, to dopisz to do danych wyjsciowych
            {
                if(strlen(substr($str, 11)) == 8)
                {
                    if(substr($str, 11, 1) == '0')
                    {
                        $this->other = substr($str, 12, 4);
                    }
                    else if(substr($str, 11, 1) != '0')
                    {
                        $this->other = substr($str, 11, 5);
                    }
                }
                else
                {
                    $this->other = substr($str, 11, 4);
                }
            }
            else
            {
                $this->other = '';
            }
                
        }
    }


    public function getDate($only_date = true) //data w danym jezyku,zwraca pelna date
    {
        switch($this->lng)
        {
            case 'pl': //dla polskiego
            {
                //zwracamy date i reszte
                if(!$only_date)
                {
                    //jezeli data nie zaczyna sie od zera
                    if(substr($this->data, 8, 1) != '0')
                    {
                        return substr($this->data, 8, 2).' '.$this->months_pl[(substr($this->data, 5, 2) >= 10 ? substr($this->data, 5, 2) : substr($this->data, 6, 1)) - 1].' '.substr($this->data, 0, 4).' roku '.$this->other;
                    } //jesli zaczyna sie od zera
                    else
                    {
                        return substr($this->data, 9, 1).' '.$this->months_pl[(substr($this->data, 5, 2) >= 10 ? substr($this->data, 5, 2) : substr($this->data, 6, 1)) - 1].' '.substr($this->data, 0, 4).' roku '.$this->other;
                    }
                }
                else //zwracamy sama date
                {
                    //jezeli data nie zaczyna sie od zera
                    if(substr($this->data, 8, 1) != '0')
                    {
                        return substr($this->data, 8, 2).' '.$this->months_pl[(substr($this->data, 5, 2) >= 10 ? substr($this->data, 5, 2) : substr($this->data, 6, 1)) - 1].' '.substr($this->data, 0, 4).' roku';
                    } //jesli zaczyna sie od zera
                    else
                    {
                        return substr($this->data, 9, 1).' '.$this->months_pl[(substr($this->data, 5, 2) >= 10 ? substr($this->data, 5, 2) : substr($this->data, 6, 1)) - 1].' '.substr($this->data, 0, 4).' roku';
                    }
                }
            }
            default: //domyslnie po angielsku
            {
                //zwracamy date i reszte
                if(!$only_date)
                {
                    return $this->now['mday'].' '.$this->now['month'].' '.$this->now['year'].' '.$this->other;
                }
                else //zwracamy sama date
                {
                    return $this->now['mday'].' '.$this->now['month'].' '.$this->now['year'];
                }
            }
        }
    }
    
    public function getWeekday() //nazwa danego dnia tygodnia w okreslonym jezyku
    {
        switch($this->lng)
        {
            case 'pl': //dla polskiego
            {
                return $this->weekdays_pl[$this->now['wday']];
            }
            default: //domyslnie po angielsku
            {
                return $this->now['weekday'];
            }
        }
    }
    
    public function getMonth() //numer miesiaca
    {
        return $this->now['mon'];
    }
    
    public function getDay() //numer dnia
    {
        return $this->now['mday'];
    }

}

?>
