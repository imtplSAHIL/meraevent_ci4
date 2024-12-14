<script src="<?php echo $this->config->item('protocol').$_SERVER['HTTP_HOST'].'/js/public/tinymce/tinymce.min.js'; ?>"></script>
<script>
    tinymce.init({
            selector: '#mytextarea', // Replace this with your textarea selector
            content_style: "* { font-size: 15px; font-family:'Tahoma' }",
                plugins: [
                    'autolink lists link charmap preview anchor',
                    'searchreplace visualblocks visualchars code fullscreen',
                    'insertdatetime media save table contextmenu',
                    'paste jbimages  textcolor'
                ],
                toolbar1: 'insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'jbimages |  formatselect | fontselect | fontsizeselect | forecolor backcolor | preview media',
                image_advtab: true,
                relative_urls: false,
                uploadUrl: uploadUrl,
                resize: true,
                setup: function (ed) {
                    ed.on('keyup', function (e) {
						// var tinymceDoc = this.getDoc();
						// $(tinymceDoc).find("article, aside, footer, header, nav, section, div, body, div, span, applet, object, iframe,h1, h2, h3, h4, h5, h6, p, center, dl, dt, dd, ol, ul, li, fieldset, form,label,legend,table, caption, tbody, tfoot, thead, tr, th, td, pre, code").css({'font-size':'16px','font-family':'Trebuchet MS'});
                    //    tinyMCE.triggerSave(); // this seems to trigger the <p>-inserting, whether or not we move back to the bookmark
                  //      $("#mytextarea").valid();
                        // return true;
                    });
                    ed.on('init', function (e) {
						// var tinymceDoc = this.getDoc();
						// $(tinymceDoc).find("article, aside, footer, header, nav, section, div, body, div, span, applet, object, iframe,h1, h2, h3, h4, h5, h6, p, center, dl, dt, dd, ol, ul, li, fieldset, form,label,legend,table, caption, tbody, tfoot, thead, tr, th, td, pre, code").css({'font-size':'16px','font-family':'Trebuchet MS'});
						//$(tinymceDoc).find("p").css();
						//ed.target.editorCommands.execCommand("fontName", false, "Trebuchet MS");
  						//ed.target.editorCommands.execCommand("fontSize", false, "11pt");
						//this.execCommand("fontName", false, "Trebuchet MS");
        				//this.execCommand("fontSize", false, "14px");
						//this.getDoc().p.style.fontFamily = "Trebuchet MS";
						//this.getDoc().p.style.fontSize = '16px';
						if($("#mytextarea").val().length > 0){
							// ed.setContent('<p style="font-family: Trebuchet MS;font-size:16px">'+$("#mytextarea").val()+'</p>');
						}else{
							ed.setContent('<p style="font-family: Tahoma;font-size:15px">&nbsp;</p>');
						}
						
                        // return true;
                    });
                }
          });
</script>
<div class="rightArea">
    <?php if (isset($message)) { ?>
        <div id="personalDetailsMessage" <?php if ($status) { ?>
                 class="db-alert db-alert-success flashHide" <?php } else { ?> 
                 class="db-alert db-alert-danger flashHide" <?php } ?> >
            <strong>&nbsp;&nbsp;  <?php echo $message; ?></strong> 
        </div>
    <?php } ?>
    <div class="heading">
        <h2>Organization Details</h2>
    </div>
    <div class="editFields fs-profile-form">
        <form enctype="multipart/form-data" name="OrganizerDetailsForm" id="personalDetails" method="post" action="" >
            <input type="hidden" id="org_id" name="org_id" value="<?php echo $orgnizerDetails['id']; ?>" class="textfield">
            <label>Organizer Display Name <span class="mandatory">*</span></label>
            <input type="text" id="orgname" name="name" value="<?php echo $orgnizerDetails['name']; ?>" class="textfield">
            <div id="userSuccessMessage"> </div> <div id="userErrorMessage"> </div>
            <label>Url <span class="mandatory"></span><?php
                if (isset($orgnizerDetails['slug'])) {
                    $orgurl = $this->config->item('server_path') . "o/" . $orgnizerDetails['slug'];
                    ?> <span><a href="javascript:void(0)" onClick='copyToClipboard("<?php echo $orgurl; ?>")' style="padding-left: 7px;color: #5f259f;">Copy Link</a></span><?php } ?></label>
            <div class="input-group orgslug">
                <span class="input-group-addon"><?php echo $this->config->item('server_path') . "o/"; ?></span>
                <input type="text" class="form-control slug" name="slug" id='slug' value="<?php echo isset($orgnizerDetails['slug']) ? $orgnizerDetails['slug'] : ''; ?>">
            </div>
            <br>
            <label>organizer promoter Link <span class="mandatory"></span><?php
                if (isset($orgnizerDetails['slug'])) {
                    $orgurl1 = $this->config->item('server_path') . "o/" . $orgnizerDetails['slug'] . "?ucode=organizer";
                    ?> <span><a href="javascript:void(0)" onClick='copyToClipboard("<?php echo $orgurl1; ?>")' style="padding-left: 7px;color: #5f259f;">Copy Link</a></span><?php } ?></label>
            <div class="input-group orgslug">
                <span class="input-group-addon"><?php echo $this->config->item('server_path') . "o/"; ?></span>
                <input type="text" class="form-control slug" id='slug' value="<?php echo isset($orgnizerDetails['slug']) ? $orgnizerDetails['slug'] . "?ucode=organizer" : ''; ?>" readonly="readonly">
            </div>
            <br>
            <label>Domain</label>
            <input type="text" name="domain" value="<?php echo $orgnizerDetails['domain']; ?>" class="textfield">
            <label>Description</label>
          <!--  <textarea class="textarea" name="information"><?php echo $orgnizerDetails['information']; ?></textarea>-->
         <textarea id="mytextarea"  class="form-control eventFields" name="information" ><?php echo $orgnizerDetails['information']; ?></textarea>

            <label>Logo Image</label>
            <input type="file"  name='logopathid' id='logopathid'>
            <br>
            <img src="<?php echo str_replace("/content/content", "/content", $orgnizerDetails['logoPath']); ?>" width="100" height="50"/>
            <br>
            <label>Facebook </label>
            <input type="text" value="<?php echo $orgnizerDetails['facebooklink']; ?>" name="facebooklink" class="textfield">
            <label>Twitter </label>
            <input type="text" value="<?php echo $orgnizerDetails['twitterlink']; ?>" name="twitterlink" class="textfield">
            <label>Linked In </label>
            <input type="text" value="<?php echo $orgnizerDetails['linkedinlink']; ?>" name="linkedinlink" class="textfield">
            <label>Instagram</label>
            <input type="text" value="<?php echo $orgnizerDetails['instagramlink']; ?>" name="instagramlink" class="textfield">
            <label>Seo Title</label>
            <input type="text" name="seotitle" value="<?php echo $orgnizerDetails['seotitle']; ?>" class="textfield">
            <label>Seo Keywords</label>
            <textarea class="textarea" name="seokeywords"><?php echo $orgnizerDetails['seokeywords']; ?></textarea>
            <label>Seo Description</label>
            <textarea class="textarea" name="seodescription"><?php echo $orgnizerDetails['seodescription']; ?></textarea>

            <div class="clearBoth"></div>

            <input type="submit" name="saveType" class="submitBtn createBtn float-right" value="UPDATE"/>
        </form>
    </div>
</div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('cfPath'); ?>css/public/<?php echo 'bootstrap' . $this->config->item('css_gz_extension'); ?>">
<script>
    $('#orgname').on('keyup', function () {
        var title = $.trim(this.value);
        var urlStr = title.replace(/[^A-Za-z0-9\-]/g, ' ');
        urlStr = urlStr.replace(/ /g, '-');
        urlStr = urlStr ? urlStr.replace(/-+/g, '-') : '';
        $('#slug').val(urlStr.toLowerCase());
    });
</script>
