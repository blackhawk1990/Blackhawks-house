<?php

    //wylaczenie ostrzezen w php
    //error_reporting(E_ALL ^ E_WARNING);
    
    include 'config/default.php';

    /*****************auto loading all classes in classes catalog*********************/
    $oClassesDir = dir(CLASSES_PATH);
    while(($sFile = $oClassesDir->read()) != NULL)
    {
        if($sFile != '.' && $sFile != '..')
        {
            require_once CLASSES_PATH . $sFile;
        }
    }
    
    /*****************auto loading all models in models catalog*********************/
    $oModelsDir = dir(MODELS_PATH);
    while(($sFile = $oModelsDir->read()) != NULL)
    {
        if($sFile != '.' && $sFile != '..')
        {
            require_once MODELS_PATH . $sFile;
        }
    }
    
    $path = new Path();

    $page = new Template();

    //ustawianie opcji
    $page->assign['charset'] = "UTF-8";
    $page->assign['main-page'] = Path::$_main_path;
    $page->assign['scripts'] = '';
    $page->assign['common-head-content'] = '';
    
    $page->assign['title'] = "Blackhawk's House";
    
    $page->assign['copyrights'] = "&copy; Łukasz Traczewski 2011 - 2013, icon by <a href = \"http://linkgilbs.deviantart.com/\" target = \"_blank\">Jake Gilbert</a><a href = \"http://validator.w3.org/check?uri=http%3A%2F%2Fblackhawkshouse.pl%2F\" target = \"_blank\"><img src = \"styles/img/HTML5_logo.png\" alt = \"Logo HTML 5\" /></a><br />Ostatnia aktualizacja: 27-11-2013";
    
    $view_class = new View();
    
    //****************************************<STYLES>****************************************//
    
    $page->assign['common-head-content'] .= "\n\t" . $view_class->addStylesheetFile($path->getStylesPath() . 'default.css');
    $page->assign['common-head-content'] .= "\n\t" . $view_class->addStylesheetFile($path->getStylesPath() . 'jquery-ui-1.10.3.custom.css');
    
    //****************************************</STYLES>****************************************//
    
    
    //****************************************<SCRIPTS>***************************************//
    
    $page->assign['common-head-content'] .= "\n\t" . $view_class->addScriptFile($path->getJSScriptsPath() . 'ui/jquery-1.8.2.min.js');
    $page->assign['common-head-content'] .= "\n\n\t" . $view_class->addScriptFile($path->getJSScriptsPath() . 'main.js');
    $page->assign['common-head-content'] .= "\n\t" . $view_class->addScriptFile($path->getJSScriptsPath() . 'ui/jquery-ui-1.10.3.custom.min.js');
    $page->assign['common-head-content'] .= "\n\t" . $view_class->addScriptFile($path->getJSScriptsPath() . 'ui/jquery.ui.datepicker-pl.js');
    
    //****************************************</SCRIPTS>***************************************//
    
    
    //gorne menu + warunki na zaznaczanie, gdy ktoras podstrona jest otwarta
    $page->assign['up-menu'] = ((!isset($_GET['view'])) ? '<li class="select">' : '<li>') . 
                                    '<a href="' . $page->assign['main-page'] . '">home</a>
                               </li>' .
                               $page->getMenu();
    
    //social media
    $page->assign['social-media'] = '<li id="facebook">
					<a href="http://www.facebook.com/blackhawkprogrammer" target="_blank">facebook</a>
				</li>
				<li id="googleplus">
					<a href="https://plus.google.com/u/0/100246819469400258433" target="_blank">googleplus</a>
				</li>
                                <li id="linkedin">
					<a href="http://www.linkedin.com/profile/view?id=181259758" target="_blank">linkedin</a>
				</li>';
//				<li id="rss">
//					<a href="#" >rss</a>
//				</li>';
    
    /**********************************<SESSION>******************************************************/
    //dlugosc zycia sesji w minutach
    $iSessionLifetime = 30;
    //start sesji uzytkownika
    session_start();
    
    ini_set('session.gc-maxlifetime', $iSessionLifetime * 60);
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $iSessionLifetime * 60)) {
        session_unset();     // zniszczenie zmiennej $_SESSION
        session_destroy();   // zniszczenie danych sesji
    }
    $_SESSION['LAST_ACTIVITY'] = time(); // uaktualnienie czasu ostatniego odswiezenia strony
    /**********************************</SESSION>*****************************************************/
    
    /**akcje**/
    if(isset($_GET['action']))
    {
        /**
         * KODY BLEDOW
         * 0 - nieprawidlowy login i/lub haslo
         * 1 - dane prawidlowe
         */
        if ($_GET['action'] == 'login')
        {
            $log = new Log($_POST['login'], $_POST['password']);
            
            if($log->login())
            {
                echo 1;
                exit();
            }
            else
            {
                echo 0;
                exit();
            }
        }
        else if ($_GET['action'] == 'logout')
        {
            //wykasowanie wsz informacji o sesji
            session_unset();
        }
        else if ($_GET['action'] == 'add_realization')
        {
            if(!empty($_POST))
            {
                $oDb = new Db();
                echo $oDb->saveRow($_POST);
                exit();
            }
        }
    }
    /**akcje**/
    
    /**widoki**/
    if(!isset($_GET['view']) || $_GET['view'] == '') //dla strony glownej
    {
        //nowy szablon
        $view = new Template();
        
        //init
        $view->assign['main-section'] = '';
        $view->assign['left-col-content'] = '';
        $view->assign['right-col-content'] = '';
        
        $page->assign['common-head-content'] .= "\n\t<script type=\"text/javascript\" src=\"" . $path->getJSScriptsPath() . "ui/jquery.carouFredSel-6.2.0-packed.js\"></script>";
        $page->assign['common-head-content'] .= "\n\t<script type=\"text/javascript\" src=\"" . $path->getJSScriptsPath() . "carousel.js\"></script>";
        $page->assign['common-head-content'] .= "\n\t<script type=\"text/javascript\" src=\"" . $path->getJSScriptsPath() . "facebook.js\"></script>";
        
        $view->assign['right-col-content'] = '<h3>Najnowsze realizacje</h3>
                                                <ul>';
        
        //SLIDER
        $oSlider = new Slider('_slider_slides');
        $view->assign['main-section'] = $oSlider->getSlider();
        
        //uzytkownik nie zalogowany
        if(!isset($_SESSION['login']))
        {
            //wczytywanie informacji z bazy danych
            $oDb = new Db();
            $oDb->getRealizations();

            $i = 0;

            while(($news = $oDb->_query->fetch_assoc()) != NULL)
            {
                if($i < NUM_OF_REALIZATIONS_VIEWED)
                {
                    $view->assign['right-col-content'] .= "<li>
                                                            <h3>" . $news['title'] . "</h3>
                                                            <div>
                                                                <p>
                                                                    " . $news['introduction'] . "
                                                                </p>
                                                                <a href=\"?view=realization&id=" . $news['id']  . "\" class=\"more\">więcej</a>
                                                            </div>
                                                            <img src=\"" . $path->getRealizationImagesPath() . $news['image'] . "\" alt=\"\">
                                                          </li>";
                }
                $i++;
            }
            
            $view->assign['right-col-content'] .= '</ul>';
            
            //komunikat w przypadku braku realizacji
            if($i == 0)
            {
                $view->assign['right-col-content'] = '<h3>Najnowsze realizacje</h3>
                                                      <h4 style="text-align: center; margin-top: 100px;">Brak wykonanych realizacji</h4>';
            }
        }
        else
        {  
            //widok dla admina
            if($_SESSION['role'] == 'admin')
            {   
                //wczytywanie informacji z bazy danych
                $oDb = new Db();
                $oDb->getRealizations();

                $i = 0;
                $length = 0;

                while(($news = $oDb->_query->fetch_assoc()) != NULL)
                {
                    $length++;
                }

                $oDb = new Db();
                $oDb->getRealizations();

                //przeksztalcenie daty
                while(($news = $oDb->_query->fetch_assoc()) != NULL)
                {
                    if($i < NUM_OF_REALIZATIONS_VIEWED)
                    {
                        $date = new Date('pl', $news['date']);

                        $view->assign['right-col-content'] .= "<li>
                                                            <h3>" . $news['title'] . "</h3>
                                                            <div>
                                                                <p>
                                                                    " . $news['introduction'] . "
                                                                </p>
                                                                <a href=\"?view=realization&id=" . $news['id']  . "\" class=\"more\">więcej</a>
                                                            </div>
                                                            <img src=\"" . $path->getRealizationImagesPath() . $news['image'] . "\" alt=\"\">
                                                          </li>";
                    }
                    $i++;
                }
            }
            else //widok dla innych uzytkownikow
            {
                //wczytywanie informacji z bazy danych
                $oDb = new Db();
                $oDb->getRealizations();

                $i = 0;
                $length = 0;

                while(($news = $oDb->_query->fetch_assoc()) != NULL)
                {
                    $length++;
                }

                $oDb = new Db();
                $oDb->getRealizations();

                //przeksztalcenie daty
                while(($news = $oDb->_query->fetch_assoc()) != NULL)
                {
                    if($i < NUM_OF_REALIZATIONS_VIEWED)
                    {
                        $date = new Date('pl', $news['data']);

                        $view->assign['right-col-content'] .= "<li>
                                                            <h3>" . $news['title'] . "</h3>
                                                            <div>
                                                                <p>
                                                                    " . $news['introduction'] . "
                                                                </p>
                                                                <a href=\"?view=realization&id=" . $news['id']  . "\" class=\"more\">więcej</a>
                                                            </div>
                                                            <img src=\"" . $path->getRealizationImagesPath() . $news['image'] . "\" alt=\"\">
                                                          </li>";
                    }
                    $i++;
                }
            }
        }
        
        //przekazanie zawartosci widoku do layoutu
        $page->assign['view-content'] = $view->parse('templates/main.html');
    }
    else if($_GET['view'] == 'contact')
    {
        //tytul strony
        $page->assign['title'] = "Kontakt";
        
        //skrypty
        $page->assign['common-head-content'] .= "\n\n\t<script type=\"text/javascript\" src=\"js/jquery-1.8.2.min.js\"></script>";
        
        $view = new Template();
        $view->assign['contact-form-action'] = "index.php?action=contact";
        
        $page->assign['view-content'] = $view->parse('templates/contact.html');
    }
    else if($_GET['view'] == 'services')
    {
        //tytul strony
        $page->assign['title'] = "Oferta";
        
        $view = new Template();
        
        $page->assign['view-content'] = $view->parse('templates/services.html');
    }
    else if($_GET['view'] == 'realization')
    {
        $view = new Template();
        
        //inicjalizacja
        $view->assign['realization-title'] = "";
        $view->assign['realization-text'] = "";
        $view->assign['realization-tech'] = "";
        $view->assign['realization-date'] = "";
        $view->assign['realization-image'] = "";
        $view->assign['realization-url'] = "";
        $view->assign['additional-content'] = "";
        
        $new_realizations_view = new Template();
        //inicjalizacja
        $new_realizations_view->assign['new-realizations-content'] = "";
        
        //wczytywanie informacji z bazy danych
        $oDb = new Db();
        $oDb->getRealizations();

        $i = 0;
        $length = 0;

        while (($news = $oDb->_query->fetch_assoc()) != NULL) {
            $length++;
        }
        
        $oDb = new Db();
        $oDb->getRealizations();

        while (($new_realization = $oDb->_query->fetch_assoc()) != NULL) {
            if ($i < 4) {
                $new_realizations_view->assign['new-realizations-content'] .= "<li>
                                                                <h3>" . $new_realization['title'] . "</h3>
                                                                <div>
                                                                    <p>
                                                                        " . $new_realization['introduction'] . "
                                                                    </p>
                                                                    <a href=\"?view=realization&id=" . $new_realization['id'] . "\" class=\"more\">więcej</a>
                                                                </div>
                                                                <img src=\"" . $path->getRealizationImagesPath() . $new_realization['image'] . "\" alt=\"\">
                                                              </li>";
            }
            $i++;
        }
        
        if(isset($_GET['id']) && $_GET['id'] != "")
        {
            $oDb = new Db();
            //wczytywanie danych realizacji
            $realization_data = $oDb->getRealizationById($_GET['id']);
            $aRealization = $realization_data->fetch_assoc();
            
            //jesli sa jakies realizacje
            if($aRealization != null)
            {
                $oDate = new Date('pl', $aRealization['date']);

                $view->assign['realization-title'] = $aRealization['title'];
                $view->assign['realization-text'] = $aRealization['text'];
                $view->assign['realization-tech'] = $aRealization['used_technologies'];
                $view->assign['realization-date'] = $oDate->getDate();
                $view->assign['realization-image'] = $aRealization['image'];
                $view->assign['realization-url'] = $aRealization['url'] != '' ? '<a href="' . $aRealization['url'] . '" target="_blank">' . $aRealization['url'] . '</a>' : 'brak';
                
                //dodatkowa tresc ponizej opisu realizacji(nowe realizacje)
                $view->assign['additional-content'] =  $new_realizations_view->parse('templates/new_realizations.html');
                
                //przekazanie zawartosci widoku do layoutu
                $page->assign['view-content'] = $view->parse('templates/realization.html');
            }
            else
            {
                //przekazanie komunikatu do layoutu
                $page->assign['view-content'] = '<div id="body" style="text-align: center;"><h1>Brak wykonanych realizacji</h1></div>';
            }
        }
        else
        {
            //przekazanie zawartosci widoku samych nowych realizacji do layoutu
            $page->assign['view-content'] = '<div id="body" style="text-align: center;color: red;"><h1>Błędne parametry akcji</h1></div>';
        }
    }
    else if($_GET['view'] == 'portfolio')
    {
        //tytul strony
        $page->assign['title'] = "Portfolio";
        
        $view = new Template();
        
        //inicjalizacja
        $view->assign['realizations'] = "";
        
        //wczytywanie informacji z bazy danych
        $oDb = new Db();
        $oDb->getRealizations();
        
        $i = 0;
        while(($aRealizations = $oDb->_query->fetch_assoc()) != NULL)
        {
            $date = new Date('pl', $aRealizations['date']);

            $view->assign['realizations'] .= "<div class=\"realization\">
                                                <div class=\"realization-content\">
                                                    <h1>" . $aRealizations['title'] . "</h1>

                                                    <p>
                                                        " . $aRealizations['text'] . "
                                                    </p>

                                                    <p>
                                                        Użyte technologie: " . $aRealizations['used_technologies'] . "
                                                    </p>

                                                    <h3>Link: " . ($aRealizations['url'] != '' ? "<a href=\"" . $aRealizations['url'] . "\" target=\"_blank\">" . $aRealizations['url'] . "</a>" : "brak") . "</h3>

                                                    <h4>Data wykonania: " . $date->getDate() . "</h4>
                                                </div>
                                                <img src=\"" . $path->getRealizationImagesPath() . $aRealizations['image'] . "\" alt=\"\" />
                                            </div>";
            
            $i++;
        }
        
        //jesli brak realizacji, to komunikat
        if($i == 0)
        {
            $page->assign['view-content'] = '<div id="body" style="text-align: center;"><h1>Brak wykonanych realizacji</h1></div>';
        }
        else 
        {
            //przekazanie zawartosci widoku do layoutu
            $page->assign['view-content'] = $view->parse('templates/portfolio.html');
        }
        
    }
    else if($_GET['view'] == 'about')
    {
        //tytul strony
        $page->assign['title'] = "O mnie";
        
        $view = new Template();
        
        //przekazanie zawartosci widoku do layoutu
        $page->assign['view-content'] = $view->parse('templates/about.html');
    }
    else if($_GET['view'] == 'works')
    {
        //tytul strony
        $page->assign['title'] = "Moje prace";
        
        $view = new Template();
        
        //przekazanie zawartosci widoku do layoutu
        $page->assign['view-content'] = $view->parse('templates/works.html');
    }
    else if($_GET['view'] == 'admin')
    {
        //tytul strony
        $page->assign['title'] = "Strefa administracyjna";
        $page->assign['common-head-content'] .= "\n\t" . $view_class->addScriptFile($path->getJSScriptsPath() . "logscript.js");
        
        $view = new Template();
        $view_class = new View();
        
        //przekazanie zawartosci widoku do layoutu
        if(!isset($_SESSION['login'])) //dla niezalogowanego
        {
            $log_form = new Template();

            $view->assign['log-form'] = $log_form->parse($path->getIncludesPath() . "log_form.html");

            $page->assign['view-content'] = $view->parse('templates/login.html');
        }
        else //dla zalogowanego
        {
            $page->assign['common-head-content'] .= "\n\t" . $view_class->addStylesheetFile($path->getStylesPath() . "bootstrap-tagmanager.css");
            
            $page->assign['common-head-content'] .= "\n\t" . $view_class->addScriptFile($path->getJSScriptsPath() . "ckeditor.js");
            $page->assign['common-head-content'] .= "\n\t" . $view_class->addScriptFile($path->getJSScriptsPath() . "ui/bootstrap-tagmanager.js");
            $page->assign['common-head-content'] .= "\n\t" . $view_class->addScriptFile($path->getJSScriptsPath() . "ui/uploadify/swfobject.js");
            $page->assign['common-head-content'] .= "\n\t" . $view_class->addScriptFile($path->getJSScriptsPath() . "ui/uploadify/jquery.uploadify.v2.1.4.min.js");
            $page->assign['common-head-content'] .= "\n\t" . $view_class->addScriptFile($path->getJSScriptsPath() . "admin_panel.js");
            
            $oAddRealizationFormView = new Template();
            $oAddRealizationFormView->assign['upload_path'] = $path->getRealizationImagesPath();
            
            $view->assign['login'] = $_SESSION['login'];
            $view->assign['add_realization_form'] = $oAddRealizationFormView->parse($path->getIncludesPath() . 'add_realization_form.html');
            
            $page->assign['view-content'] = $view->parse('templates/admin.html');
        }
    }
    /**widoki**/
    
    //parsowanie layoutu
    echo $page->parse('layouts/default.html');

?>
