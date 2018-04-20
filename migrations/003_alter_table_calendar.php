<?php
include_once __DIR__.'/../models/IntranetDate.class.php';


class AlterTableCalendar extends Migration
{
    public function description () {
        return 'add type in Table for MA Holidaycalendar for Intranet';
    }


    public function up () {
        $db = DBManager::get();
        $db->exec("ALTER TABLE `intranet_ma_holidays`  "
                . "ADD `type` VARCHAR(32) NOT NULL AFTER `notice`");
           
        
        $dates = IntranetDate::findBySQL('1=1');    
        foreach($dates as $date){
            $date->type = 'urlaub';
            $date->store();
        }
        
        
        SimpleORMap::expireTableScheme();
    }


    public function down () {

    }
    
}

