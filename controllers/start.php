<?php
/*
 * start.php - start page controller
 *
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of
 * the License, or (at your option) any later version.
 *
 * @author   Annelene Sudau <sudau@elan-ev.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.html GPL version 2
 * @category Stud.IP
 * @since    3.1
 */
require_once 'app/controllers/news.php';


class StartController extends StudipController
{
    /**
     * Callback function being called before an action is executed.
     */
    function before_filter(&$action, &$args)
    {
        parent::before_filter($action, $args);

        if (Request::isXhr()) {
            $this->set_layout(null);
            $this->set_content_type('text/html;Charset=windows-1252');
        }

        Navigation::activateItem('/start');
        PageLayout::setTabNavigation(NULL); // disable display of tabs
        PageLayout::setHelpKeyword("Basis.Startseite"); // set keyword for new help
        PageLayout::setTitle(_('Startseite'));
    }

    /**
     * Entry point of the controller that displays the start page of Stud.IP
     *
     * @param string $action
     * @param string $widgetId
     *
     * @return void
     */
    function index_action($action = false, $widgetId = null)
    {
        $sem_id_mitarbeiterinnen = Config::get()->getValue('INTRANET_SEMID_MITARBEITERINNEN');
        //$sem_id_mitarbeiterinnen = '9fc5dd6a84acf0ad76d2de71b473b341';
        
        $sem_id_projektbereich = Config::get()->getValue('INTRANET_SEMID_PROJEKTBEREICH');
        //$sem_id_projektbereich = '340cce15b3be8fb86247a7514599126a';
        
        global $perm; 
        $this->mitarbeiter_admin = $perm->have_studip_perm('dozent', $sem_id_mitarbeiterinnen);
        $this->projekt_admin = $perm->have_studip_perm('dozent', $sem_id_projektbereich);
        
        $this->edit_link_internnews = URLHelper::getLink("dispatch.php/news/edit_news/new/". $sem_id_mitarbeiterinnen);
        $this->edit_link_projectnews = URLHelper::getLink("dispatch.php/news/edit_news/new/" . $sem_id_projektbereich);
        $this->edit_link_files = URLHelper::getLink("folder.php?cid=" . $sem_id_projektbereich . "&cmd=tree");
        
        //get intern news
        $dispatcher = new StudipDispatcher();
        $controller = new NewsController($dispatcher);
        $response = $controller->relay('news/display/' . $sem_id_mitarbeiterinnen);
        //$response = $controller->relay('news/display/9fc5dd6a84acf0ad76d2de71b473b341'); //localhost
        $this->internnewstemplate = $GLOBALS['template_factory']->open('shared/string');
        $this->internnewstemplate->content = $response->body;
        

        if (StudipNews::CountUnread() > 0) {
            $navigation = new Navigation('', PluginEngine::getLink($this, array(), 'read_all'));
            $navigation->setImage(Icon::create('refresh', 'clickable', ["title" => _('Alle als gelesen markieren')]));
            $icons[] = $navigation;
        }

        $this->internnewstemplate->icons = $icons;
        
        $this->birthday_dates = IntranetDate::findBySQL("type = 'birthday' AND begin = ?", array(date('d.m.Y', time())));
        
        
        //get new and recently visited courses of user
        $statement = DBManager::get()->prepare("SELECT s.Seminar_id, s.Name, ouv.visitdate, ouv.type "
                . "FROM seminare as s "
                . "LEFT JOIN object_user_visits as ouv ON (s.Seminar_id = ouv.object_id) "
                . "WHERE ouv.user_id = :user_id "
                . "AND s.Seminar_id NOT IN (:int_ma, :int_pb) "
                . "AND ouv.type = 'sem' "
                . "AND s.Seminar_id in "
                . "(SELECT su.Seminar_id FROM seminar_user as su WHERE su.user_id = :user_id) ORDER BY ouv.visitdate DESC");

        $statement->execute([':user_id' => $GLOBALS['user']->id, ':int_ma' => $sem_id_mitarbeiterinnen, ':int_pb' => $sem_id_projektbereich,]);
        $this->courses = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        
        
        //Get File-Folders of Intern Seminar MitarbeiterInnen
        $db = DBManager::get();
        $stmt = $db->prepare("SELECT folder_id, name FROM folder WHERE seminar_id = :cid");
        $stmt->bindParam(":cid", $sem_id_mitarbeiterinnen);
        $stmt->execute();
        $this->mitarbeiter_folder = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $this->mitarbeiter_folderwithfiles = array();
        
        foreach ($this->mitarbeiter_folder as $folder){
            
            $db = \DBManager::get();
            $stmt = $db->prepare("SELECT * FROM `dokumente` WHERE `range_id` = :range_id
                ORDER BY `name`");
            $stmt->bindParam(":range_id", $folder['folder_id']);
            $stmt->execute();
            $response = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            $files = array();
            
            foreach ($response as $item) {
                $files[] = $item;
            }
            $this->mitarbeiter_folderwithfiles[$folder['name']] = $files;
            
        }
        
        
         //get project news
        $dispatcher = new StudipDispatcher();
        $controller = new NewsController($dispatcher);
        $response = $controller->relay('news/display/' . $sem_id_projektbereich);
        //$response = $controller->relay('news/display/9fc5dd6a84acf0ad76d2de71b473b341'); //localhost
        $this->projectnewstemplate = $GLOBALS['template_factory']->open('shared/string');
        $this->projectnewstemplate->content = $response->body;
        

        if (StudipNews::CountUnread() > 0) {
            $navigation = new Navigation('', PluginEngine::getLink($this, array(), 'read_all'));
            $navigation->setImage(Icon::create('refresh', 'clickable', ["title" => _('Alle als gelesen markieren')]));
            $icons[] = $navigation;
        }

        $this->projectnewstemplate->icons = $icons;
        
        

         //get upcoming courses
        $result = EventData::findBySQL("category_intern = '13' AND start > '" . time() . "' ORDER BY start ASC");
       
        
        $this->courses_upcoming = $result;
        
        /**
        $ch = curl_init();
        $url = 'https://www.kvhs-ammerland.de/index.php?id=144&kathaupt=6&suchesetzen=true';
        
        // set post fields
        $post = [
            'kfs_stichwort' => '%%%',
            'kfs_aussenst_select' => '-1',
            'kfs_kursbereich' => '-1',
            'kfs_sonderrubrik' => '-1',
            'kfs_beginn_dat1' => '05.02.2018',
            'kfs_beginn_dat2' => '12.02.2018',
            'kfs_wo_all' => 'true',
            'kfs_zr' => 'true',
        ];
        
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $data = curl_exec($ch);
        curl_close($ch);
        
        $doc = new \DOMDocument();

        libxml_use_internal_errors(true);

        if (!$doc->loadHTML($data))
            {
                $errors="";
                foreach (libxml_get_errors() as $error)  {
                    $errors.=$error->message."<br/>";
                }
                libxml_clear_errors();
                print "libxml errors:<br>$errors";

        } else {

        $xpath = new \DOMXpath($doc);
        $output = $xpath->query('//div[contains(@class, "doz_kurs")]');
        //$doc->getElementsByClassName('doz_kursliste')->textContent;
        
        $this->courses_upcoming = $output;
        }
        **/
           
    }
    
    
      function insertCoursebegin_action($id = ''){
        
          //speichern
        if ($_POST['submit']){
            $this->event = new EventData($id);
            $this->event->author_id = $GLOBALS['user']->id;
            $this->event->start = strtotime($_POST['start_date']);
            $this->event->end = $this->event->start;
            $this->event->summary = studip_utf8decode($_POST['summary']);
            $this->event->description = $_POST['description'];
            $this->event->class = 'PUBLIC';
            $this->event->category_intern = '13';

            $this->event->store();
            
             if (Request::isXhr()) {
                    header('X-Dialog-Close: 1');
                    exit;
             } else $this->redirect($this->url_for('/start'));
        
        //bearbeiten
        } else if ($id){
            
            $this->event = new EventData($id);
        
        // neu anlegen
        } else {
            $this->event = new EventData();
            $this->event->event_id = $this->event->getNewId();
            $this->event->start = time();
            $this->event->summary = 'Kurstitel';
            $this->event->description = 'http://';
        }
        //$this->setProperties($calendar_event, $component);
        //$calendar_event->setRecurrence($component['RRULE']);
    }
}
