<?php $totalRowCount = 29; 

    function startCountFromRight($block_array, $totalRowCount ){
        $ct = 0;
        $reverseArray = array();
        for ($i = 0; $i < count($block_array); $i++) {
          
            $ct++;
            $rowarray[] = $block_array[$i];
            if($ct==$totalRowCount){
                $reverseArray =  array_reverse($rowarray);
                  foreach ($reverseArray as $key2 => $value2) {
                        $final_array[] = $value2;
                    }
                
                $rowarray = array();
                $ct=0;
            }
        }
        return $final_array;                     
    }   

$ticketsData = $calculationDetails['ticketsData']; 
$configItem = $this->config->item('royalOperaSeatingEvents');

//print_r($calculationDetails['totalTicketQuantity']); exit;

$ticketMapping = $configItem[$eventId];

//logic for adding quantity of non-member to member

foreach ($ticketMapping as $key => $ticketM) {
    if(!empty($ticketsData[$ticketM['memberTicket']])){
        if(!empty($ticketsData[$ticketM['nonMemberTicket']]['selectedQuantity']))
            $ticketsData[$ticketM['nonMemberTicket']]['selectedQuantity'] += $ticketsData[$ticketM['memberTicket']]['selectedQuantity'];
        else
            $ticketsData[$ticketM['nonMemberTicket']]['selectedQuantity'] = $ticketsData[$ticketM['memberTicket']]['selectedQuantity'];
    }
}

//print_r($ticketsData); exit; 
$tIdQtycount = 0;
foreach ($ticketsData as $key => $tickt) {
    $qty[$key] = $tIdQtycount += 1   ;
}

//print_r($qty); exit;


// $gapBeforeRow = array('K','R','X');


?>
<div class="container"> 
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
        <div class="row">
            <div>
                <div>
                    <script>
                        var api_updateSeats = "<?php echo commonHelperGetPageUrl('api_updateSeats') ?>";
                        var paymentGatewaySelected = "<?php echo $paymentGatewaySelected; ?>";
                        var api_checkUpdateSeats = "<?php echo commonHelperGetPageUrl('api_checkUpdateSeats') ?>";
                        var orderid = "<?php echo $orderLogId; ?>";
                    </script>
                    <link rel="stylesheet" href="<?php echo $this->config->item('protocol') . $_SERVER['HTTP_HOST'] . '/css/public/styles-seating.css' ?>">
                    <input type="hidden" name="eventId" id="eventId" value="<?php echo $eventId; ?>"/>
                    <div class="col-lg-12" id="LeftPaddCol">
                        <div id="WizardBox" style="text-align: center;margin: 10px 0;width: 500px;margin: 0 auto;margin-top: 20px;margin-bottom: 20px;">
                            <table border="0" align="right" cellpadding="0" style="text-align: right;  width: 100%;margin:10px 0;">
                                <tr>
                                    <td height="30"><img src="<?php echo $availableImage; ?>" width="13" height="15" /></td>
                                    <td height="30" style="text-align:left;font-size: 16px;">Available</td>
                                    <td height="30">&nbsp;</td>

                                    <td height="30"><img src="<?php echo $currentBookingImage; ?>" width="13" height="15" class="style3" /></td>
                                    <td height="30" style="text-align:left;font-size: 16px;">Current Booking</td>
                                    <td height="30">&nbsp;</td>

                                    <td height="30"><img src="<?php echo $otherAreaImage; ?>" width="13" height="15" /></td>
                                    <td height="30" style="text-align:left;font-size: 16px;">Other Area </td>
                                    <td height="30">&nbsp;</td>

                                    <td height="30"><img src="<?php echo $bookedImage; ?>" width="13" height="15" /></td>
                                    <td height="30" style="text-align:left;font-size: 16px;">Booked</td>
                                </tr>
                            </table>
                            <div style="clear:both;"></div>

                            <div id="stage"></div>
                            <?php echo '<h1 class="level">LEVEL 1</h1>'; ?>
                            <div class="seatplan">
                            <ul class="r">
                            <?php
                                $row = '';
                                $ResNew = startCountFromRight($ResNew, $totalRowCount );
                                $levelHeadingBeforeRow = array('D' => 'LEVEL 2', 'F' => 'LEVEL 3', 'H' => 'LEVEL 4', 'K' => 'LEVEL 3 - BALCONY', 'M' => 'LEVEL 4 - BALCONY', 'O' => 'LEVEL 5', 'R' => 'OTHERS');
                           
                               foreach ($ResNew as $key => $seat) {

                                    
                                    $notype = isset($ticketsData[$seat['ticketid']]['selectedQuantity']) ? $ticketsData[$seat['ticketid']]['selectedQuantity'] : 0;
                                    
                                    $rowno = $seat['GridPosition'][0];
                                    
                                   
                                    if ($row != $seat['GridPosition'][0]) {
                                        
                                        if(array_key_exists($row, $levelHeadingBeforeRow)){
                                                // echo '<h1 class="level"> (LEVEL "'.$levelHeadingBeforeRow[$row].'")</h1><div class="clear"><br></div>';
                                          //   echo "<br><br><br><br><br><br><br><br><br>";
                                        }
                                        echo '</ul></div>';
                                        if(array_key_exists($row, $levelHeadingBeforeRow)){
                                            echo '<h1 class="level">'.$levelHeadingBeforeRow[$row].'</h1>';
                                          //   echo "<br><br><br><br><br><br><br><br><br>";
                                        }
                                        
                                        if(in_array($row, $gapBeforeRow))
                                            echo "<br>";
                                        echo '<div class="seatplan"><ul class="r"><li class="ltr">' . $rowno . '</li>';
                                        $row = $seat['GridPosition'][0];
                                    }

                                    if ( $seat['Seatno'] == '0') {
                                        echo '<li class="b"></li>';
                                    } else {
                                        if ($notype == "" || $notype == 0) {
                                            echo '<li class="bl x" id="' . $rowno . $seat['Seatno'] . '" ></li>';
                                        } else {
                                            if ($seat['Status'] == 'Available') {
                                                echo '<li class="s bl" onclick="CngClass'.$qty[$seat['ticketid']].'(this,' . $notype . ',' . $seat['Id'] . ',' . $eventsignupId . ');" id="' . $rowno . $seat['Seatno'] . '" title="' . $rowno .$seat['Seatno'] . '"></li>';
                                            } else if ($seat['Status'] == 'Booked') {
                                                echo '<li class="r rd" id="' . $rowno . $seat['Seatno'] . '" ></li>';
                                            } else if ($seat['Status'] == 'Reserved') {
                                                echo '<li class="b x" id="' . $rowno . $seat['Seatno'] . '" ></li>';
                                            } else if ($seat['Status'] == 'InProcess') {
                                                echo '<li class="r rd" id="' . $rowno . $seat['Seatno'] . '" ></li>';
                                            }
                                        }
                                    }

                                }
                            ?>
                            </ul>
                            </div>
                            
                            <div class="clearfix"></div>
                            
							<br>
						
                            <div align="center">
                                <input type="button" name="SubmitAttendee" value="Confirm Seats"  onclick="return validat_reg_form('<?= $eventsignupId; ?>',<?php echo round($calculationDetails['totalTicketQuantity']); ?>);"id="signin_submit" class="processbutton" style="margin:15px;" />
                            </div>
                            <?php include_once('includes/elements/gateways.php'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?php 
include_once 'includes/elements/mywallet_js.php';
?>