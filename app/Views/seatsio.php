
    <?php /* echo '<pre>'; print_r($seatsioCategories); echo '</pre>'; exit;
       echo '<pre>'; print_r($ticketmapping); echo '</pre>';*/
    ?>
    <?php 
        $maxCategory = '';
        $availCat = array();
        foreach($seatsioticketmapping as $mapticket){
            $qty = 0;
            if(isset($mapticket['ticketid']) && $mapticket['ticketid'] > 0){
                if($calculationDetails['ticketsData'][$mapticket['ticketid']] > 0){
                     $qty = $calculationDetails['ticketsData'][$mapticket['ticketid']]['selectedQuantity'];
                     $cat = $mapticket['category'];
                     $maxCategory .= "{ category: {$cat}, quantity: {$qty} },";
                     $availCat[] = $cat;
                }
            }
        }
        $maxCategory = ($maxCategory == '') ? '': substr($maxCategory, 0, -1);
        $unavailablecategories = "";
        foreach ($seatsioCategories as $seatsioCategory) {
            if(!in_array($seatsioCategory->key, $availCat))
                $unavailablecategories .= "'{$seatsioCategory->key}',";
        }
        $unavailablecategories = ($unavailablecategories!= "") ? substr($unavailablecategories, 0, -1) : "";
        //print_r($maxCategory); exit;
    ?>
<input type="hidden" id="themefieldsActualFields" value="<?php if(isset($themeFieldsUrl) && $themeFieldsUrl!=''){ echo '&samepage=1'.str_replace('----', '&', $themeFieldsUrl); }?>">
<div <?php if(isset($widgetStatus)){ }else{ ?> class="container" <?php } ?>> 
    <!--LOGIN AND SIGNUP SECTION-->
    <?php if ($isExisted) { ?>
        <div class="innerPageContainer" style="margin-bottom: 30px;">
            <h2 class="pageTitle">Registration Information</h2>
            <div class="row">
                <div class="col-md-12">
                    Looks like you used the browser back button after completing your previous transaction to buy another ticket!<br>
                    To buy another ticket for this event go to
                    <a href="<?php echo $eventData['eventUrl']; ?>">Preview Event</a> and continue from there.
                    <br><br>Contact support at support@meraevents.com or 040-49171447 for assistance.
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="innerPageContainer">
            <h4 class="blockquote "></h4>
            <div class="row">
                <div>
                    <script>
                        var paymentGatewaySelected = "<?php echo $paymentGatewaySelected; ?>";
                        var api_updateSeatsio = "<?php echo commonHelperGetPageUrl('api_updateSeatsio') ?>";
                    </script> 
                    <input type="hidden" name="eventId" id="eventId" value="<?php echo $eventId; ?>"/>
                    
                    <div class="col-lg-8 m-tb50 widgetseatingwidth">
                        <div id="chart"></div>          
                    </div>
                    
                    <!-- <div class="col-lg-4">
                        <h4>Selected Seats:</h4>
                        <span id="selectedSeats">Please Select Seats</span>
                        <span id="errorMessages"> </span>
                        <br>
                        <b id="alert-warning">Note: Seats are reserved for 15 min after confirmation</b>
                        <div align="center">
                            <input type="button" name="SubmitAttendee" value="Confirm Seats" id="signin_submit" class="processbutton" style="margin:15px;" onclick="validat_reg_form()" />
                        </div>
                    </div> -->

                    <div class="col-lg-4 m-tb50 widgetseatingwidthinfo">
                         <p>
                            Selected Seats: 
                         </p>
                         <b><h4 class="MarginBottom" id="selectedSeats">Please Select Seats</h4></b>
                         <p>Selectable Tickets:<br>
                         <?php 
                         foreach ($calculationDetails['ticketsData'] as $selectedTicketId) {
                             echo $selectedTicketId['ticketName'].'  -  '.$selectedTicketId['selectedQuantity'].'<br>';
                         }
                         ?>
                         </p>
                         <span id="errorMessages"></span>
                         <p id="alert-warning"><b>Note: Seats are reserved for 15 min after confirmation</b></p>
                         <div>
                            <input type="button" name="SubmitAttendee" value="Confirm Seats" id="signin_submit" class="btn login"  onclick="validat_reg_form()" <?php if(in_array($paymentGatewaySelected,array('paypal','paypalinr'))){ ?> style="display: none;"<?php } ?>/>

                            <?php if(in_array($paymentGatewaySelected,array('paypal','paypalinr'))){ ?>
                            <div id="paypal-button-container" class="paynowbtn margintop20" style="display: none;"></div>
                            <?php } ?>
                         </div>
                      </div>


                </div>
            </div>
        </div>
        <script src="https://app.seats.io/chart.js"></script>

        <script>
            var seats = [];
            var maxSeats = <?php echo $calculationDetails['totalTicketQuantity'] ?>;
            var chart = new seatsio.SeatingChart({
                divId: 'chart',
                publicKey: '<?php echo $seatsioPublicKey; ?>',
                event: '<?php echo $seatsioEventKey?>',
                selectedObjectsInputName: 'seatsChosen',
                onObjectSelected: function(object, selectedTicketType){
                    $('#selectedSeats').html(object.chart.selectedSeats.join(", ")); 
                    if(paymentGatewaySelected == 'paypal' || paymentGatewaySelected == 'paypalinr'){      
                        if(maxSeats == object.chart.selectedSeats.length){
                            $('#paypal-button-container').show();
                        }else{
                            $('#paypal-button-container').hide();
                        }
                    } 
                },
                onObjectDeselected: function(object, selectedTicketType){
                    $('#selectedSeats').html(object.chart.selectedSeats.join(", "));
                    if(paymentGatewaySelected == 'paypal' || paymentGatewaySelected == 'paypalinr'){     
                        if(maxSeats == object.chart.selectedSeats.length){
                            $('#paypal-button-container').show();
                        }else{
                            $('#paypal-button-container').hide();
                        }
                    }
                },
                <?php 
                    $maxSlctTktType = '';
                    if($maxCategory!=''){
                        if(count($seatsioticketmapping['tickettypelimit'])>0){
                            foreach ($seatsioticketmapping['tickettypelimit'] as $tickettype ) {
                                $tktType= $tickettype['ticketType'];
                                $tktTypeQty= $tickettype['quantity'];
                               $maxSlctTktType .= "{ ticketType: '{$tktType}', quantity: {$tktTypeQty} },"; 
                            }
                        }
                        echo ($maxSlctTktType == '') ? "maxSelectedObjects: [".$maxCategory."]," : "maxSelectedObjects: [".$maxSlctTktType."],";
                    }
                    else echo "maxSelectedObjects: {$calculationDetails['totalTicketQuantity']},";

                ?>
                <?php 
                    echo ($unavailablecategories!='') ? "unavailableCategories : [{$unavailablecategories}]," : ''; 
                ?>
                showLegend: true,
                legend: {
                    hidePricing: true
                },
                showRowLabels: true,
                
            });
            chart.render();
        </script>              
    <?php } ?>
</div>
<?php include_once('includes/elements/gateways.php'); ?>
<script type="text/javascript">
    var rIp = '<?php echo $razorpayInput ?>';
    var eventsignupId = <?php echo isset($eventsignupId)? $eventsignupId : ''; ?> ;
    var orderId= "<?php echo (isset($orderLogId)&& $orderLogId!='') ? $orderLogId : 0; ?>";
</script>
<?php 
foreach($eventGateways as $key=>$gateway) {
    if(in_array($gateway['functionname'], array('stripe','razorpay','paypal','paypalinr')) && $calculationDetails['totalPurchaseAmount'] > 0){
         if(isset($gateway['environment'])){
            $paypalGatewayEnvironment = $gateway['environment'];
        }
        if($gateway['functionname'] == 'paypalinr'){
            $gateway['functionname'] = 'paypal';
        }
        include_once 'payment/'.$gateway['functionname'].'_prepare.php';
    }
}
?>
<?php 
include_once 'includes/elements/mywallet_js.php';
?>