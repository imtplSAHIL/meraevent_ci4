<div class="rightArea">
    <?php
    $collaboratorAddedMessage = $this->customsession->getData('collaborateAddFlashMessage');
    $this->customsession->unSetData('collaborateAddFlashMessage');
    $collaborateEditedFlashMessage = $this->customsession->getData('collaborateEditedFlashMessage');
    $this->customsession->unSetData('collaborateEditedFlashMessage');
    if ($collaboratorAddedMessage) {
        ?>
        <div  class="db-alert db-alert-success flashHide">
            <strong><?php echo $collaboratorAddedMessage; ?></strong> 
        </div>
    <?php  }?>
    <?php if ($collaborateEditedFlashMessage) { ?>
            <div  class="db-alert db-alert-success flashHide">
                <strong>  <?php echo $collaborateEditedFlashMessage; ?></strong> 
            </div>
    <?php } ?>
        <div class="heading float-left">
            <h2>Collaborators List: <span><?php echo $eventTitle; ?></span></h2>
        </div>
        <div class="clearBoth"></div>
        <div class="float-right"> <a href="<?php echo commonHelperGetPageUrl('dashboard-add-collaborator', $eventId); ?>" class="createBtn float-left font14"><span class="icon-add pinkBg"></span>Add New Collaborator</a> </div>
        <div class="clearBoth"></div>
        <input type="hidden" name="eventId" id="eventId" value="<?php echo $eventId; ?>"/>
        <div class="tablefields">
            <table width="100%" border="0" cellspacing="0" cellpadding="0"  data-tablesaw-minimap>
                <thead>
                    <tr>
                        <th scope="col" data-tablesaw-priority="persist">Collaborator Name</th>
                        <th scope="col" data-tablesaw-priority="3">Email</th>
                        <th scope="col" data-tablesaw-priority="3">Modules</th>
                        <th scope="col" data-tablesaw-priority="3">Current Status</th>
                        <th scope="col" data-tablesaw-priority="3">Action</th>
                           <th scope="col" data-tablesaw-priority="3">Resend Email</th>
                           <th scope="col" data-tablesaw-priority="3">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($errors)) { ?> 
                        <tr> 
                            <td colspan="7">
                                 <div class="db-alert db-alert-info">                    
                                    <strong><?php echo $errors[0]; ?></strong> 
                                </div>
                                
                            </td> 
                        </tr>
                        <?php
                    } else {
                        foreach ($collaboratorList as $value) {
                            ?>
                            <tr>
                                <td><?php echo $value['name']; ?></td>
                                <td><?php echo $value['email']; ?></td>
                                <td><?php
                                    $data = '';
                                    $modules = explode(',', $value['modules']);
                                    foreach ($modules as $key => $value1) {
                                        $data.=($key + 1) . '.' . ucfirst($value1) . '<br/>';
                                        $key++;
                                    }
                                    echo $data;
                                    ?></td>
                                <td><?php
                                    $className = 'greenBtn';
                                    $buttonValue = 'Active';

                                    if ($value['status'] == 0) {
                                        $className = 'orangrBtn';
                                        $buttonValue = 'Inactive';
                                    }
                                    ?>
                                    <button <?php echo 'collaboratorId=' . $value['id']; ?> type="button" class="status btn <?php echo $className; ?>"><?php echo $buttonValue; ?></button></td>
                                <td><a href="<?php echo commonHelperGetPageUrl('dashboard-edit-collaborator', $eventId . '&' . $value['id']); ?>"><span class="icon-edit"></span></span></td>
                                    <td>
                                    
                                    <a title = "Resend Email" class="collabResendEmail" data-collaboratartemail="<?php echo $value['email']; ?>" data-username="<?php echo $value['name']; ?>" href="javascript:void()"><span id="resendCollaboratorEmailSuccessMessage<?php echo $value['id']; ?>" ></span>
                                        <span style="float:inline" class ="icon-mail"></span>
                                    </a>
                                    </td>
                                    <td>
                                    <a title = "Delete Email" class="collabDelete" data-email="<?php echo $value['email']; ?>" data-username="<?php echo $value['name']; ?>" href="javascript:void()"><span id="deleteCollaborator<?php echo $value['id']; ?>" ></span>
                                        <span style="float:inline" class ="icon-delete"></span>
                                    </a>
                                    </td>
                            </tr>
                        <?php }
                    } ?>

            </tbody>
        </table>
    </div>
</div>

<?php if(isset($value['id'])){?>
        <input type="hidden" name="custIds" id="custIds" value="<?php echo json_encode($value['id']) ?>" />
    <?php }?>

    <script>
            var collaboratorResendEmail = "<?php echo commonHelperGetPageUrl("api_collaboratorResendEmail"); ?>";
            var staged = "<?php echo ($eventSettings['stagedevent'] == 1) ? 1 : 0 ?>";
            var collaboratorDelete = "<?php echo commonHelperGetPageUrl("api_deleteCollaboratorEmail"); ?>";
        </script>

<script>
       $(document).on('click','.collabDelete',function(e){
       //var eventsignupId = $(this).attr('value');
       //console.log(collabDelete);
       var eventId = $("#eventId").val();
       //alert(eventId);
       var email =  $(this).data("email");
       var userName= $(this).data("username");
       //alert(userName);
       var data = {email:email, eventid:eventId, username:userName};
       $.ajax({
               type:'post',
               url: collaboratorDelete,
               data:data,
               cache:false,
               success:function(res){
                    if(res.response.isDeleted == 1){
                        location.reload();
                        alert('Deleted succesfully');
                    }
               },
               error:function(res){
                    alert("Something went wrong. Please try again");
               },
        });
});
</script>
