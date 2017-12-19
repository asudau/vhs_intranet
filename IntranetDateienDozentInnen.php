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


class IntranetDateienDozentInnen extends StudIPPlugin implements PortalPlugin
{


    private  $template_factory;	

    function __construct()
    {
        parent::__construct();
        $this->template_factory = new Flexi_TemplateFactory(dirname(__FILE__) . '/templates/');    
        //PageLayout::addStylesheet($this->getPluginUrl() . '/css/intranet.css');
    }


    public function getPluginName()
    {
        return _('Dateien für DozentInnen');
    }

    public function getPortalTemplate()
    {
        $template = $this->template_factory->open('dateien');
		$template->set_attribute('title', 'Dateien für DozentInnen');
		$template->set_attribute('content', '');
        $template->sem_id = '2dac34217342bd706ac114d57dd0b3ec';


        return $template;
    }
}
