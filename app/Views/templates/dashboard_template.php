<?php  $this->load->view('includes/header');
            if(isset($hideLeftMenu) && $hideLeftMenu!=1) {
	    ?><div class="container"><?php
		$this->load->view('dashboard/left_menu.php');
		
	}else if(isset($hideLeftMenu) && $hideLeftMenu == 1) {
            ?><div class="container"><?php
		$this->load->view('promoter/left_menu.php');
        }
    $this->load->view('dashboard/'.$content);
	if(isset($hideLeftMenu) && $hideLeftMenu!=1) {
	?></div>  <?php
	}else if(isset($hideLeftMenu) && $hideLeftMenu == 1) {
	?></div>  <?php
	}
    ?>
<?php 
    $viewPageName = $this->uri->segment(1);
    $pageName = $this->uri->segment(2);
    $viewpage = $this->uri->segment(3);
?>
</div><!-- wrap div -->
<script>
var api_promotesetStatus = "<?php echo commonHelperGetPageUrl('api_promotesetStatus')?>";
var api_dashboardEventchangeStatus = '<?php echo commonHelperGetPageUrl('api_dashboardEventchangeStatus');?>';
var api_reportsDownloadImages = '<?php echo commonHelperGetPageUrl('api_reportsDownloadImages');?>';
var api_reportsGetReportDetails = "<?php echo commonHelperGetPageUrl('api_reportsGetReportDetails')?>";
var api_reportsExportTransactions = '<?php echo commonHelperGetPageUrl('api_reportsExportTransactions');?>';
var api_reportsEmailTransactions = '<?php echo commonHelperGetPageUrl('api_reportsEmailTransactions');?>';
var url_dashboardReports = '<?php echo commonHelperGetPageUrl('url_dashboardReports');?>';
var url_apiTransactions = '<?php echo commonHelperGetPageUrl('apiTransactions');?>';
var api_apiTransactions = '<?php echo commonHelperGetPageUrl('api_apiTransactions');?>';
var api_collaboratorAdd = '<?php echo commonHelperGetPageUrl('api_collaboratorAdd');?>';
var api_collaboratorUpdateStatus = '<?php echo commonHelperGetPageUrl('api_collaboratorUpdateStatus');?>';
var api_collaboratorUpdate = '<?php echo commonHelperGetPageUrl('api_collaboratorUpdate');?>';
var api_getEvents='<?php echo commonHelperGetPageUrl('api_getEvents');?>';
var api_copyEvent='<?php echo commonHelperGetPageUrl('api_copyEvent');?>';
var api_deleteEvent='<?php echo commonHelperGetPageUrl('api_deleteEvent');?>';
var sendemailtopastatturl='<?php echo commonHelperGetPageUrl('sendemailtopastattendees');?>';
var url_createevent='<?php echo commonHelperGetPageUrl('create-event');?>';
</script>
<?php
if (isset($hideLeftMenu) && $hideLeftMenu != 1) {
    ?>
    <!-- <link rel="stylesheet" type="text/css" href="cssmenu.css"> -->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('css_public_path').'common'.$this->config->item('css_gz_extension'); ?>">
    <!-- <script src="<?php //echo $this->config->item('js_public_path'); ?>dashboard/cssmenu.js"></script> -->
    <script src="<?php echo $this->config->item('js_public_path').'dashboard/fs-match-height'.$this->config->item('js_gz_extension');  ?>"></script>
    <script src="<?php echo $this->config->item('js_public_path').'dashboard/table-saw'.$this->config->item('js_gz_extension');  ?>"></script>
    <script src="<?php echo $this->config->item('js_public_path').'dashboard/customscripts'.$this->config->item('js_gz_extension');  ?>"></script>
    <script src="<?php echo $this->config->item('js_public_path').'dashboard/main'.$this->config->item('js_gz_extension');  ?>"></script>

<?php
} else {
    ?>
<!--    <link href="<?php echo $this->config->item('css_public_path').'me-iconfont'. $this->config->item('css_gz_extension'); ?>" rel="stylesheet" type="text/css">-->
    <script src="<?php echo $this->config->item('js_public_path').'tabcontent'.$this->config->item('js_gz_extension'); ?>"></script>
    <script src="<?php echo $this->config->item('js_public_path').'dashboard/main'. $this->config->item('js_gz_extension'); ?>"></script>



    <?php
}
?>
<script src="<?php echo $this->config->item('js_public_path').'common'.$this->config->item('js_gz_extension'); ?>"></script>
 
<?php

if (isset($jsArray) && is_array($jsArray)) {
    foreach ($jsArray as $js) {
        echo '<script src="' . $js .$this->config->item('js_gz_extension'). '"></script>';
        echo "\n";
    }
}
?>
 <?php if($viewpage != "updateTemplate" ) {?>
<script src="<?php echo $this->config->item('js_public_path').'dashboard/fs-custom'.$this->config->item('js_gz_extension');  ?>"></script>
 <?php }?>
<script>
// $('#user-toggle').click( function(event){
//        event.stopPropagation();
//        $("#helpdropdown-menu").hide();
//        $('#dropdown-menu').toggle();
//    });
//    $("#help-toggle").click(function () {
//		event.stopPropagation();
//		$('#dropdown-menu').hide();
//        $("#helpdropdown-menu").toggle();
//    });
</script>

<script type="text/javascript">
    <?php if($pageName == "customtemplate" && $viewpage == "updateTemplate" ) {?>
            setTimeout(function () {
                        tinymce.init({
                            selector: "textarea",
                            menubar:false,
                                            /*content_style: "div, p { font-size: 15px; font-family:'Trebuchet MS' }",*/
                            plugins: [
                                'advlist autolink lists link',
                                'searchreplace visualblocks visualchars code fullscreen',
                                //'insertdatetime media save table contextmenu',
                                'paste jbimages  textcolor'
                            ],
                            toolbar1: 'insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',
                            toolbar2: 'jbimages |  formatselect | fontselect | fontsizeselect | forecolor backcolor | print preview media',
                            image_advtab: true,
                            relative_urls: false,
                            uploadUrl: uploadUrl,
                            resize: false,
                            setup: function (ed) {
                                ed.on('keyup', function (e) {
                                                            var tinymceDoc = this.getDoc();
                                                            $(tinymceDoc).find("article, aside, footer, header, nav, section, div, body, div, span, applet, object, iframe,h1, h2, h3, h4, h5, h6, p, center, dl, dt, dd, ol, ul, li, fieldset, form,label,legend,table, caption, tbody, tfoot, thead, tr, th, td, pre, code").css({'font-size':'16px','font-family':'Trebuchet MS'});
                                    tinyMCE.triggerSave(); // this seems to trigger the <p>-inserting, whether or not we move back to the bookmark
                                    $("#event-desc").valid();
                                    // return true;
                                });
                                ed.on('init', function (e) {
                                                            var tinymceDoc = this.getDoc();
                                                            $(tinymceDoc).find("article, aside, footer, header, nav, section, div, body, div, span, applet, object, iframe,h1, h2, h3, h4, h5, h6, p, center, dl, dt, dd, ol, ul, li, fieldset, form,label,legend,table, caption, tbody, tfoot, thead, tr, th, td, pre, code").css({'font-size':'16px','font-family':'Trebuchet MS'});
                                                            //$(tinymceDoc).find("p").css();
                                                            //ed.target.editorCommands.execCommand("fontName", false, "Trebuchet MS");
                                                            //ed.target.editorCommands.execCommand("fontSize", false, "11pt");
                                                            //this.execCommand("fontName", false, "Trebuchet MS");
                                                    //this.execCommand("fontSize", false, "14px");
                                                            //this.getDoc().p.style.fontFamily = "Trebuchet MS";
                                                            //this.getDoc().p.style.fontSize = '16px';
                                                            if($("#event-desc").val().length > 0){
                                                                    //ed.setContent('<p style="font-family: Trebuchet MS;font-size:16px">'+$("#event-desc").val()+'</p>');
                                                            }else{
                                                                    ed.setContent('<p><span style="font-family: Trebuchet MS;font-size:16px">&nbsp;</span></p>');
                                                            }

                                    // return true;
                                });
                            }
                        });
                    }, 1000);
    <?php }?>

</script>
</body>
</html>

