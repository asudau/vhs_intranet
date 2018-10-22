<?php



class AddSeminarsForIntranet extends Migration
{
    public function description () {
        return 'add Seminar for Intranet (MitarbeiterInnen)';
    }


    public function up () {
        //TODO Seminar anlegen
        //TODO Sem_id in config eintragen ($this->addConfigOptionMitarbeiterInnenSemID($sem_id))
        //TODO Auto Insert von MitarbeiterInnen einrichten 
        $sem_id = '7637bfed08c7a2a3649eed149375cbc0';
        $this->addConfigOptionMitarbeiterInnenSemID($sem_id);
        $this->addConfigOptionProjektBereichSemID($sem_id);
    }


    public function down () {
        
        $this->removeConfigOptions();
        SimpleORMap::expireTableScheme();
    }

    /**********************************************************************/
    /* PRIVATE METHODS                                                    */
    /**********************************************************************/

    private function addConfigOptionMitarbeiterInnenSemID($sem_id)
    {
        Config::get()->create('INTRANET_SEMID_MITARBEITERINNEN', array(
            'value' => $sem_id, 
            'is_default' => 0, 
            'type' => 'string',
            'range' => 'global',
            'section' => 'global',
            'description' => _('ID der Veranstaltung welche Inhalte fuer MitarbeiterInnen enthaelt')
            ));
        //Config::get()->getValue('MiniCourse_SEM_CLASS_CONFIG_ID');
    }
    
     private function addConfigOptionProjektBereichSemID($sem_id)
    {
        Config::get()->create('INTRANET_SEMID_PROJEKTBEREICH', array(
            'value' => $sem_id, 
            'is_default' => 0, 
            'type' => 'string',
            'range' => 'global',
            'section' => 'global',
            'description' => _('ID der Veranstaltung welche Inhalte fuer den Projektbereich enthaelt')
            ));
    }
  
    private function removeConfigOptions()
    {
        return (Config::get()->delete('INTRANET_SEMID_MITARBEITERINNEN') && Config::get()->delete('INTRANET_SEMID_PROJEKTBEREICH'));
    }
}

