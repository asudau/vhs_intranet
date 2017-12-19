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
require_once 'app/controllers/news.php';

class IntranetNews extends StudIPPlugin implements PortalPlugin
{


    private  $template_factory;	

    function __construct()
    {
        parent::__construct();
        $this->template_factory = new Flexi_TemplateFactory(dirname(__FILE__) . '/templates/');    
        if (!$GLOBALS['perm']->have_perm('root')){
            //PageLayout::addStylesheet($this->getPluginUrl() . '/css/noAdmin.css');
        }
    }


    public function getPluginName()
    {
        return _('News für MitarbeiterInnen');
    }

    public function getPortalTemplate()
    {
        $dispatcher = new StudipDispatcher();
        $controller = new NewsController($dispatcher);
        $response = $controller->relay('news/display/7637bfed08c7a2a3649eed149375cbc0');
        //$response = $controller->relay('news/display/9fc5dd6a84acf0ad76d2de71b473b341'); //localhost
        $template = $GLOBALS['template_factory']->open('shared/string');
        $template->content = $response->body;
        

        if (StudipNews::CountUnread() > 0) {
            $navigation = new Navigation('', PluginEngine::getLink($this, array(), 'read_all'));
            $navigation->setImage(Icon::create('refresh', 'clickable', ["title" => _('Alle als gelesen markieren')]));
            $icons[] = $navigation;
        }

        if (get_config('NEWS_RSS_EXPORT_ENABLE')) {
            
            if ($rss_id = StudipNews::GetRssIdFromRangeId('7637bfed08c7a2a3649eed149375cbc0')) {
            //if ($rss_id = StudipNews::GetRssIdFromRangeId('9fc5dd6a84acf0ad76d2de71b473b341')) { //localhost
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

        $template->icons = $icons;

        return $template;
    }
    
     public function perform($unconsumed)
    {
        if ($unconsumed !== 'read_all') {
            return;
        }
        $global_news = StudipNews::GetNewsByRange('7637bfed08c7a2a3649eed149375cbc0', true);
        //$global_news = StudipNews::GetNewsByRange('9fc5dd6a84acf0ad76d2de71b473b341', true); //localhost
        foreach ($global_news as $news) {
            object_add_view($news['news_id']);
            object_set_visit($news['news_id'], 'news');
        }

        if (Request::isXhr()) {
            echo json_encode(true);
        } else {
            PageLayout::postMessage(MessageBox::success(_('Alle Ankündigungen wurden als gelesen markiert.')));
            header('Location: '. URLHelper::getLink('dispatch.php/start'));
        }
    
    }

    
}
