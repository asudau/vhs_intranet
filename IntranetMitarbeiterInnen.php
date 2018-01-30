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


class IntranetMitarbeiterInnen extends StudIPPlugin implements SystemPlugin
{


    private  $template_factory;	

    function __construct()
    {
        global $user;
        
        $courses = $user->course_memberships;
        $ma_intranet = false;
        foreach ($courses as $cm){
            if ($cm->seminar_id == '7637bfed08c7a2a3649eed149375cbc0') $ma_intranet = true;
            //test lokal
            if ($cm->seminar_id == '568fce7262620700103ce1657cabc5e3') $ma_intranet = true; 
        } 
        $referer = $_SERVER['REQUEST_URI'];
        
        if($ma_intranet){
            
            parent::__construct();
         
            if (Navigation::hasItem('/start')){
                Navigation::getItem('/start')->setURL( PluginEngine::getLink($this, array(), 'start/'));
            }
            
         //Intranetnutzer werden statt auf die allgemeine Startseite auf ihre individuelle Startseite weitergeleitet
         if ( $referer!=str_replace("dispatch.php/start","",$referer) && $ma_intranet){
				
				//$result = $this->getSemStmt($GLOBALS['user']->id);
				header('Location: '. $GLOBALS['ABSOLUTE_URI_STUDIP']. 'plugins.php/IntranetMitarbeiterInnen/start/', true, 303);
				exit();	
			} 
         //Nicht-Intranetnutzer werden, wenn sie die Intranet URL verwenden, auf die allgemeine Startseite weitergeleitet
         } else if ( $referer!=str_replace("plugins.php/IntranetMitarbeiterInnen","",$referer) || $referer!=str_replace("plugins.php/intranetmitarbeiterinnen","",$referer)){
             header('Location: '. $GLOBALS['ABSOLUTE_URI_STUDIP']. 'dispatch.php/start', true, 303);
				exit();	
         }
        
        
        $this->template_factory = new Flexi_TemplateFactory(dirname(__FILE__) . '/templates/');    
        //PageLayout::addStylesheet($this->getPluginUrl() . '/css/intranet.css');
    }


    public function getPluginName()
    {
        return _('Intranet');
    }

    // bei Aufruf des Plugins Ã¼ber plugin.php/mooc/...
    public function initialize ()
    {
        PageLayout::addStylesheet($this->getPluginUrl() . '/css/style.css');
        PageLayout::addStylesheet($this->getPluginUrl() . '/css/intranet.css');
        PageLayout::addStylesheet($this->getPluginUrl() . '/css/dhtmlxscheduler.css');
        //PageLayout::addStylesheet($this->getPluginURL().'/assets/style.css');
        //PageLayout::addScript($this->getPluginURL().'/js/script.js');
        PageLayout::addScript($this->getPluginURL().'/assets/js/dhtmlxscheduler.js');
        PageLayout::addScript($this->getPluginURL().'/assets/js/locale_de.js');
        PageLayout::addScript($this->getPluginURL().'/assets/js/dhtmlxscheduler_timeline.js');
		$this->setupAutoload();
    }
	
    public function perform($unconsumed_path) {

	 //$this->setupAutoload();
        $dispatcher = new Trails_Dispatcher(
            $this->getPluginPath(),
            rtrim(PluginEngine::getLink($this, array(), null), '/'),
            'show'
        );
        $dispatcher->plugin = $this;
        $dispatcher->dispatch($unconsumed_path);
 
    }

    private function setupAutoload() {
        if (class_exists("StudipAutoloader")) {
            StudipAutoloader::addAutoloadPath(__DIR__ . '/models');
        } else {
            spl_autoload_register(function ($class) {
                include_once __DIR__ . $class . '.php';
            });
        }
    }
    
    private function setupNavigation(){
        
    }
    
     public function getPortalTemplate()
    {
        return NULL;
    }
}
