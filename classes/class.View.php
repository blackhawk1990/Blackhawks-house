<?php

    //**Class for generating view elements**//
    
    class View 
    {
        public function addScript($script_content)
        {
            return "<script type=\"text/javascript\">" . $script_content . "</script>";
        }
        
        public function addScriptFile($script_path)
        {
            return "<script type=\"text/javascript\" src=\"" . $script_path . "\"></script>";
        }
        
        public function addStylesheetFile($stylesheet_path)
        {
            return "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $stylesheet_path . "\" />";
        }
        
    }
    
?>
