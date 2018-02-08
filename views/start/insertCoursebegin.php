
<? use Studip\Button, Studip\LinkButton; ?>



<form data-dialog="" method="post" action="<?= $controller->url_for('start/insertCoursebegin/' . $event->event_id) ?>">
       <fieldset>
             
    <label> <?= _('Datum') ?>:</label><br>
    <input type="text" name="start_date" id="start-date" value="<?= strftime('%x', $event->start) ?>" required><br>
     <label> Kurstitel: </label><br>
     <input type="text" name="summary" id="summary" value="<?= htmlReady($event->summary) ?>"><br>
      <label> Link zum Kurs: </label><br>
      <textarea cols="40" id="description" name="description"><?= htmlReady($event->description) ?></textarea><br>
       <div style="text-align: center;" data-dialog-button>
            <?= Button::createAccept(_('Speichern'), 'submit') ?> 
           </div>
</fieldset>
</form>

<script>
    jQuery('#start-date').datepicker();
</script>
