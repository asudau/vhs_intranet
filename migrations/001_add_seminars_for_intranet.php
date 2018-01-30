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
        SimpleORMap::expireTableScheme();
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

    private function insertSemClass()
    {
        /**
        $db = DBManager::get();
        $name = 'BasisOnlineKurs'; //\Mooc\SEM_CLASS_NAME;

        $this->validateUniqueness($name);

        $statement = $db->prepare("INSERT INTO sem_classes SET name = ?, mkdate = UNIX_TIMESTAMP(), chdate = UNIX_TIMESTAMP()");
        $statement->execute(array($name));

        $id = $db->lastInsertId();

        $sem_class = SemClass::getDefaultSemClass();
        $sem_class->set('name', $name);
        $sem_class->set('id', $id);
        **/
	 //$sem_class->set('overview', NULL);
	 //$sem_class->set('forum', NULL);
	 //$sem_class->set('id', $id);
	 //$sem_class->set('id', $id);
	 //$sem_class->set('id', $id);

        $sem_class->store();

        $GLOBALS['SEM_CLASS'] = SemClass::refreshClasses();

        return $id;
    }

    private function validateUniqueness($name)
    {
        $statement = DBManager::get()->prepare('SELECT id FROM sem_classes WHERE name = ?');
        $statement->execute(array($name));
        if ($old = $statement->fetchColumn()) {
            $message = sprintf('Es existiert bereits eine Veranstaltungskategorie mit dem Namen "%s" (id=%d)', htmlspecialchars($name), $old);
            throw new Exception($message);
        }
    }

    private function addSemTypes($sc_id)
    {
        $db = DBManager::get();
        $statement = $db->prepare(
            "INSERT INTO sem_types SET name = ?, class = ?, mkdate = UNIX_TIMESTAMP(), chdate = UNIX_TIMESTAMP()");

		$name = "BasisOnlineKurs";
        //foreach (words(\MiniCourse\SEM_TYPE_NAMES) as $name) {
            $statement->execute(array($name, $sc_id));
        //}
        $GLOBALS['SEM_TYPE'] = SemType::refreshTypes();
    }

    

    private function removeSemClassAndTypes($id)
    {
        $sem_class = new SemClass(intval($id));
        $sem_class->delete();
        $GLOBALS['SEM_CLASS'] = SemClass::refreshClasses();
    }

    private function removeConfigOptions()
    {
        return (Config::get()->delete('INTRANET_SEMID_MITARBEITERINNEN') && Config::get()->delete('INTRANET_SEMID_PROJEKTBEREICH'));
    }
}

