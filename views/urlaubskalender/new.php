<? use Studip\Button, Studip\LinkButton;



        /**
        $mp = MultiPersonSearch::get("contacts_statusgroup_" . $id)
        ->setLinkText("")
        ->setDefaultSelectedUser(array_keys(getPersonsForRole($id)))
        ->setTitle(_('Personen eintragen'))
        ->setExecuteURL(URLHelper::getLink("admin_statusgruppe.php"))
        ->setSearchObject($search_obj)
        ->addQuickfilter(_("Veranstaltungsteilnehmende"), $quickfilter_sem)
        ->addQuickfilter(_("MitarbeiterInnen"), $quickfilter_inst) 
        ->addQuickfilter(_("Personen ohne Gruppe"), $quickfilter_sem_no_group)
        ->render();
        **/
    

?>



<?= LinkButton::createBack(_('Zurück'), $controller->url_for('urlaubskalender/')) ?>
<div id='mitarbeiter'>
    
    
    <form action="<?= $controller->url_for('urlaubskalender/save/') ?>" class="studip_form" method="POST">
        <fieldset>

            <label for="student_search" class="caption">
                <?= _('MitarbeiterIn suchen')?>
                <?= Icon::create('info-circle', 'info', array('title' => $help))?>
            </label>

                <?= $quick_search->render();
            ?>
            <div name="add_username" id="add_username"></div>
            <input type="hidden" name="user_id" value="" id="user_id"></input><br>
            <label> Urlaubsbeginn: </label><input type="" name="begin" value=""></input><br>
            <label> Urlaubsende:</label> <input type="" name="end" value=""></input>
            <label> Hinweis/Notiz:</label> <input type="" name="notice" value=""></input>
        </fieldset>
      
          <?= Button::createAccept(_('Speichern'), 'submit') ?>
          <?= LinkButton::createCancel(_('Abbrechen'), $controller->url_for('urlaubskalender/')) ?>
    </form>
    

</div>


<?php
$sidebar = Sidebar::get();
$sidebar->setImage(Assets::image_path("sidebar/info-sidebar.png"));
?>

<script type="text/javascript">
  
    var select_user = function (user_id, fullname) {
        document.getElementById("add_username").innerHTML = fullname;
        jQuery('#user_id').val(user_id);
        //$(this).closest("form").submit();
    };                                    
</script>