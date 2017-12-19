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


class Intranet extends StudIPPlugin implements SystemPlugin
{


    private  $template_factory;	

    function __construct()
    {
        parent::__construct();
        global $user;
        
         if($user->id != 'nobody'){
            if (Navigation::hasItem('/start')){
                Navigation::getItem('/start')->setURL( PluginEngine::getLink($this, array(), 'start/'));
            }
            $referer = $_SERVER['REQUEST_URI'];
         
         if ( $referer!=str_replace("dispatch.php/start","",$referer) ){
				
				//$result = $this->getSemStmt($GLOBALS['user']->id);
				header('Location: '. $GLOBALS['ABSOLUTE_URI_STUDIP']. 'plugins.php/intranet/start/', true, 303);
				exit();	
			} 
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
        //PageLayout::addStylesheet($this->getPluginURL().'/assets/style.css');
        PageLayout::addScript($this->getPluginURL().'/js/script.js');
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
}
