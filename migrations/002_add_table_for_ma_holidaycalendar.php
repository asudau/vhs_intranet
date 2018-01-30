<?php



class AddTableForMaHolidaycalendar extends Migration
{
    public function description () {
        return 'add Table for MA Holidaycalendar for Intranet';
    }


    public function up () {
        $db = DBManager::get();
        $db->exec("CREATE TABLE IF NOT EXISTS `intranet_ma_holidays` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `user_id` varchar(64) NOT NULL,
          `begin` varchar(16) DEFAULT NULL,
          `end` varchar(16) DEFAULT NULL,
          `notice` mediumtext,
          `chdate` int(11) DEFAULT NULL,
          `mkdate` int(11) DEFAULT NULL,
          PRIMARY KEY (`id`)
        )");
           
        SimpleORMap::expireTableScheme();
    }


    public function down () {
        
        DBManager::get()->exec("DROP TABLE intranet_ma_holidays");
        SimpleORMap::expireTableScheme();
    }

    
}

