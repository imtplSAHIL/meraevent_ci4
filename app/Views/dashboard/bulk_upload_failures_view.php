<div class="rightArea">
    <?php  
        $discountFlashMessage=$this->customsession->getData('discountFlashMessage');
        $this->customsession->unSetData('discountFlashMessage');
    ?>
    <?php if($discountFlashMessage){?>
        <div class="db-alert db-alert-success flashHide">
            <strong>  <?php echo $discountFlashMessage; ?></strong> 
        </div>
    <?php }?>
    <div class="heading">
        <h2>Discount Codes: <span><?php echo $eventName; ?></span></h2>
    </div>
    <div style="width:50%" class="float-left"> </div>
    <div class="float-right"> <a href="<?php echo commonHelperGetPageUrl('dashboard-add-discount', $eventId); ?>" class="createBtn float-left font14"><span class="icon-add pinkBg"></span>Add New Discount</a> </div>
    <div class="clearBoth"></div>
    <div class="refundSec discount"><!-- data-tablesaw-mode="swipe" -->
        <table width="100%" border="1" cellspacing="0" cellpadding="0"  data-tablesaw-minimap>
            <thead>
                <tr>
                    <th scope="col"  style="padding-left:2%;text-align:left;width:20% !important">Attendee Email</th>
                    <th scope="col" data-tablesaw-priority="2" style="text-align:left;width:12% !important">Failed Reason</th>
                    <th scope="col" data-tablesaw-priority="2" style="text-align:left;width:15% !important">Date</th>
                </tr>

            </thead>
            <tbody>
                <?php

                    $i = 0;
                    foreach ($result as $row) {
                        $class = 'odd';
                        if ($i % 2 == 0) {
                            $class = '';
                        }

                        $failed = explode("Error:", $row['failed_reason']);

                        ?>

                        <tr <?php echo $class; ?> >
                            <td style="text-align:left !important;"><?php echo $row['attendee_email']; ?></td>
                            <td style="text-align:left !important;"><?php echo $failed[1]; ?></td>
                            <td style="text-align:left !important;"><?php echo $row['cts']; ?></td>
                        </tr>
                        <?php
                    }
            ?>  

            </tbody>
        </table>
    </div>
</div>
