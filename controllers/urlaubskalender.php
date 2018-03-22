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
 * @author   André Klaßen <klassen@elan-ev.de>
 * @author   Nadine Werner <nadine.werner@uni-osnabrueck.de>
 * @license  http://www.gnu.org/licenses/gpl-2.0.html GPL version 2
 * @category Stud.IP
 * @since    3.1
 */
require_once 'app/controllers/news.php';
require_once 'lib/webservices/api/studip_user.php';

class UrlaubskalenderController extends StudipController
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
        PageLayout::setTitle(_('Urlaubskalender'));
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
        global $perm;
        $sem_id_mitarbeiterinnen = Config::get()->getValue('INTRANET_SEMID_MITARBEITERINNEN');
        //$sem_id_mitarbeiterinnen = '9fc5dd6a84acf0ad76d2de71b473b341';
        $this->mitarbeiter_admin = $perm->have_studip_perm('dozent', $sem_id_mitarbeiterinnen);

            $sidebar = Sidebar::get();
            $sidebar->setImage('sidebar/home-sidebar.png');
            $sidebar->setTitle(_("Meine Startseite"));

            
               $views = new ViewsWidget();
        $views->addLink(_('Kalenderansicht'),
                        $this->url_for('urlaubskalender'))
                    ->setActive(true);
        $views->addLink(_('Zeitstrahl-Ansicht'),
                        $this->url_for('urlaubskalender/timeline'));
        $sidebar->addWidget($views);
            
            // Show action to add widget only if not all widgets have already been added.
            $actions = new ActionsWidget();

            $actions->addLink(_('Neuen Urlaubstermin eintragen'),
                              $this->url_for('urlaubskalender/new'),
                              Icon::create('add', 'clickable'));
            
            $actions->addLink(_('Urlaubstermine bearbeiten'),
                              $this->url_for('urlaubskalender/'. (!$this->mitarbeiter_admin ? ('edituser/'.$GLOBALS['user']->id) : 'edit')),
                              Icon::create('edit', 'clickable'));
            $sidebar->addWidget($actions);
            
            
            $this->dates = MAHoliday::findBySQL('1=1');
            

            // Root may set initial positions
            if ($GLOBALS['perm']->have_perm('root')) {
              
            }

    }
    
    /**
     * Entry point of the controller that displays the start page of Stud.IP
     *
     * @param string $action
     * @param string $widgetId
     *
     * @return void
     */
    function timeline_action($action = false, $widgetId = null)
    {
        $sem_id_mitarbeiterinnen = Config::get()->getValue('INTRANET_SEMID_MITARBEITERINNEN');
        //$sem_id_mitarbeiterinnen = '9fc5dd6a84acf0ad76d2de71b473b341';
        
        //alle Einträge der Tabelle
        $this->dates = MAHoliday::findBySQL('1=1');
        
        //für die Darstellung in der Timeline braucht man Integer keys für die Labels
        $this->keys = array();
        $cnt = 0;
        foreach($this->dates as $date){
            if (!array_key_exists($date->getValue('user_id') ,$this->keys)){
                $this->keys[$date->getValue('user_id')] = $cnt;
                $cnt++;
            }
        }

        // Root may set initial positions
        if ($GLOBALS['perm']->have_perm('root')) {

        }

    }

    /**
     *  This action adds a holiday entry
     *
     * @return void
     */
    public function new_action($id = '')
    {
        PageLayout::setTitle(_('Neuen Urlaubstermin eintragen'));
        $this->id = Config::get()->getValue('INTRANET_SEMID_MITARBEITERINNEN');
        global $perm;
        $this->mitarbeiter_admin = $perm->have_studip_perm('tutor', $this->id);
        
         $sidebar = Sidebar::get();
            $sidebar->setImage('sidebar/home-sidebar.png');
            $sidebar->setTitle(_("Meine Startseite"));

            
            $views = new ViewsWidget();
        $views->addLink(_('Kalenderansicht'),
                        $this->url_for('urlaubskalender'));
        $views->addLink(_('Zeitstrahl-Ansicht'),
                        $this->url_for('urlaubskalender/timeline'));
        $sidebar->addWidget($views);
            
            // Show action to add widget only if not all widgets have already been added.
            $actions = new ActionsWidget();

            $actions->addLink(_('Neuen Urlaubstermin eintragen'),
                              $this->url_for('urlaubskalender/new'),
                              Icon::create('add', 'clickable'));
            
            $actions->addLink(_('Urlaubstermine bearbeiten'),
                              $this->url_for('urlaubskalender/'. (!$this->mitarbeiter_admin ? ('edituser/'.$GLOBALS['user']->id) : 'edit')),
                              Icon::create('edit', 'clickable'));

            $sidebar->addWidget($actions);
        
        
        $this->help = _('Sie können nach Name, Vorname oder eMail-Adresse suchen');

        $search_obj = new SQLSearch("SELECT auth_user_md5.user_id, CONCAT(auth_user_md5.nachname, ', ', auth_user_md5.vorname, ' (' , auth_user_md5.email, ')' ) as fullname, username, perms "
                            . "FROM auth_user_md5 "
                            . "LEFT JOIN user_info ON (auth_user_md5.user_id = user_info.user_id) "
                            . "LEFT JOIN seminar_user ON (auth_user_md5.user_id = seminar_user.user_id) "
                            . "WHERE "
                            . "seminar_user.Seminar_id LIKE '". $this->id . "' "
                            . "AND (username LIKE :input OR Vorname LIKE :input "
                            . "OR CONCAT(Vorname,' ',Nachname) LIKE :input "
                            . "OR CONCAT(Nachname,' ',Vorname) LIKE :input "
                            . "OR Nachname LIKE :input OR {$GLOBALS['_fullname_sql']['full_rev']} LIKE :input) "
                            . " ORDER BY fullname ASC",
                _('Nutzer suchen'), 'user_id');
        $this->quick_search = QuickSearch::get('user_id', $search_obj)
                    ->fireJSFunctionOnSelect('select_user');
        
        
        $this->render_action('new');
        
    
    }
    
    /**
     *  This action adds a holiday entry
     *
     * @return void
     */
    public function edit_action($id = '')
    {
        PageLayout::setTitle(_('Neuen Urlaubstermin eintragen'));
        $this->id = Config::get()->getValue('INTRANET_SEMID_MITARBEITERINNEN');
         global $perm;
        $this->mitarbeiter_admin = $perm->have_studip_perm('dozent', $this->id);
        
         $sidebar = Sidebar::get();
            $sidebar->setImage('sidebar/home-sidebar.png');
            $sidebar->setTitle(_("Meine Startseite"));

            
            $views = new ViewsWidget();
        $views->addLink(_('Kalenderansicht'),
                        $this->url_for('urlaubskalender'));
        $views->addLink(_('Zeitstrahl-Ansicht'),
                        $this->url_for('urlaubskalender/timeline'));
        $sidebar->addWidget($views);
            
            // Show action to add widget only if not all widgets have already been added.
            $actions = new ActionsWidget();

            $actions->addLink(_('Neuen Urlaubstermin eintragen'),
                              $this->url_for('urlaubskalender/new'),
                              Icon::create('add', 'clickable'));
            
            $actions->addLink(_('Urlaubstermine bearbeiten'),
                              $this->url_for('urlaubskalender/'. (!$this->mitarbeiter_admin ? ('edituser/'.$GLOBALS['user']->id) : 'edit')),
                              Icon::create('edit', 'clickable'));
            
            $sidebar->addWidget($actions);
       
        
        
        $this->help = _('Sie können nach Name, Vorname oder eMail-Adresse suchen');

        $search_obj = new SQLSearch("SELECT auth_user_md5.user_id, CONCAT(auth_user_md5.nachname, ', ', auth_user_md5.vorname, ' (' , auth_user_md5.email, ')' ) as fullname, username, perms "
                            . "FROM auth_user_md5 "
                            . "LEFT JOIN user_info ON (auth_user_md5.user_id = user_info.user_id) "
                            . "LEFT JOIN seminar_user ON (auth_user_md5.user_id = seminar_user.user_id) "
                            . "WHERE "
                            . "seminar_user.Seminar_id LIKE '". $this->id . "' "
                            . "AND (username LIKE :input OR Vorname LIKE :input "
                            . "OR CONCAT(Vorname,' ',Nachname) LIKE :input "
                            . "OR CONCAT(Nachname,' ',Vorname) LIKE :input "
                            . "OR Nachname LIKE :input OR {$GLOBALS['_fullname_sql']['full_rev']} LIKE :input) "
                            . " ORDER BY fullname ASC",
                _('Nutzer suchen'), 'user_id');
        $this->quick_search = QuickSearch::get('user_id', $search_obj)
                    ->fireJSFunctionOnSelect('select_user');
        
        
        $this->render_action('edit');
        
    
    }
    
     /**
     *  This action adds a holiday entry
     *
     * @return void
     */
    public function edituser_action($id = '')
    {
        PageLayout::setTitle(_('Neuen Urlaubstermin eintragen'));
        $this->id = Config::get()->getValue('INTRANET_SEMID_MITARBEITERINNEN');
         global $perm;
        $this->mitarbeiter_admin = $perm->have_studip_perm('dozent', $this->id);
        
         $sidebar = Sidebar::get();
            $sidebar->setImage('sidebar/home-sidebar.png');
            $sidebar->setTitle(_("Meine Startseite"));

            
            $views = new ViewsWidget();
        $views->addLink(_('Kalenderansicht'),
                        $this->url_for('urlaubskalender'));
        $views->addLink(_('Zeitstrahl-Ansicht'),
                        $this->url_for('urlaubskalender/timeline'));
        $sidebar->addWidget($views);
            
            // Show action to add widget only if not all widgets have already been added.
            $actions = new ActionsWidget();

            $actions->addLink(_('Neuen Urlaubstermin eintragen'),
                              $this->url_for('urlaubskalender/new'),
                              Icon::create('add', 'clickable'));
            
            $actions->addLink(_('Urlaubstermine bearbeiten'),
                              $this->url_for('urlaubskalender/'. (!$this->mitarbeiter_admin ? ('edituser/'.$GLOBALS['user']->id) : 'edit')),
                              Icon::create('edit', 'clickable'));

            $sidebar->addWidget($actions);
       
        
        
        $this->user_id = $id ? $id : $_POST['user_id'];
        $this->entries = MAHoliday::findBySQL('user_id = ? ORDER BY begin ASC',
                    array($this->user_id));
        
        $this->render_action('edituser');
        
    
    }

    public function save_action($id = NULL) {
        
        if($this->entry = MAHoliday::find($id)){
            
            foreach($_POST as $key => $value){
                if (is_array($value)){
                    $value = implode(", ", $value);
                }
                
                    try {
                    $this->entry->setValue($key, $value);
                    } catch (Exception $e){}
                
            }
            $this->entry->chdate  = time();
            $this->entry->store();
            PageLayout::postMessage(MessageBox::success(_('Die Änderungen wurden gespeichert.')));
        } else {
            $this->entry = new MAHoliday();
            foreach($_POST as $key => $value){
                if (is_array($value)){
                    $value = implode(", ", $value);
                }
                
                    try {
                    $this->entry->setValue($key, $value);
                    } catch (Exception $e){}
                
            }
            $this->entry->mkdate  = time();
            $this->entry->chdate  = time();
            $this->entry->store();
            PageLayout::postMessage(MessageBox::success(_('Der Eintrag wurde gespeichert.')));
        }
        
        $this->redirect($this->url_for('/urlaubskalender'));
        
    }

    /**
     *  This actions removes a holiday entry
     *
     *
     * @return void
     */
    function delete_action($id)
    {
        if($entry = MAHoliday::find($id)){
            $entry->delete();
            PageLayout::postMessage(MessageBox::success(_('Der Eintrag wurde gelöscht.')));
        }
        
        $this->redirect($this->url_for('/urlaubskalender'));
    }

    
     function url_for($to)
    {
        $args = func_get_args();

        # find params
        $params = array();
        if (is_array(end($args))) {
            $params = array_pop($args);
        }

        # urlencode all but the first argument
        $args = array_map('urlencode', $args);
        $args[0] = $to;

        return PluginEngine::getURL($this->dispatcher->plugin, $params, join('/', $args));
    } 
    
    function color_by_crossfoot ( $digits )
  {
    // Typcast falls Integer uebergeben
    $strDigits = ( string ) $digits;

    for( $intCrossfoot = $i = 0; $i < strlen ( $strDigits ); $i++ )
    {
      $intCrossfoot += $strDigits{$i};
    }

    $colors = array('1' => '#1e90ff',
                    '2' => '#008000',
                    '3' => '#b22222',
                    '4' => '#9370db',
                    '5' => '#008b8b',
                    '6' => '#6495ed',
                    '7' => '#d2691e',
                    '8' => '#2f4f4f',
                    '9' => '#4b0082',
                    '0' => '#778899',
        );
    
    
    return $colors[$intCrossfoot];
  } 
}
