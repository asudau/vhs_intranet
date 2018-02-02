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



<?= LinkButton::createBack(_('Zur�ck'), $controller->url_for('urlaubskalender/')) ?>
<div id='mitarbeiter'>
    
    
    <form action="<?= $controller->url_for('urlaubskalender/save/') ?>" class="studip_form" method="POST">
        <fieldset>

            <label for="student_search" class="caption">
                <?= _('MitarbeiterIn suchen')?>
                <?= Icon::create('info-circle', 'info', array('title' => $help))?>
            </label>

                <?= $quick_search->render();
            ?>
            <br>
            <h2 name="add_username" id="add_username"></h2>
            <input type="hidden" name="user_id" value="" id="user_id"></input><br>
            <div id='holidays' style="display:none;">
                <label> Urlaubsbeginn: </label>
                <input required type="text" id="beginn" name="begin" data-date-picker='{"<":"#ende"}' value=""></input><br>
                <label> Urlaubsende:</label> <input id="ende" data-date-picker='{">":"#beginn"}' type="" name="end" value="<?= date('d.m.Y', time()) ?>"></input>
                <label> Hinweis/Notiz:</label> <input type="" name="notice" value=""></input>
            </div>
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
        document.getElementById("holidays").style.display = "initial"; 
    };                                    
</script>