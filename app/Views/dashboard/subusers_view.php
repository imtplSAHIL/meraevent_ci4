<div class="rightArea">
    <?php
    $promoterSuccessMessage = $this->customsession->getData('subUserAdd');
    $this->customsession->unSetData('subUserAdd');
    if ($promoterSuccessMessage) {
        ?>
        <div class="db-alert db-alert-success flashHide">
            <strong>  <?php echo $promoterSuccessMessage; ?></strong>
        </div>
    <?php } ?>
    <div class="heading" >
        <h2>Sub Users</h2>
    </div>
    <div class="float-right form-group"> <a href="<?php echo commonHelperGetPageUrl('dashboard-sub-user-add'); ?>" class="createBtn float-left font14"><span class="icon-add pinkBg"></span>Add Sub User</a> </div>
    <div style="clear: both"></div>
    <div class="PromoterView">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" data-tablesaw-minimap>
            <thead>
                <tr>
                    <th scope="col" data-tablesaw-priority="5">User Name</th>
                    <th scope="col" data-tablesaw-priority="5">Email</th>
                    <th scope="col" data-tablesaw-priority="5">Company</th>
                    <th scope="col" data-tablesaw-priority="5">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($sub_user_details)) {
                    foreach ($sub_user_details as $sub_user) {
                        ?>
                        <tr>
                            <td><?php echo $sub_user['name']; ?></td>
                            <td><?php echo $sub_user['email']; ?></td>
                            <td><?php echo $sub_user['company']; ?></td>
                            <td>
                                <?php
                                $className = 'greenBtn';
                                $buttonValue = 'Active';
                                $status = 0;

                                if ($sub_user_ids[$sub_user['id']] == 0) {
                                    $className = 'orangrBtn';
                                    $buttonValue = 'Inactive';
                                    $status = 1;
                                }
                                ?>
                                <button subuserId='<?php echo $sub_user['id']; ?>' subuserStatus='<?php echo $status; ?>' type="button" class="status btn <?php echo $className; ?>"><?php echo $buttonValue; ?></button>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="7">There are no sub users</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.status').on('click', function () {
            var currentElement = this;
            $(currentElement).prop('disabled', true);
            var input = 'subuserid=' + $(this).attr('subuserId') + '&status=' + $(this).attr('subuserStatus');
            var pageUrl = '<?php echo commonHelperGetPageUrl('api_subUserUpdateStatus');?>';
            var method = 'POST';
            var dataFormat = 'JSON';
            function callbackSuccess(result) {
                if (result.response.total > 0) {
                    if (result.response.updatesubuserResponse.value == 1) {
                        $(currentElement).text('active');
                        $(currentElement).removeClass('orangrBtn');
                        $(currentElement).addClass('greenBtn');
                        $(currentElement).attr('subuserStatus', 0);
                    } else {
                        $(currentElement).text('inactive');
                        $(currentElement).removeClass('greenBtn');
                        $(currentElement).addClass('orangrBtn');
                        $(currentElement).attr('subuserStatus', 1);
                    }
                }
                $(currentElement).prop('disabled', false);
            }
            function callbackFailure(result) {
                alert(result.responseJSON.response.messages.message[0]);
                $(currentElement).prop('disabled', false);
            }
            getPageResponse(pageUrl, method, input, dataFormat, callbackSuccess, callbackFailure);
        });
    });
</script>
