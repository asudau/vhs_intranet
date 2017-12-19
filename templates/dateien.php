<?
/**
 * Template fuer Infos auf der Startseite
 *
 * @package      virtUOS
 * @author     Annelene Sudau
 * @copyright  (c) Authors
 * @license    http://www.gnu.org/licenses/gpl.html GPLv3 or later
 */
/*
  Copyright (C) 2017 Annelene Sudau

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License along
  with this program; if not, write to the Free Software Foundation, Inc.,
  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */




// Dokumente 
//$seminar_id ="7637bfed08c7a2a3649eed149375cbc0";
//$seminar_id ="9fc5dd6a84acf0ad76d2de71b473b341";
$query = "SELECT dokumente.dokument_id AS dokument_id, dokumente.filename AS filename, folder.name AS folder, dokumente.description AS description, dokumente.name AS name FROM dokumente ".
         "LEFT JOIN folder ON folder.folder_id = dokumente.range_id ".
         "WHERE dokumente.seminar_id='{$this->sem_id}'";

  //$query_folder = "SELECT folder_id, range_id, name FROM dokumente WHERE seminar_id='{$this->sem_id}'"; 

$l = 0;
$statement = DBManager::get()->prepare($query);
$statement->execute();
$content;

$folder = array();

while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {

                if ($row['name']){
                        $content['DOCUMENTS'][$row['folder']][$l]['DOCUMENT_TITLE'] = htmlReady($row['name']);
               }
                if ($row['filename']){
                        $content['DOCUMENTS'][$row['folder']][$l]['DOCUMENT_FILENAME'] = htmlReady($row['filename']);
               }

                if ($row['dokument_id']){
                        $content['DOCUMENTS'][$row['folder']][$l]['DOCUMENT_ID'] = htmlReady($row['dokument_id']);
                        //$content['LECTUREDETAILS']['DOCUMENTS']['DOCUMENT'][$l]['DOCUMENT_DOWNLOAD_URL'] = ExternModule::ExtHtmlReady($this->$db->f('file_id')); 
                }
                if ($row['description']){
                        $content['DOCUMENTS'][$row['folder']][$l]['DOCUMENT_DESCRIPTION'] = htmlReady($row['description']);
               }
$l++;
}




?>


<style type="text/css">
   
h2 {
font-family:"Lato",sans-serif;
}

table {
border-collapse: collapse;
border-spacing: 1px;
width:100%;
font-family:"Lato",sans-serif;
}
       
td, th {
padding:10px 10px;
border:none;
vertical-align:top;
}

tr td, tr th {
background:#CCD5DE;
}

/* links */

td a, td a:visited {
padding-top:6px;
padding-bottom:6px;
margin-top:-6px;
margin-bottom:-6px;
}

td a {
color:#333;
}

td a:visited {
color:#999;
}

tbody th a {
background: url(https://fi3.fi/table.png) center left no-repeat;
padding-left:20px;
color:#333;
}

    

 tbody a[title^="Download"] { 
background: url(https://el4.elan-ev.de/assets/images/download.gif) center left no-repeat;
padding-left: 30px;
}

.description{
width:100%;
background: #efefef;
color: #333;
text-align: left;
font-size: 1em;
line-height:2em;
padding: 10px;
font-family:"Lato",sans-serif;
}
</style>

<div class='files'>

   
<? foreach ($content['DOCUMENTS'] as $key => $folder): ?>
   <? if (strcmp($key, 'Wysiwyg Uploads') != 0): ?>
    <h1><?= $key ?></h1>
   <div>
        <section class="contentbox">
            <header>
           
            </header>
        <? foreach ($folder as $document): ?>
        <article>
            <header>
                <a href="/sendfile.php?force_download=1&type=0&file_id=<?=$document['DOCUMENT_ID']?>&file_name=<?=$document['DOCUMENT_FILENAME']?>">
                <img src="http://localhost/ammerland3.4/public/assets/images/icons/blue/download.svg" alt="news" class="icon-role-clickable icon-shape-news" height="16" width="16">         
 <?=$document['DOCUMENT_TITLE']?> </a><br>
                <? if($document['DOCUMENT_DESCRIPTION']){ ?>
                    <span style="margin-left:10px"> <?=$document['DOCUMENT_DESCRIPTION']?> </span>
                <? } ?>
               
              
         </header>
        </article>
       
        <? endforeach ?>
        </section>
       
    </p></div>
    <? endif ?>
<? endforeach ?>

</div>






<script type="text/javascript">
  var framefenster = document.getElementsByTagName("iframe");
  var auto_resize_timer = window.setInterval("autoresize_frames()", 400);
  function autoresize_frames() {
    for (var i = 0; i < framefenster.length; ++i) {
        if(framefenster[i].contentWindow.document.body){
          var framefenster_size = framefenster[i].contentWindow.document.body.offsetHeight;
          if(document.all && !window.opera) {
            framefenster_size = framefenster[i].contentWindow.document.body.scrollHeight;
          }
          framefenster[i].style.height = framefenster_size + 'px';
        }
    }
  }
</script>




<?
$layout = $GLOBALS['template_factory']->open('shared/index_box');


page_close();
