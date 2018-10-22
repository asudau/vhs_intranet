<?php
/*
 * This is the controller for the single calendar view
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of
 * the License, or (at your option) any later version.
 *
 * @author      Peter Thienel <thienel@data-quest.de>
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GPL version 2
 * @category    Stud.IP
 */

require_once 'app/controllers/calendar/single.php';


class CalendarInternController extends StudipController
{

    public function before_filter(&$action, &$args) {
        $this->base = 'IntranetMitarbeiterInnen/calendar_intern/index/';
        parent::before_filter($action, $args);
        if (Request::isXhr()) {
            $this->response->add_header('Content-Type', 'text/html; charset=windows-1252');
            $this->layout = null;
        }
    }
    public function index_action(){
        //not using this
        $dispatcher = new StudipDispatcher();
        $controller = new Calendar_SingleController($dispatcher);
        $response = $controller->relay('calendar/single/week/' . Config::get()->getValue('INTRANET_SEMID_MITARBEITERINNEN'));
        //$response = $controller->relay('news/display/9fc5dd6a84acf0ad76d2de71b473b341'); //localhost
        $this->internnewstemplate = $GLOBALS['template_factory']->open('shared/string');
        $this->internnewstemplate->content = $response->body;
        //$controller->redirect('calendar/single/month/'. $GLOBALS['user']->user_id);
        
        
    }
}
