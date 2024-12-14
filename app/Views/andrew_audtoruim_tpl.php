
<?php //print_r($ticketsData);exit;?>
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
            <?php 
            //print_r($_SERVER);exit;
            if ($_SERVER['HTTP_HOST'] == 'menew.com') {
                $ticketids = array('balcony' => 84394, 'stall' => array(84398,84399,84400,84401,84402));
                //$eventId = '96703'; //$c_1
            }elseif ($_SERVER['HTTP_HOST'] == 'dev2.meraevents.com' || $_SERVER['HTTP_HOST'] == 'dev1.meraevents.com' || $_SERVER['HTTP_HOST'] == 'dev.meraevents.com' || $_SERVER['HTTP_HOST'] == 'dev3.meraevents.com') {
                $ticketids = array('balcony' => 84394, 'stall' => array(84536,84537,84538,84539,84540));
                //$eventId = '101737'; //$c_1
            } elseif ($_SERVER['HTTP_HOST'] == 'stage.meraevents.com') {
                $ticketids = array('stall' => array(95051,95215,95216,95217,96034));
                //$eventId = '101737'; //$c_1
            }elseif ($_SERVER['HTTP_HOST'] == 'www.meraevents.com') {
                $ticketids = array('stall' => array(95051,95217,97318,97319,97320));
                //$eventId = '101066'; //$c_1
            }
            ?>
                <div>
                    <script>
                        var api_updateSeats = "<?php echo commonHelperGetPageUrl('api_updateSeats') ?>";
                        var paymentGatewaySelected = "<?php echo $paymentGatewaySelected; ?>";
                        var api_checkUpdateSeats = "<?php echo commonHelperGetPageUrl('api_checkUpdateSeats') ?>";
                    </script>
                    <link rel="stylesheet" href="<?php echo $this->config->item('protocol') . $_SERVER['HTTP_HOST'] . '/css/public/styles-seating.css' ?>">
                    <input type="hidden" name="eventId" id="eventId" value="<?php echo $eventId; ?>"/>
                    <div class="col-lg-12" id="LeftPaddCol">
                        <div id="WizardBox">
                            <table border="0" align="right" cellpadding="0" style="text-align:right;">
                                <tr>
                                    <td height="30"><img src="<?php echo $availableImage; ?>" width="13" height="15" /></td>
                                    <td height="30" style="text-align:left;">Available</td>
                                    <td height="30">&nbsp;</td>

                                    <td height="30"><img src="<?php echo $currentBookingImage; ?>" width="13" height="15" class="style3" /></td>
                                    <td height="30" style="text-align:left;">Current Booking</td>
                                    <td height="30">&nbsp;</td>

                                    <td height="30"><img src="<?php echo $otherAreaImage; ?>" width="13" height="15" /></td>
                                    <td height="30" style="text-align:left;">Other Area </td>
                                    <td height="30">&nbsp;</td>

                                    <td height="30"><img src="<?php echo $bookedImage; ?>" width="13" height="15" /></td>
                                    <td height="30" style="text-align:left;">Booked</td>
                                </tr>
                            </table>
                            <div style="clear:both;"></div>

                            <!--<h1 class="level"><?php //echo $ticketsData[$ticketids['balcony']]['name']; ?> (<img src="http://static.meraevents.com/content/images/rupee-icon.gif" width="12" height="12" /> <?php //echo $ticketsData[$ticketids['balcony']]['price']; ?>)</h1>-->
                            <div class="seatplan">
                                <ul class="r">

                                    <?php
                                    $notype1 = isset($calculationDetails['ticketsData'][$ticketids['balcony']]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketids['balcony']]['selectedQuantity'] : 0;
                                    $cnt = 0;
                                    for ($i = 0; $i < count($ResSeatslevel1); $i++) {
                                        $cnt++;
                                        $rowno = substr($ResSeatslevel1[$i]['GridPosition'], 0, 1);
                                        if ($cnt == 1) {
                                            echo '<li class="ltr">' . $rowno . '</li>';
                                        }

                                        //var_dump((int)$ResSeatslevel1[$i]['Seatno']);
                                        if ((int) $ResSeatslevel1[$i]['Seatno'] == 0) {
                                            echo '<li class="b"></li>';
                                        } else {
                                            if ($notype1 == "" || $notype1 == 0) {
                                                echo '<li class="bl x" id="' . $rowno . $ResSeatslevel1[$i]['Seatno'] . '" ></li>';
                                            } else {
                                                if ($ResSeatslevel1[$i]['Status'] == 'Available') {
                                                    echo '<li class="s bl" onclick="CngClass1(this,' . $notype1 . ',' . $ResSeatslevel1[$i]['Id'] . ',' . $eventsignupId . ');" id="' . $rowno . $ResSeatslevel1[$i]['Seatno'] . '" title="' . $ResSeatslevel1[$i]['Seatno'] . '"></li>';
                                                } else if ($ResSeatslevel1[$i]['Status'] == 'Booked') {
                                                    echo '<li class="r rd" id="' . $rowno . $ResSeatslevel1[$i]['Seatno'] . '" ></li>';
                                                } else if ($ResSeatslevel1[$i]['Status'] == 'Reserved') {
                                                    echo '<li class="b x" id="' . $rowno . $ResSeatslevel1[$i]['Seatno'] . '" ></li>';
                                                } else if ($ResSeatslevel1[$i]['Status'] == 'InProcess') {
                                                    echo '<li class="r rd" id="' . $rowno . $ResSeatslevel1[$i]['Seatno'] . '" ></li>';
                                                }
                                            }
                                        }



                                        if ($cnt == 47) {
                                            echo '</ul></div><div class="seatplan"><ul class="r">';
                                            $cnt = 0;
                                        }
                                    } //ends for loop
                                    ?>
                                </ul>
                            </div>
                            <h1 class="level"><?php echo $ticketsData[$ticketids['stall']]['name']; ?> (<img src="http://static.meraevents.com/content/images/rupee-icon.gif" width="12" height="12" /> <?php echo $minPrice."-".$maxPrice; ?>)</h1>
                            <div class="seatplan">
                                <ul class="r">

                                    <?php //print_r($ResSeatslevel2);
                                    $cnt = $notype2=0;
                                    foreach($ticketids['stall'] as $ticketIdsData){
                                        $notype2 += isset($calculationDetails['ticketsData'][$ticketIdsData]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketIdsData]['selectedQuantity'] : 0;
                                    }
                                    for ($i = 0; $i < count($ResSeatslevel2); $i++) {
                                        $cnt++;
                                        //$notype2 = 0;
                                        //$notype2 = isset($calculationDetails['ticketsData'][$ticketids['Scouted']]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketids['Scouted']]['selectedQuantity'] : 0;
                                        $rowno = substr($ResSeatslevel2[$i]['GridPosition'], 0, 1);
                                        if ($cnt == 1) {
                                            echo '<li class="ltr">' . $rowno . '</li>';
                                        }

                                        if ((int) $ResSeatslevel2[$i]['Seatno'] == 0) {
                                            echo '<li class="b"></li>';
                                        } else {
                                            if ($notype2 == "" || $notype2 == 0) {
                                                echo '<li class="bl x" id="' . $rowno . $ResSeatslevel2[$i]['Seatno'] . '" ></li>';
                                            } else {
                                                $jsFunctionName='CngClass1';
                                                if($ResSeatslevel2[$i]['ticketid']==$ticketids['stall'][0]){
                                                        $jsFunctionName='CngClass1';
                                                }elseif($ResSeatslevel2[$i]['ticketid']==$ticketids['stall'][1]){
                                                        $jsFunctionName='CngClass2';
                                                }elseif($ResSeatslevel2[$i]['ticketid']==$ticketids['stall'][2]){
                                                        $jsFunctionName='CngClass3';
                                                }elseif($ResSeatslevel2[$i]['ticketid']==$ticketids['stall'][3]){
                                                        $jsFunctionName='CngClass4';
                                                }elseif($ResSeatslevel2[$i]['ticketid']==$ticketids['stall'][4]){
                                                        $jsFunctionName='CngClass5';
                                                }
                                                //ticketid
                                                if ($ResSeatslevel2[$i]['Status'] == 'Available' && in_array($ResSeatslevel2[$i]['ticketid'],array_keys($calculationDetails['ticketsData']))) {
                                                    echo '<li class="s bl" onclick="'.$jsFunctionName.'(this,' . $calculationDetails['ticketsData'][$ResSeatslevel2[$i]['ticketid']]['selectedQuantity'] . ',' . $ResSeatslevel2[$i]['Id'] . ',' . $eventsignupId . ');" id="' . $rowno . $ResSeatslevel2[$i]['Seatno'] . '" title="' . $ResSeatslevel2[$i]['Seatno'] . '"></li>';
                                                } else if ($ResSeatslevel2[$i]['Status'] == 'Booked') {
                                                    echo '<li class="r rd" id="' . $rowno . $ResSeatslevel2[$i]['Seatno'] . '" ></li>';
                                                } else if ($ResSeatslevel2[$i]['Status'] == 'Reserved') {
                                                    echo '<li class="b x" id="' . $rowno . $ResSeatslevel2[$i]['Seatno'] . '" ></li>';
                                                } else if ($ResSeatslevel2[$i]['Status'] == 'InProcess') {
                                                    echo '<li class="r rd" id="' . $rowno . $ResSeatslevel2[$i]['Seatno'] . '" ></li>';
                                                }else{
                                                    echo '<li class="b x" id="' . $rowno . $ResSeatslevel2[$i]['Seatno'] . '" ></li>';
                                                }
                                            }
                                        }
                                        ?>





                                        <?php
                                        if ($cnt == 47) {
                                            echo '</ul></div><div class="seatplan"><ul class="r">';
                                            $cnt = 0;
                                        }
                                    } //ends for loop
                                    ?>
                                </ul>
                            </div>
                            
                            <div id="stage"></div>
                            <div align="center">
                                <input type="button" name="SubmitAttendee" value="Confirm Seats"  onclick="return validat_reg_form('<?= $eventsignupId; ?>',<?php echo round($notype1+$notype2); ?>);"id="signin_submit" class="processbutton" style="margin:15px;" />
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
