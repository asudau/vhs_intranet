<?php
/*
 * TeilnehmerWidget.php - A widget with information for participants of VHS-courses
 *
 * Copyright (C) 2015 - Annelene Sudau <sudau@elan-ev.de>
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of
 * the License, or (at your option) any later version.
 */


class IntranetMitarbeiterInnen extends StudIPPlugin implements PortalPlugin
{


    private  $template_factory;	

    function __construct()
    {
        parent::__construct();
        $this->template_factory = new Flexi_TemplateFactory(dirname(__FILE__) . '/templates/');    
        PageLayout::addStylesheet($this->getPluginUrl() . '/css/intranet.css');
        if (!$GLOBALS['perm']->have_perm('root')){
            PageLayout::addStylesheet($this->getPluginUrl() . '/css/noAdmin.css');
        }
        $this->seminars = array('7637bfed08c7a2a3649eed149375cbc0');
        //$this->seminars = array('9fc5dd6a84acf0ad76d2de71b473b341'); //localhost
        
    }


    public function getPluginName()
    {
        return _('Intranet für MitarbeiterInnen');
    }

    public function getPortalTemplate()
    {
        $template = $this->template_factory->open('infos');
		$template->set_attribute('title', 'Intranet für MitarbeiterInnen');
		$template->set_attribute('content', '');

        //set votes
        if (get_config('VOTE_ENABLE')) {
            
            foreach ($this->seminars as $range_id){
                //is there any evaluation?
                $eval_db = new EvaluationDB();
                $evaluations = StudipEvaluation::findMany($eval_db->getEvaluationIDs($range_id, EVAL_STATE_ACTIVE));

                //is there any questionnaire?
                $statement = DBManager::get()->prepare("
                SELECT questionnaires.*
                FROM questionnaires
                    INNER JOIN questionnaire_assignments ON (questionnaires.questionnaire_id = questionnaire_assignments.questionnaire_id)
                WHERE questionnaire_assignments.range_id = :range_id
                    
                    AND startdate <= UNIX_TIMESTAMP()
                ORDER BY questionnaires.mkdate DESC
                ");
                $statement->execute(array(
                    'range_id' => $range_id
                ));
                $questionnaire_data = $statement->fetchAll(PDO::FETCH_ASSOC);
            
                $controller = new PluginController(new StudipDispatcher());
                $response .= $evaluations ? $controller->relay('evaluation/display/'. $range_id)->body : '';
                $response .= $questionnaire_data? $controller->relay('questionnaire/widget/'. $range_id)->body : '';
            }

            $votes = $GLOBALS['template_factory']->open('shared/string');
            $votes->content = $response == '' ? 'Derzeit gibt es keine Abstimmungen oder Umfragen': $response;

            if ($GLOBALS['perm']->have_perm('root')) {
                $navigation = new Navigation('', 'dispatch.php/questionnaire/overview');
                $navigation->setImage(Icon::create('admin', 'clickable', ["title" => _('Umfragen bearbeiten')]));
                $votes->icons = array($navigation);
            }
            $template->votes = $votes->content;
            
        }
        
        //set news
        $dispatcher = new StudipDispatcher();
        $controller = new NewsController($dispatcher);
        $news = $GLOBALS['template_factory']->open('shared/string');
        $have_news = false;
        
        foreach ($this->seminars as $range_id){
        
            $have_news = (StudipNews::GetNewsByRange($range_id, true, true) || $have_news);
            $response = $controller->relay('news/display/'. $range_id);
            $news->content .= $response->body;
        }

        if (StudipNews::CountUnread() > 0) {
            $navigation = new Navigation('', PluginEngine::getLink($this, array(), 'read_all'));
            $navigation->setImage(Icon::create('refresh', 'clickable', ["title" => _('Alle als gelesen markieren')]));
            $icons[] = $navigation;
        }

        //TODO generalisieren
        if (get_config('NEWS_RSS_EXPORT_ENABLE')) {
            if ($rss_id = StudipNews::GetRssIdFromRangeId('9fc5dd6a84acf0ad76d2de71b473b341')) {
                $navigation = new Navigation('', 'rss.php', array('id' => $rss_id));
                $navigation->setImage(Icon::create('rss', 'clickable', ["title" => _('RSS-Feed')]));
                $icons[] = $navigation;
            }
        }

        if ($GLOBALS['perm']->have_perm('root')) {
            $navigation = new Navigation('', 'dispatch.php/news/edit_news/new/studip');
            $navigation->setImage(Icon::create('add', 'clickable', ["title" => _('Ankündigungen bearbeiten')]), ["rel" => 'get_dialog']);
            $icons[] = $navigation;
            if (get_config('NEWS_RSS_EXPORT_ENABLE')) {
                $navigation = new Navigation('', 'dispatch.php/news/rss_config/studip');
                $navigation->setImage(Icon::create('rss+add', 'clickable', ["title" => _('RSS-Feed konfigurieren')]), ["data-dialog" => 'size=auto']);
                $icons[] = $navigation;
            }
        }

        $news->icons = $icons;
        $template->news = $have_news ? $news->content : 'Derzeit gibt es keine aktuellen News oder Informationen';

        return $template;
    }
}
