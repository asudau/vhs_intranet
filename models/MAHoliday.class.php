<?php


/**
 * @author  <asudau@uos.de>
 *
 * @property int     $id
 * @property string  $type
 * @property string  $sub_type
 * @property int     $parent_id
 * @property Block   $parent
 * @property Block[] $children
 * @property string  $seminar_id
 * @property \Course $course
 * @property string  $title
 * @property int     $position
 * @property int     $publication_date
 * @property int     $chdate
 * @property int     $mkdate
 */
class MAHoliday extends \SimpleORMap
{

    public $errors = array();

    /**
     * Give primary key of record as param to fetch
     * corresponding record from db if available, if not preset primary key
     * with given value. Give null to create new record
     *
     * @param mixed $id primary key of table
     */
    public function __construct($id = null) {

        $this->db_table = 'intranet_ma_holidays';

        parent::__construct($id);
    }

}

