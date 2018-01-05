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
 * @author   Andr� Kla�en <klassen@elan-ev.de>
 * @author   Nadine Werner <nadine.werner@uni-osnabrueck.de>
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
        
        //get intern news
        $dispatcher = new StudipDispatcher();
        $controller = new NewsController($dispatcher);
        $response = $controller->relay('news/display/9fc5dd6a84acf0ad76d2de71b473b341');
        //$response = $controller->relay('news/display/9fc5dd6a84acf0ad76d2de71b473b341'); //localhost
        $this->internnewstemplate = $GLOBALS['template_factory']->open('shared/string');
        $this->internnewstemplate->content = $response->body;
        

        if (StudipNews::CountUnread() > 0) {
            $navigation = new Navigation('', PluginEngine::getLink($this, array(), 'read_all'));
            $navigation->setImage(Icon::create('refresh', 'clickable', ["title" => _('Alle als gelesen markieren')]));
            $icons[] = $navigation;
        }

        $this->internnewstemplate->icons = $icons;
        
        
        
        //get new and recently visited courses of user
        $statement = DBManager::get()->prepare("SELECT s.Seminar_id, s.Name, ouv.visitdate, ouv.type "
                . "FROM seminare as s "
                . "LEFT JOIN object_user_visits as ouv ON (s.Seminar_id = ouv.object_id) "
                . "WHERE ouv.user_id = :user_id "
                . "AND ouv.type = 'sem' "
                . "AND s.Seminar_id in "
                . "(SELECT su.Seminar_id FROM seminar_user as su WHERE su.user_id = :user_id) ORDER BY ouv.visitdate DESC");

        $statement->execute(array(':user_id' => $GLOBALS['user']->id));
        $this->courses = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        /**
        $this->left = WidgetHelper::getUserWidgets($GLOBALS['user']->id, 0);
        $this->right = WidgetHelper::getUserWidgets($GLOBALS['user']->id, 1);

        if (!(count($this->left) + count($this->right)) ) {
            WidgetHelper::setInitialPositions();
            $this->left = WidgetHelper::getUserWidgets($GLOBALS['user']->id, 0);
            $this->right = WidgetHelper::getUserWidgets($GLOBALS['user']->id, 1);
        }

        WidgetHelper::setActiveWidget(Request::get('activeWidget'));

        
            $sidebar = Sidebar::get();
            $sidebar->setImage('sidebar/home-sidebar.png');
            $sidebar->setTitle(_("Meine Startseite"));

            $nav = new NavigationWidget();
            $nav->setTitle(_('Sprungmarken'));
            foreach (array_merge($this->left, $this->right) as $widget) {
                $nav->addLink($widget->getPluginName(),
                              $this->url_for('start#widget-' . $widget->widget_id));
            }
            $sidebar->addWidget($nav);

            // Show action to add widget only if not all widgets have already been added.
            $actions = new ActionsWidget();

            if (WidgetHelper::getAvailableWidgets($GLOBALS['user']->id)) {
                $actions->addLink(_('Widgets hinzuf�gen'),
                                  $this->url_for('start/add'),
                                  Icon::create('add', 'clickable'))
                        ->asDialog();
            }

            $actions->addLink(_('Standard wiederherstellen'),
                              $this->url_for('start/reset'),
                              Icon::create('accept', 'clickable'));
            $sidebar->addWidget($actions);

            // Root may set initial positions
            if ($GLOBALS['perm']->have_perm('root')) {
                $settings = new ActionsWidget();
                $settings->setTitle(_('Einstellungen'));
                $settings->addElement(new WidgetElement(_('Standard-Startseite bearbeiten:')));
                foreach ($GLOBALS['perm']->permissions as $permission => $useless) {
                    $settings->addElement(new LinkElement(
                        ucfirst($permission),
                        $this->url_for('start/edit_defaults/' . $permission),
                        Icon::create('link-intern', 'clickable'), array('data-dialog' => '')
                    ));
                }

                $sidebar->addWidget($settings);
            }
       **/
        
        
         //get project news
        $dispatcher = new StudipDispatcher();
        $controller = new NewsController($dispatcher);
        $response = $controller->relay('news/display/9fc5dd6a84acf0ad76d2de71b473b341');
        //$response = $controller->relay('news/display/9fc5dd6a84acf0ad76d2de71b473b341'); //localhost
        $this->projectnewstemplate = $GLOBALS['template_factory']->open('shared/string');
        $this->projectnewstemplate->content = $response->body;
        

        if (StudipNews::CountUnread() > 0) {
            $navigation = new Navigation('', PluginEngine::getLink($this, array(), 'read_all'));
            $navigation->setImage(Icon::create('refresh', 'clickable', ["title" => _('Alle als gelesen markieren')]));
            $icons[] = $navigation;
        }

        $this->projectnewstemplate->icons = $icons;
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        if ($GLOBALS['perm']->get_perm() == 'user') {
            PageLayout::postMessage(MessageBox::info(_('Sie haben noch nicht auf Ihre Best�tigungsmail geantwortet.'),
                array(
                    _('Bitte holen Sie dies nach, um Stud.IP Funktionen wie das Belegen von Veranstaltungen nutzen zu k�nnen.'),
                    sprintf(_('Bei Problemen wenden Sie sich an: %s'), '<a href="mailto:'.$GLOBALS['UNI_CONTACT'].'">'.$GLOBALS['UNI_CONTACT'].'</a>')
                )
            ));

            PageLayout::postMessage(MessageBox::info(
                    sprintf(_('Haben Sie die Best�tigungsmail an Ihre Adresse "%s" nicht erhalten?'), htmlReady($GLOBALS['user']->Email)),
                    array(
                        Studip\LinkButton::create(_('Best�tigungsmail erneut verschicken'),
                            $this->url_for('start/resend_validation_mail')
                        ) . ' '
                        . Studip\LinkButton::create(_('Email-Adresse �ndern'),
                            $this->url_for('start/edit_mail_address'), array(
                                'data-dialog' => "size=auto",
                                'title'       => _('Email-Adresse')
                            )
                        ),
                    )
            ));
        }
    }

    /**
     *  This action adds one or more new widgets to the start page
     *
     * @return void
     */
    public function add_action()
    {
        PageLayout::setTitle(_('Widgets hinzuf�gen'));

        if (Request::isPost()) {
            $ticket   = Request::get('studip_ticket');
            $widgets  = Request::intArray('widget_id');
            $position = Request::int('position');

            $post_url = '';
            if (check_ticket($ticket)) {
                foreach ($widgets as $widget) {
                    $id = WidgetHelper::addWidget($widget, $GLOBALS['user']->id);
                    if (!$post_url) {
                        $post_url = '#widget-' . $id;
                    }
                }
            }
            $this->redirect('start' . $post_url);
        }
        $this->widgets = WidgetHelper::getAvailableWidgets($GLOBALS['user']->id);
    }


    /**
     * Edit the default startpage configuration for users by permissions
     *
     * @param string $permission
     *
     * @throws InvalidArgumentException
     */
    public function edit_defaults_action($permission)
    {
        if (in_array($permission, array_keys($GLOBALS['perm']->permissions)) === false) {
            throw new InvalidArgumentException('There is no such permission!');
        }

        PageLayout::setTitle(sprintf(_('Standard-Startseite f�r "%s" bearbeiten'), ucfirst($permission)));

        $this->widgets = WidgetHelper::getAvailableWidgets();
        $this->permission = $permission;

        $this->initial_widgets = WidgetHelper::getInitialPositions($permission);
        $available_plugin_ids = array_keys($this->widgets);
        $this->initial_widgets[0] = array_intersect((array)$this->initial_widgets[0], $available_plugin_ids);
        $this->initial_widgets[1] = array_intersect((array)$this->initial_widgets[1], $available_plugin_ids);

    }

    /**
     * Store the edited default startpage configuration for users by permissions
     *
     * @param string $permission
     *
     * @throws InvalidArgumentException
     */
    public function update_defaults_action($permission)
    {
        $GLOBALS['perm']->check('root');

        if (in_array($permission, array_keys($GLOBALS['perm']->permissions)) === false) {
            throw new InvalidArgumentException('There is no such permission!');
        }

        WidgetHelper::storeInitialPositions(0, Request::getArray('left'), $permission);
        WidgetHelper::storeInitialPositions(1, Request::getArray('right'), $permission);

        $this->render_nothing();
    }

    /**
     *  This actions removes a new widget from the start page
     *
     * @param string $widgetId
     * @param string $approveDelete
     * @param string $studipticket
     *
     * @return void
     */
    function delete_action($id)
    {
        if (Request::isPost()) {
            if (Request::submitted('yes')) {
                $name = WidgetHelper::getWidgetName($id);
                if (WidgetHelper::removeWidget($id, $name, $GLOBALS['user']->id)) {
                    $message = sprintf(_('Widget "%s" wurde entfernt.'), $name);
                    PageLayout::postMessage(MessageBox::success($message));
                } else {
                    $message = sprintf(_('Widget "%s" konnte nicht entfernt werden.'), $name);
                    PageLayout::postMessage(MessageBox::error($message));
                }
            }
        } else {
            $message = sprintf(_('Sind Sie sicher, dass Sie das Widget "%s" von der Startseite entfernen m�chten?'),
                               WidgetHelper::getWidgetName($id));
            $this->flash['question'] = createQuestion2($message, array(), array(), $this->url_for('start/delete/' . $id));
        }
        $this->redirect('start');
    }

    /**
     * Resets widget to initial default state.
     */
    public function reset_action()
    {
        $widgets = array_merge(
            WidgetHelper::getUserWidgets($GLOBALS['user']->id, 0),
            WidgetHelper::getUserWidgets($GLOBALS['user']->id, 1)
        );

        foreach ($widgets as $widget) {
            $name = WidgetHelper::getWidgetName($widget->widget_id);
            WidgetHelper::removeWidget($widget->widget_id, $name, $GLOBALS['user']->id);
        }

        WidgetHelper::setInitialPositions();

        $message = _('Die Widgets wurden auf die Standardkonfiguration zur�ckgesetzt.');
        PageLayout::postMessage(MessageBox::success($message));
        $this->redirect('start');
    }

    /**
     *  Action to store the widget placements
     *
     * @return void
     */
    function storeNewOrder_action()
    {
        WidgetHelper::storeNewPositions(Request::get('widget'), Request::get('position'), Request::get('column'));
        $this->render_nothing();
    }

    /**
     * Resend the validation mail for the current user
     *
     * @return void
     */
    function resend_validation_mail_action()
    {
        if ($GLOBALS['perm']->get_perm() == 'user') {
            Seminar_Register_Auth::sendValidationMail($GLOBALS['user']);
            PageLayout::postMessage(MessageBox::success(
                _('Die Best�tigungsmail wurde erneut verschickt.')
            ));
        }

        $this->redirect('start');
    }

    /**
     * Show form to change the mail-address for the validation mail
     *
     * @return void
     */
    function edit_mail_address_action()
    {
        // only allow editing of mail-address here if user has not yet validated
        if ($GLOBALS['perm']->get_perm() != 'user') {
            $this->redirect('start');
            return;
        }

        $this->email = $GLOBALS['user']->Email;
    }

    /**
     * Change the mail-address and resend validation mail
     *
     * @return void
     */
    function change_mail_address_action()
    {
        if ($GLOBALS['perm']->get_perm() == 'user') {
            $user = new User($GLOBALS['user']->id);
            $user->Email = Request::get('email');
            $user->store();

            $GLOBALS['user']->Email = $user->Email;

            Seminar_Register_Auth::sendValidationMail($user);
            PageLayout::postMessage(MessageBox::success(
                _('Ihre Mailadresse wurde ge�ndert und die Best�tigungsmail erneut verschickt.')
            ));
        }

        $this->redirect('start');
    }
}