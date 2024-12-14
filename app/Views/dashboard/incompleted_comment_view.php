<div class="rightArea">
    <div class="fs-form">
        <h2 class="fs-box-title"><?php echo $pageTitle;?></h2>
        <div class="editFields">
            <?php if (isset($error)) { ?>
                <div id="flashMessage" class="db-alert db-alert-danger flashHide"> <?php echo $error[0]; ?>
                </div>
            <?php } else { ?>
                <div id="flashMessage" class="db-alert flashHide" style="display:none"> 
                </div>
                <form name="customfields" id="customfields" method="post" action="" class="ticketTransferFlags">
                    <input type="hidden" name="eventId" value ="<?php echo $eventId; ?>" id="eventId"/>
                    <input type="hidden" name="eventsignupId" value ="<?php echo $eventsignupId; ?>" id="eventsignupId"/>
                    
                    <label>Oranizer Comment</label>
                    <textarea class="textarea" name="comment" rows="10"></textarea>
                    <div class="fs-custom-field-buttons float-right">
                       
                        <input  type="submit" name="stagedstatus" class="createBtn" value="save"/>
                        <a href="<?php echo commonHelperGetPageUrl('dashboard-transaction-report') . '/' . $eventId . '/summary/incomplete/1'; ?>">
                            <button type="button" class="saveBtn">cancel</button>
                        </a>
                    </div>
                </form>
<?php } ?>
        </div>
    </div>    
</div>
<script>
var loadUtilsUrl = '<?php echo $this->config->item('cfPath'); ?>js/public/<?php echo 'utils'.$this->config->item('js_gz_extension'); ?>';
    $.fn.intlTelInput.loadUtils(loadUtilsUrl);
    $(".mobileNoFlags").intlTelInput({
        autoPlaceholder: "off",
        separateDialCode: true,
    }); 

    var api_updateCFData = '<?php echo commonHelperGetPageUrl('api_updateOrgCommentData'); ?>';
    var api_countrySearch = "<?php echo commonHelperGetPageUrl('api_countrySearch') ?>";
    var api_stateSearch = "<?php echo commonHelperGetPageUrl('api_stateSearch') ?>";
    var api_citySearch = "<?php echo commonHelperGetPageUrl('api_citySearch') ?>";
    var api_dashboardtransaction = "<?php echo commonHelperGetPageUrl('dashboard-transaction-report') ?>";
</script>

<script>
    window.onload = function (e){
        setCountryFlag('mobileNoFlags','class');
    }

</script>