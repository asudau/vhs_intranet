<h1 class="sr-only">
    
</h1>



<? if ($flash['question']): ?>
    <?= $flash['question'] ?>
<? endif; ?>
		
<div class="mitte"><div class="haupttabelle">
			<div class="hauptlinks"></div>
			<div class="rechts">
				<!--<div align="center"><a href="index.php?id=144"><img src="/fileadmin/template/img/suche1.png" alt=""></a></div>
				<!--<div align="center"><a href="index.php?id=146"><img src="/fileadmin/template/img/suche2.png" alt=""></a></div>
				<br>

               	 <!--  CONTENT ELEMENT, uid:73/textpic [begin] -->
                <div id="c73" class="csc-default csc-space-after-25">
                <!--  Image block: [begin] -->
                    <div class="csc-textpic-text">
                <!--  Text: [begin] -->
                    <img src="<?=URLHelper::getLink("plugins_packages/elanev/IntranetMitarbeiterInnen/assets/images/Kursstart.png") ?>" alt="" border="0" width="100%">
                    <h2 class="intranet"><a href="index.php?id=35" title="Opens internal link in current window" class="internal-link">Meine Gruppen/Mein Arbeitsbereich</a></h2>
                    <? foreach ($courses as $course){ ?>
                    <section class="contentbox course">
                        <a href='<?=URLHelper::getLink("/seminar_main.php?auswahl=" . $course['Seminar_id'] )?>'><?= $course['Name'] ?></a></section>
                        
                    <?}
                    
                    if (count($courses) > 6){
                    ?>
                        <a class="all_courses" href="#"></a>
                    <?}

                    ?>
                    <hr>
                    <!--  Text: [end] -->
                    </div>
                    <!--  Image block: [end] -->
                </div>
                <!--  CONTENT ELEMENT, uid:73/textpic [end] -->

                <!--  CONTENT ELEMENT, uid:14/textpic [begin] -->
                <div id="c14" class="csc-default csc-space-after-25">
                <!--  Image block: [begin] -->
                <div class="csc-textpic-text">
                
                <!--  Text: [begin] -->
                    <img src="<?=URLHelper::getLink("plugins_packages/elanev/IntranetMitarbeiterInnen/assets/images/unterlagen1.png") ?>" alt="" border="0" width="100%">
                    <h2 class="intranet"> <a href="index.php?id=21" title="Opens internal link in current window" class="internal-link">Dateien</a>
                    <? if ($mitarbeiter_admin){ ?>
                            <a style="margin-left: 68%;" href="<?=$edit_link_files?>">
                                <img src="/assets/images/icons/blue/edit.svg" alt="add" class="icon-role-clickable icon-shape-add" width="16" height="16">            
                            </a>
                    <? } ?>
                    </h2>
                     
                     <? foreach ($mitarbeiter_folderwithfiles as $folder => $files){ ?>
                    <section class="contentbox folder">
                        <a class='folder_open' href=''><?= $folder ?></a>
                        <? foreach ($files as $file){ ?>
                        <li class='file_download' style="display:none"> <a href='../../../sendfile.php?force_download=1&type=0&file_id=<?= $file['dokument_id']?>&file_name=<?= $file['filename'] ?>'><?= $file['name'] ?></a></li>
                        
                        <?}?>
                        </section>
                    <?}?>
                    <hr>
                <!--  Text: [end] -->
                </div>
                <!--  Image block: [end] -->
                </div>
                <!--  CONTENT ELEMENT, uid:14/textpic [end] -->
                
                <!--  CONTENT ELEMENT, uid:15/textpic [begin] -->
                <div id="c15" class="csc-default csc-space-after-25">
                <!--  Image block: [begin] -->
                <div class="csc-textpic-text">
                
                <!--  Text: [begin] -->
                     <img src="<?=URLHelper::getLink("plugins_packages/elanev/IntranetMitarbeiterInnen/assets/images/luggage-klein.jpg") ?>" alt="" border="0" width="100%">
                     <h2 class="intranet"> <a href="<?=$GLOBALS['ABSOLUTE_URI_STUDIP']. 'plugins.php/IntranetMitarbeiterInnen/urlaubskalender/'?>" title="Opens internal link in current window" class="internal-link">Urlaubskalender</a></h2>
                        <p class="bodytext">
                        </p>
                    
                <!--  Text: [end] -->
                </div>
                <!--  Image block: [end] -->
                </div>
            <!--  CONTENT ELEMENT, uid:15/textpic [end] -->
                
                
				<h4 class="intranet">Unsere Angebote</h4>
				<table class="dsR4" cellspacing="0" cellpadding="0" border="0">
					<tbody><tr>
						<td class="dsR15"><div class="zentriert"><a href="https://www.kvhs-ammerland.de/index.php?id=64" target="_blank"><img src="<?=URLHelper::getLink("plugins_packages/elanev/IntranetMitarbeiterInnen/assets/images/pro_gesellschaft.png") ?>" alt="" border="0" width="73" height="72"><br>
							Gesellschaft</a></div></td>
						<td class="dsR15"><div class="zentriert"><a href="https://www.kvhs-ammerland.de/index.php?id=65" target="_blank"><img src="<?=URLHelper::getLink("plugins_packages/elanev/IntranetMitarbeiterInnen/assets/images/pro_paedagogik.png") ?>" alt="" border="0" width="73" height="72"><br>
						P�dagogik</a></div></td>
						<td class="dsR15"><a href="https://www.kvhs-ammerland.de/index.php?id=66" target="_blank"></a><div class="zentriert"><a href="index.php?id=66"><img src="<?=URLHelper::getLink("plugins_packages/elanev/IntranetMitarbeiterInnen/assets/images/pro_zielgruppen.png") ?>" alt="" border="0" width="73" height="72"><br>
							Zielgruppen</a></div></td>
					</tr>
					<tr>
						<td class="dsR15"><div class="zentriert"><a href="https://www.kvhs-ammerland.de/index.php?id=67" target="_blank"><img src="<?=URLHelper::getLink("plugins_packages/elanev/IntranetMitarbeiterInnen/assets/images/pro_grundbildung.png") ?>" alt="" border="0" width="72" height="72"><br>
							Grundbildung</a></div></td>
						<td class="dsR15"><div class="zentriert"><a href="https://www.kvhs-ammerland.de/index.php?id=68" target="_blank"><img src="<?=URLHelper::getLink("plugins_packages/elanev/IntranetMitarbeiterInnen/assets/images/pro_gesundheit.png") ?>" alt="" border="0" width="73" height="72"><br>
							Gesundheit</a></div></td>
						<td class="dsR15"><div class="zentriert"><a href="https://www.kvhs-ammerland.de/index.php?id=69" target="_blank"><img src="<?=URLHelper::getLink("plugins_packages/elanev/IntranetMitarbeiterInnen/assets/images/pro_beruf.png") ?>" alt="" border="0" width="73" height="72"><br>
							Beruf</a></div></td>
					</tr>
					<tr>
						<td class="dsR15"><div class="zentriert"><a href="https://www.kvhs-ammerland.de/index.php?id=70" target="_blank"><img src="<?=URLHelper::getLink("plugins_packages/elanev/IntranetMitarbeiterInnen/assets/images/pro_sprachen.png") ?>" alt="" border="0" width="73" height="72"><br>
							Sprachen</a></div></td>
						<td class="dsR15"><div class="zentriert"><a href="https://www.kvhs-ammerland.de/index.php?id=71" target="_blank"><img src="<?=URLHelper::getLink("plugins_packages/elanev/IntranetMitarbeiterInnen/assets/images/pro_kultur.png") ?>" alt="" border="0" width="73" height="72"><br>
						Kultur</a></div></td>
						<td class="dsR15"><div class="zentriert"><a href="https://www.kvhs-ammerland.de/index.php?id=4" target="_blank"><img src="<?=URLHelper::getLink("plugins_packages/elanev/IntranetMitarbeiterInnen/assets/images/pro_beruf.png") ?>" alt="" border="0" width="73" height="72"><br>
						Projekte</a></div></td>
					</tr>
				</tbody></table>
				
			</div>
			<div class="haupt">
	       
                
	<!--  CONTENT ELEMENT, uid:434/textpic [begin] -->
		<div id="c434" class="intranet_news csc-default csc-space-after-25">
		<!--  Image block: [begin] -->
			<div class="csc-textpic csc-textpic-intext-right csc-textpic-equalheight"><div class="csc-textpic-text">
		<!--  Text: [begin] -->
            <img src="<?=URLHelper::getLink("plugins_packages/elanev/IntranetMitarbeiterInnen/assets/images/Informationen.png") ?>" alt="" border="0" width="100%">
			<h2 class="intranet">
                    <a href="" title="Opens internal link in current window" class="internal-link">Interne Informationen</a>
                    <? if ($mitarbeiter_admin){ ?>
                    <a style="margin-left: 68%;" href="<?=$edit_link_internnews?>" rel="get_dialog">
                        <img src="/assets/images/icons/blue/add.svg" alt="add" class="icon-role-clickable icon-shape-add" width="16" height="16">            
                    </a>
                    <? } ?>
            </h2>

            <?= $this->render_partial($internnewstemplate, compact('widget')) ?>
            
<hr>
		<!--  Text: [end] -->
			</div></div>
		<!--  Image block: [end] -->
			</div>
	<!--  CONTENT ELEMENT, uid:434/textpic [end] -->
		
	<!--  CONTENT ELEMENT, uid:71/text [begin] -->
		<div id="c71" class="intranet_news csc-default csc-space-after-25">
		<!--  Text: [begin] -->
        <div style="position:relative">
       <img src="<?=URLHelper::getLink("plugins_packages/elanev/IntranetMitarbeiterInnen/assets/images/Projektbereich.png") ?>" alt="" border="0" width="100%">
			<h2 class="intranet"><a href="" title="Opens internal link in current window" class="internal-link">Neues aus dem Projektbereich</a>
                 <? if ($mitarbeiter_admin){ ?>
                    <a style="margin-left: 58%;" href="<?=$edit_link_projectnews?>" rel="get_dialog">
                        <img src="/assets/images/icons/blue/add.svg" alt="add" class="icon-role-clickable icon-shape-add" width="16" height="16">            
                    </a>
                 <? } ?>
            </h2>
        <?= $this->render_partial($projectnewstemplate, compact('widget')) ?>
        <hr>
		<!--  Text: [end] -->
			</div>
    </div>
	<!--  CONTENT ELEMENT, uid:71/text [end] -->
		
    
    <!--  CONTENT ELEMENT, uid:42/textpic [begin] -->
		<div id="c42" class="csc-default csc-space-after-25">
		<!--  Image block: [begin] -->
			<div class="csc-textpic-text">
		<!--  Text: [begin] -->
            <img src="<?=URLHelper::getLink($GLOBALS['ABSOLUTE_URI_STUDIP']. "plugins_packages/elanev/IntranetMitarbeiterInnen/assets/images/schwarzesbrett.png") ?>" alt="" border="0" width="100%">
			<h2 class="intranet"> <a href="<?=URLHelper::getLink("/plugins.php/schwarzesbrettplugin/category")?>" title="" class="internal-link">Schwarzes Brett</a>
                <a style="margin-left: 74%;" data-dialog='' href="<?=URLHelper::getLink($GLOBALS['ABSOLUTE_URI_STUDIP']. "/plugins.php/schwarzesbrettplugin/article/create", array('return_to' => $GLOBALS['ABSOLUTE_URI_STUDIP']. 'plugins.php/IntranetMitarbeiterInnen/start'))?>">
                    <img src="/assets/images/icons/blue/add.svg" alt="add" class="icon-role-clickable icon-shape-add" width="16" height="16">            
                </a>      
            </h2>
                <?php 
                $schwarzesBrett = PluginManager::getInstance()->getPlugin('SchwarzesBrettWidget');
                $template = $schwarzesBrett->getPortalTemplate();
                $template = $schwarzesBrett->getContent();
                $layout = $GLOBALS['template_factory']->open('shared/index_box');
                $layout = NULL;
                echo $template;
                //echo $template->render(NULL, $layout);
                //$layout->clear_attributes();
                ?>
            <hr>
		<!--  Text: [end] -->
			</div>
		<!--  Image block: [end] -->
			</div>
	<!--  CONTENT ELEMENT, uid:42/textpic [end] -->
    
    
    
    
    <? if (false && count($courses_upcoming) >0 ){ ?>
	<!--  CONTENT ELEMENT, uid:13/textpic [begin] -->
		<div id="c13" class="csc-default csc-space-after-25">
		<!--  Image block: [begin] -->
			<div class="csc-textpic-text">
		<!--  Text: [begin] -->
            <img src="<?=URLHelper::getLink("plugins_packages/elanev/IntranetMitarbeiterInnen/assets/images/Kursstart.png") ?>" alt="" border="0" width="100%">
			<h2 class="intranet"> <a href="index.php?id=21" title="Opens internal link in current window" class="internal-link">Kurse, die demn�chst starten</a>
                <? if ($mitarbeiter_admin){ ?>
                    <a style="margin-left: 58%;" href="<?= $this->controller->url_for('start/insertCoursebegin')?>" rel="get_dialog">
                        <img src="/assets/images/icons/blue/add.svg" alt="add" class="icon-role-clickable icon-shape-add" width="16" height="16">            
                    </a>
                 <? } ?>        
            </h2>
            <? foreach ($courses_upcoming as $course){ ?>
                    <section class="contentbox">
                        
                        <? if ($mitarbeiter_admin){ ?>
                            <a href="<?= $this->controller->url_for('start/insertCoursebegin/' . $course['event_id'])?>" rel="get_dialog">
                            <img src="/assets/images/icons/blue/edit.svg" alt="edit" class="icon-role-clickable icon-shape-add" width="16" height="16">            
                            </a>
                        <? } ?>   
                        <a target='_blank'  href='<?= $course['description'] ?>'><?= $course['summary'] ?>  <?= date('d.m.Y', $course['start']) ?></a>
                        
                    </section>
                        
                    <?}?>
            <hr>
		<!--  Text: [end] -->
			</div>
		<!--  Image block: [end] -->
			</div>
	<!--  CONTENT ELEMENT, uid:13/textpic [end] -->
    <? } ?>
    
    
		
		</div></div>
		</div>

<script>
    var courses = 3;
hidecourses = "- zuklappen";
showcourses = "+ Alle Kurse anzeigen";

$(".all_courses").html( showcourses );
$(".course:not(:lt("+courses+"))").hide();

$(".all_courses").click(function (e) {
   e.preventDefault();
       if ($(".course:eq("+courses+")").is(":hidden")) {
           $(".course:hidden").show();
           $(".all_courses").html( hidecourses );
       } else {
           $(".course:not(:lt("+courses+"))").hide();
           $(".all_courses").html( showcourses );
       }
});


$(".folder_open").click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).siblings('.file_download').toggle();
 });
</script>