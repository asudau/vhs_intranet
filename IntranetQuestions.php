<?php

/*
 * EvaluationsWidget.php - widget plugin for start page
 *
 * Copyright (C) 2015 - Annelene Sudau <sudau@elan-ev.de>
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of
 * the License, or (at your option) any later version.
 */

require_once 'app/controllers/questionnaire.php';

class IntranetQuestions extends StudIPPlugin implements PortalPlugin
{
    public function getPluginName()
    {
        return _('Umfragen für MitarbeiterInnen');
    }

    public function getPortalTemplate()
    {
        // include and show votes and tests
        if (get_config('VOTE_ENABLE')) {
            $controller = new PluginController(new StudipDispatcher());
            $response = $controller->relay('evaluation/display/7637bfed08c7a2a3649eed149375cbc0')->body;
            $response .= $controller->relay('questionnaire/widget/7637bfed08c7a2a3649eed149375cbc0')->body;
            //$response = $controller->relay('evaluation/display/9fc5dd6a84acf0ad76d2de71b473b341')->body; //localhost
            //$response .= $controller->relay('questionnaire/widget/9fc5dd6a84acf0ad76d2de71b473b341')->body; //localhost
            
            /**
            $response = $this->relay('evaluation/display/' . $this->course_id);
            $this->evaluations = $response->body;

            $response = $this->relay('questionnaire/widget/' . $this->course_id);
            $this->questionnaires = $response->body;
             * 
             */
            

            $template = $GLOBALS['template_factory']->open('shared/string');
            $template->content = $response;

            if ($GLOBALS['perm']->have_perm('root')) {
                $navigation = new Navigation('', 'dispatch.php/questionnaire/overview');
                $navigation->setImage(Icon::create('admin', 'clickable', ["title" => _('Umfragen bearbeiten')]));
                $template->icons = array($navigation);
            }
            return $template;
        }
    }
    
}
