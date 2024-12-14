<div class="rightArea">
    <div class="heading" >
        <h2>Partial Payment Events Dashboard</h2>
    </div>
    <div class="PromoterView">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" data-tablesaw-minimap>
            <thead>
                <tr>
                    <th scope="col" data-tablesaw-priority="5">Event Id</th>
                    <th scope="col" data-tablesaw-priority="5">Event Name</th>
                    <th scope="col" data-tablesaw-priority="5">Ticket Name</th>
                    <th scope="col" data-tablesaw-priority="5">Ticket Price</th>
                    <th scope="col" data-tablesaw-priority="5">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($partialPaymentsEvents['response']['eventsList'] as $data) { ?>   
                <td><?php echo $data['eventid']; ?></td>
                <td><?php echo $data['title'] ?></td>
                <td><?php echo $data['name'] ?></td>
                <td><?php echo $data['price'] ?></td>
                <?php  date_default_timezone_set('Asia/Calcutta');
               $date = date('Y-m-d H:i:s'); 
               if($data['enddatetime'] > $date){
               ?>
                <td><a href="<?php echo commonHelperGetPageUrl('partial-payment-event-details'). "/" . $data['id'] . "/" . $data['eventid'] ."/". $data['ticketids'] ; ?>">Make Payment</td>
               <?php }else{ ?>
                <td><a href="<?php echo commonHelperGetPageUrl('partial-payment-event-details'). "/" . $data['id'] . "/" . $data['eventid'] ."/". $data['ticketids'] ; ?>">View Payments</td>
               <?php } ?>
            </tbody>

            <?php } ?> 
        </table>
    </div>
</div>
