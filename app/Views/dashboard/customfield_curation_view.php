<style>
	.box2 {
		float: left;
		height: 260px !important;
		margin-right: 2%;
		width: 49% !important;
	}
	.nomargin{ 
  		margin-right: 0% !important;
	}
</style>


<div class="rightArea">
     <?php  
        $curationFlashMessage=$this->customsession->getData('curationSuccessMessage');
        $this->customsession->unSetData('curationSuccessMessage');
    	if($curationFlashMessage){ ?>
        <div class="db-alert db-alert-success">
            <strong>  <?php echo $curationFlashMessage; ?></strong> 
        </div>
    	<?php }
		
		 $curationErrorMessage=$this->customsession->getData('curationErrorMessage');
        $this->customsession->unSetData('curationErrorMessage');
    	if($curationErrorMessage){ ?>
        <div class="db-alert db-alert-danger">
            <strong>  <?php echo $curationErrorMessage; ?></strong> 
        </div>
    	<?php }
		
		?>   
                 
		<div class="db-alert db-alert-success flashHide" id="successMsg" style="display:none; font-weight:bold;"></div>
        <div class="db-alert db-alert-danger flashHide" id="errorMsg" style="display:none; font-weight:bold;"></div>		 
		 
     
    <?php
    if(isset($error)){
			?><div id="Message" class="db-alert db-alert-danger"><strong><?php echo $error; ?></strong></div><?php
		}else{
			?>
            
            <div class="clearBoth"></div>
            <div class="heading">
                    <h2>CUSTOM FIELD CURATION for : <?php echo  $eventName;?></h2>
                    <p style="font-size:14px; line-height: normal; margin-bottom:10px;">
                       We are accepting only CSV (Comma Delimited) files to use this page. Download the <a href="<?php echo $this->config->item('images_content_path'); ?>demos/custom-field-curation-sample.csv">Sample </a>file here. Uploaded file must have only one column (rest will be ignored), and we will process only first 100 rows (excluding header) in CSV file, and ignores rest all if any. And make sure, <b style="color:#F00">there should not be any duplicate values</b> in the current CSV file or with existing values in database and each value minimum length is four charecters.
                    </p>
                    
                    
                    
                    <div class="float-left" style="width:80%">
                    	<h2 style="color:#6EDB20">Custom Field : <?php echo $customFieldname; ?> <?php if($cflevel == 'ticket'){ echo "{".$CfTicketName."}";} ?></h2>
                    </div>
                    
                    <div class="float-right" style="width:20%;">
                    	<a style="text-align:right;" id="add_custom_field" class="createBtn float-left font14" href="<?php echo commonHelperGetPageUrl('dashboard-customField', $this->input->get('eventId')); ?>"><span class="icon2-upload"></span>&nbsp;Back To Custom Fields</a>
                    </div>
                    <div class="clearBoth"></div>
                    
                    <!--error/succ message box-->
                    <!--<div id="Message" class="db-alert db-alert-danger"><strong> only CSV files to use this page. Download </strong></div>-->
                    
                </div>
            <div class="clearBoth"></div>
            
            <div class="graphSec">
                
            
                <div class="Box1 box2">
                    <div class="fixedBox">
                        <h2>Upload bulk Values</h2>
                        <div class="fs-Box1-content">
                            <div class="editFields">
                                <form enctype="multipart/form-data" method="post" name="cfCurationUploadForm" id="cfCurationUploadForm" action=''>
                             		
                                    
                                    <div class="clearBoth"></div>
                        			
                                    <label>CSV File <span class="mandatory">*</span></label>
                                    <input type="file" name="csvfile" id="csvfile" class="textfield">
                                    <input type="hidden" id="eventid" value="<?php echo $eventId; ?>" />
                                    <input type="hidden" id="customFieldId" value="<?php echo $customFieldId; ?>" />
                                    <input type="hidden" name="curationForm" value="uploadCuration" />
                                    <input type="submit" name="cfCuration" id="cfCuration" class="createBtn float-right" value="Upload"/>
                                </form>
                            </div>
                        </div><!-- end of fs-Box1-content -->
                    </div>
                </div>
                
                
                <div class="Box1 box2 nomargin">
                    <div class="fixedBox">
                        <h2>Add/Edit Value</h2>
                        <div class="fs-Box1-content">
                            <div class="editFields">
                                <form enctype="multipart/form-data" method="post" name="cfCurationValueForm" id="cfCurationValueForm" action=''>
                             
                                    <div class="clearBoth"></div>
                        
                                    <label>Value <span class="mandatory">*</span></label>
                                    <input type="hidden" name="curationValueFormType" id="curationValueFormType" value="curationValueAdd" class="textfield">
                                    <input type="hidden" name="curationValueRid" id="curationValueRid" value="" class="textfield">
                                    <input type="text" name="curationvalue" id="curationvalue" class="textfield">
                                    <input type="submit" name="cfCurationSubmit" id="cfCurationSubmit" class="createBtn float-right" value="Add"/>
                                </form>
                            </div>
                        </div><!-- end of fs-Box1-content -->
                    </div>
                </div>
                
                
               
                <div class="fixedBox" style="width: 100% ! important; height: auto ! important;background:#fff; padding-bottom:40px;">
                    <div class="fixedBox">
                        <h2 style=" background-color: #8666cd; color: #fff;padding: 10px 20px; text-transform: uppercase;">Curation List</h2>
                        
                        <div style="padding: 20px 20px 0px;">
                        	<form method="post" action="" id="curationSearchForm" name="curationSearchForm">  
  							<input type="text" class="textfield2" style="width:85% !important;" placeholder="Search . . ." id="curationSearchKey" name="curationSearchKey" value="<?php echo $searchString; ?>">
                            <input type="hidden" name="curationForm" value="searchCuration" />
                            <button type="submit" class="createBtn" style="padding: 5px; width: 150px; background: #fdda24 none repeat scroll 0 0; color: #333;">Search</button>
                            <p id="curationSearchErr"></p>
                            <?php if(strlen($searchString) > 0){ ?><p style="color:#C6992F;">Search results for : <b style="color:#930"><?php echo $searchString; ?></b>. &nbsp;&nbsp; Click <a href="javascript:void(0)" id="searchReload" style="color:#900; font-weight:bold">here</a> to reset the results.</p> <?php } ?>  
                            </form> 
						</div>
                        
                        
                        <div class="sales salesefforts" style="margin-left: 10px;width: 97%;">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                        <thead>
                            <tr>
                                <th scope="col" data-tablesaw-priority="persist">Value</th>
                                <th scope="col" data-tablesaw-priority="persist">Status</th>
                                <th scope="col" data-tablesaw-priority="persist">Added On</th>
                                <th scope="col" data-tablesaw-priority="persist">Actions</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php
                            if($curationValues > 0){
                                foreach($curationValues as $value){
                                    ?>
                                    <tr id="cvTr<?php echo $value['id']; ?>">
                                        <td><?php echo $value['value']; ?></td>
                                        <td><?php echo ($value['status'] == 1)?"Booked":"Not Booked"; ?></td>
                                        <td><?php echo $value['cts']; ?></td>
                                        <td>
                                        <?php
										if($value['status'] == 0){
											?>
                                        	<a href="javascript:void(0)" rev="<?php echo $eventId; ?>" id="<?php echo $customFieldId; ?>" class="editCurationValue" rel="<?php echo $value['id']; ?>"><span title="Edit" id="<?php echo $value['value']; ?>" class="icon-edit"></span></a>
                                            <a href="javascript:void(0)" rev="<?php echo $eventId; ?>" id="<?php echo $customFieldId; ?>" class="deleteCurationValue" rel="<?php echo $value['id']; ?>"><span title="Delete" id="<?php echo $value['id']; ?>" class="icon-delete"></span></a>
                                            <?php
										}
										?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                
                            }else{
                                ?><tr><td colspan="4"><div id="Message" class="db-alert db-alert-danger"><strong>Sorry, No records found.</strong></div></td></tr><?php
                            }
                        
                            ?>
                        </tbody>
                    </table>
                     <?php if(count($curationValues)>0){?>
                            <!--<div style="float:right;">
                            <span id="sendsuccess" style="float: left; padding: 20px 10px 0 0;"></span>
                            <a href="javascript:;" class="submitBtn createBtn float-right"  id="send_ticketslist" style="margin:20px 5px;   float: right;">Send Email</a>
                            </div>-->
                            <?php }?>
                        </div><!-- end of fs-Box1-content -->
                    </div>
        		</div>
        
                       
            
            </div>  
            <!--end-->  
                
                 
                
            
            <!--Data Section Start-->
        
            
            
            
            <!--existing records-->
            <div class="clearBoth"><br /><br /></div>
            
            
            
            
            
            
        </div>
        </div>
            <?php
		}
		?>

<script>
var api_deleteCurationValue = "<?php echo commonHelperGetPageUrl('api_deleteCurationValue');?>";
var api_addCurationValue = "<?php echo commonHelperGetPageUrl('api_addCurationValue');?>";
var api_updateCurationValue = "<?php echo commonHelperGetPageUrl('api_updateCurationValue');?>";
</script>