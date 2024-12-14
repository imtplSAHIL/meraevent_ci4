<script>
<?php  if ($this->session->flashdata('message')) {  ?>
        var return_message = "<?php echo $this->session->flashdata('message'); ?>";
<?php } ?>
    var message = "<?php echo $message; ?>";
    var organizer_mobile = "<?php echo $org_mobile; ?>";
</script>
<style>
    .form-control {
        height: 40px;
    }
    .error {
        color: #ff0404 !important;
    }
    .orgslug label{
        position: absolute;
        z-index: 9;
        top: 38px;
    }
    .btn-holder input{
        float: left;
    }
   
</style>
<div class="rightArea AccountManagerHolder">
    <?php
    if ($this->session->flashdata('message')) {
        echo "<div class='db-alert db-alert-success flashHide'>" . $this->session->flashdata('message') . "</div>";
    }
   
    ?>
    <div class="heading"><h2>Organizer Profile</h2></div>
    <div class="loginBlog">
        <div class="editFields fs-add-promoter-form">
             <input  type="hidden" value="><?php echo $this->config->item('server_path')."o/";?>" class="sever_url">
             <form enctype="multipart/form-data" method="post" name="addOrgForm" id="addOrganizerForm" action=''>
                 <input type="hidden" name="id" id="orgId" value="<?php echo isset($orgDetails['id'])?$orgDetails['id']:'';?>">
                <label>Organizer Display Name <span class="mandatory">*</span></label>
                <input type="text" class="textfield" name='name' id='orgName' value="<?php echo isset($orgDetails['name'])?$orgDetails['name']:'';?>">
                
                
                <label>Url <span class="mandatory">*</span><?php if(isset($orgDetails['slug'])){ $orgurl = $this->config->item('server_path')."o/".$orgDetails['slug']; ?> <span><a href="javascript:void(0)" onClick='copyToClipboard("<?php echo $orgurl;?>")' style="padding-left: 7px;color: #5f259f;">Copy Link</a></span><?php } ?></label>
                <div class="input-group orgslug">
                    <span class="input-group-addon"><?php echo  $this->config->item('server_path')."o/"; ?></span>
                    <input type="text" class="form-control slug" name='slug' id='slug' value="<?php echo isset($orgDetails['slug'])? $orgDetails['slug']:'';?>">
                </div>
                 <span style="color: red; display:none" id="slug_avaliable">Slug already exists</span>
                
                
                <label style="padding-top:15px;">Description <span class="mandatory">*</span></label>
                <textarea rows="4" cols="50" name="information" class="textfield form-control" id='orgDescription'><?php echo isset($orgDetails['information'])?$orgDetails['information']:'';?></textarea>
                <label>Banner Upload<span class="mandatory">*</span></label>
                <input type="file" class="textfield" name='bannerpathid' id="bannerid">
                <?php if($orgDetails['bannerImage']){?>
                <img src="<?php echo $this->config->item('images_cloud_path').$orgDetails['bannerImage']; ?>" width="40" height="40" />
                <?php }?>
                
                <label>Seo Title</label>
                <input type="text" class="textfield form-control " name='seotitle' id='seotitle' value="<?php echo isset($orgDetails['seotitle'])?$orgDetails['seotitle']:'';?>">
             
                 <label>Seo Keywords </label>
                <textarea rows="4" cols="50" name="seokeywords" class="textfield form-control " id='seokeywords'><?php echo isset($orgDetails['seokeywords'])?$orgDetails['seokeywords']:'';?></textarea>
                
                <label style="margin-top:15px;">Seo Description </label>
                <textarea rows="4" cols="50" name="seodescription" class="textfield form-control " id='seodescription'><?php echo isset($orgDetails['seodescription'])?$orgDetails['seodescription']:'';?></textarea>
                
                <div id='codeError' class='error'></div>
                <div class="clearBoth"></div>
                <div class="btn-holder float-right">
                    <input name="submit" type="submit" id="orgButton" class="createBtn" value="Save">
                    <a href="<?php echo commonHelperGetPageUrl("organizerProfileindex"); ?>">
                        <span class="saveBtn">Cancel</span> 
                    </a>
                </div>
            </form> 
        </div>
    </div>
</div>
<style>
    .modal{
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1050;
        background-color: rgba(136, 136, 136, 0.4);
    }
</style>
