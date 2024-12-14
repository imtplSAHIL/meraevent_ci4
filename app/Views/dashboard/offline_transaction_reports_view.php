<!--Right Content Area Start-->
<div class="rightArea">
    <form action='' method="POST" />
    <div class="heading">
        <h2>Offline Pending Transactions</h2>
    </div>


    <!--Data Section Start-->
    <input type="hidden" name="eventId" id="eventId" value="<?php echo $eventId; ?>"/>
    <div class="clearBoth"></div>
    <div class="fs-export-email fs-export-reports-special">
        <button type="button" class="Btn blueborder" name="exportOfflinePendingReports" id="exportOfflinePendingReports"><span class="icon-export"></span>Export</button>
    </div>

    <!--Curation Events Buttons-->
    <div class="refundSec bottomAdjust100" >   
        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="transactionTable" class="transactionTable">
            <thead>
            <tr>
                <?php foreach ($headerFields as $value) {
                    ?>
                    <th scope="col" data-tablesaw-priority="2"><?php echo $value; ?></th>
                <?php } ?>
            </tr>
            </tr>
            </thead>
            <tbody>
            <?php   
                $i = 1;
         foreach($transactionList as $transactions){
             ?>
        <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $transactions['org_name']; ?></td>
                        <td><?php echo $transactions['first_name']. ' '.$transactions['last_name'] ; ?></td>
                        <td><?php echo $transactions['email_id']; ?></td>
                        <td><?php echo $transactions['mobile']; ?></td>
                        <td><?php echo $transactions['quantity']; ?></td>
                        <td><?php echo $transactions['totalamount']; ?></td>
                        <td><?php echo $transactions['invoice_number']; ?></td>
                        <td><a target="_blank" href='<?php echo commonHelperGetPageUrl('dashboard-download-profarma-invoice', $transactions['eventsignupid']);?>' >Download</a></td>
                        <td>
                            
                        <?php
                            if($transactions['raise_tax_invoice'] == 1) {
                                ?>
                            <a target="_blank" href='<?php echo commonHelperGetPageUrl('dashboard-download-tax-invoice', $transactions['eventsignupid']);?>' >Download </a>
                        
                            <?php
                            }
                            else
                            {
                                echo "Download";
                            }
                            ?>

                        </td>

                        <td>
                            <a target="_blank" href='<?php echo commonHelperGetPageUrl('dashboard-email-profarma-invoice', $transactions['eventsignupid']);?>' > Email Proforma Invoice</a> <br /><br />
                            <a href='<?php echo commonHelperGetPageUrl('dashboard-edit-offline-purchaser', $transactions['eventsignupid']);?>' title="Edit Details" >Edit invoice</a><br /><br />
                            <?php
                            if($transactions['raise_tax_invoice'] != 1) {
                                ?>
                            <a href="#" onclick="return func_confirm_raise_tax_invoice('<?php echo commonHelperGetPageUrl('raise-tax-invoice', $transactions['eventsignupid']); ?>')" > Raise Tax Invoice</a> <br /><br />
                            <?php
                            }
                            else
                            {
                                echo "Raise Tax Invoice <br /><br />";
                            }
                            ?>
                            
                            <?php
                            if($transactions['raise_tax_invoice'] == 1) {
                                ?>
                            <a target="_blank" href='<?php echo commonHelperGetPageUrl('dashboard-email-tax-invoice', $transactions['eventsignupid']);?>' > Email Tax Invoice</a> <br /><br />
                            <?php
                            }
                            else
                            {
                                echo "Email Tax Invoice <br /><br />";
                            }
                            ?>

                            <?php
                            if($transactions['raise_tax_invoice'] == 1) {
                            ?>
                            <a href="#" onclick="return func_confirm_payment_capture('<?php echo commonHelperGetPageUrl('dashboard-make-transaction-success', $transactions['eventsignupid']); ?>')" > Confirm Payment</a> <br /><br />
                            <?php
                            }
                            else
                            {
                                echo "Confirm Payment <br /><br />";
                            }
                            ?>


                            <a href='<?php echo commonHelperGetPageUrl('dashboard-download-attendee-info', $transactions['eventsignupid']);?>' > Download Details</a> <br /><br />
                            <a href="#" onclick="return func_cancel_payment_capture('<?php echo commonHelperGetPageUrl('cancel-registration', $transactions['eventsignupid']); ?>')" > Cancel Registration</a> 

                        </td>
        </tr>
                 <?php
         }
         ?>
        </form>

<script language="javascript">
    function func_confirm_payment_capture(redirect_url)
    {
        var retVal = confirm("Do you want to confirm the payment ?");
        if( retVal == true )
        {
            window.location.href = redirect_url;
            return true;
        }
        else
        {
            return false;
        }
    }

    function func_cancel_payment_capture(redirect_url)
    {
        var retVal = confirm("Do you want to cancel the payment ?");
        if( retVal == true )
        {
            window.location.href = redirect_url;
            return true;
        }
        else
        {
            return false;
        }
    }

</script>