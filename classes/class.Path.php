<?php
    class Path
    {
        public static $_main_path = './';
        private $_styles_path = 'styles/';
        private $_includes_path = 'includes/';
        private $_layouts_path = 'layouts/';
        private $_js_scripts_path = 'js/';
        
        public function getStylesPath()
        {
            return $this -> _styles_path;
        }
        public function getIncludesPath()
        {
            return $this -> _includes_path;
        }
        public function getLayoutsPath()
        {
            return $this ->_layouts_path;
        }
        public function getJSScriptsPath()
        {
            return $this ->_js_scripts_path;
        }
        
        public function  __construct()
        {

        }
        public function  __destruct()
        {

        }
    }

?>
