
<?php // echo 't//print_r($ticketsData);exit;'; exit;?>
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
            if ($_SERVER['HTTP_HOST'] == 'iifa2017.com') {
                // if day1 event else day2 eventid
                if($eventId == 97081){
                    $ticketids = array('Platinum' => 85126, 'Diamond' => 85127, 'Gold' => 85128, 'Silver' => 85129, 'Bronze' => 85130);
                }else{
                    
                }
                
            }elseif ($_SERVER['HTTP_HOST'] == 'dev3.meraevents.com') {
                if($eventId == 104624){
                    $ticketids = array('Platinum' => 97503, 'Diamond' => 97504, 'Gold' => 97505, 'Silver' => 97506, 'Bronze' => 97507);
                }elseif($eventId == 104625){
                    $ticketids = array('Platinum' => 97508, 'Diamond' => 97509, 'Gold' => 97510, 'Silver' => 97511, 'Bronze' => 97512);    
                }
            } elseif ($_SERVER['HTTP_HOST'] == 'stage.meraevents.com') {
                
                    if($eventId == 104515){
                          $ticketids = array('Platinum' => 97134, 'Diamond' => 97135, 'Gold' => 97136, 'Silver' => 97137, 'Bronze' => 97138);
                          
                    }else if($eventId == 104516){
                         $ticketids = array('Platinum' => 97139, 'Diamond' => 97140, 'Gold' => 97141, 'Silver' => 97142, 'Bronze' => 97143);    
                         
                     }
             
            }elseif ($_SERVER['HTTP_HOST'] == 'www.meraevents.com') {
                  if($eventId == 123789){
                          $ticketids = array('Platinum' => 127667, 'Diamond' => 127669, 'Gold' => 127670, 'Silver' => 127671, 'Bronze' => 127672);
                  }else if($eventId == 123791){
                          $ticketids = array('Platinum' => 127673, 'Diamond' => 127674, 'Gold' => 127675, 'Silver' => 127676, 'Bronze' => 127677);    
                    }
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
                        <div id="WizardBox" style="width: 1600px !important;">
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

                            <div id="stage"></div>

                            <h1 class="level"><?php echo $ticketsData[$ticketids['Platinum']]['name']; ?> (<img src="http://static.meraevents.com/content/images/rupee-icon.gif" width="12" height="12" /> <?php echo $ticketsData[$ticketids['Platinum']]['price']; ?>)</h1>
                            <div class="seatplan">
                                <ul class="r">

                                    <?php
                                    $notype1 = isset($calculationDetails['ticketsData'][$ticketids['Platinum']]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketids['Platinum']]['selectedQuantity'] : 0;
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



                                        if ($cnt == 85) {
                                            echo '</ul></div><div class="seatplan"><ul class="r">';
                                            $cnt = 0;
                                        }
                                    } //ends for loop
                                    ?>
                                </ul>
                            </div>
                            <h1 class="level"><?php echo $ticketsData[$ticketids['Diamond']]['name']; ?> (<img src="http://static.meraevents.com/content/images/rupee-icon.gif" width="12" height="12" /> <?php echo $ticketsData[$ticketids['Diamond']]['price']; ?>)</h1>
                            <div class="seatplan">
                                <ul class="r">

                                    <?php
                                    $cnt = 0;
                                    $notype2 = isset($calculationDetails['ticketsData'][$ticketids['Diamond']]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketids['Diamond']]['selectedQuantity'] : 0;
                                    for ($i = 0; $i < count($ResSeatslevel2); $i++) {
                                        $cnt++;
                                        //$notype2 = 0;
                                        //$notype2 = isset($calculationDetails['ticketsData'][$ticketids['Rows I to J']]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketids['Rows I to J']]['selectedQuantity'] : 0;
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
                                                if ($ResSeatslevel2[$i]['Status'] == 'Available') {
                                                    echo '<li class="s bl" onclick="CngClass2(this,' . $notype2 . ',' . $ResSeatslevel2[$i]['Id'] . ',' . $eventsignupId . ');" id="' . $rowno . $ResSeatslevel2[$i]['Seatno'] . '" title="' . $ResSeatslevel2[$i]['Seatno'] . '"></li>';
                                                } else if ($ResSeatslevel2[$i]['Status'] == 'Booked') {
                                                    echo '<li class="r rd" id="' . $rowno . $ResSeatslevel2[$i]['Seatno'] . '" ></li>';
                                                } else if ($ResSeatslevel2[$i]['Status'] == 'Reserved') {
                                                    echo '<li class="b x" id="' . $rowno . $ResSeatslevel2[$i]['Seatno'] . '" ></li>';
                                                } else if ($ResSeatslevel2[$i]['Status'] == 'InProcess') {
                                                    echo '<li class="r rd" id="' . $rowno . $ResSeatslevel2[$i]['Seatno'] . '" ></li>';
                                                }
                                            }
                                        }
                                        ?>





                                        <?php
                                        if ($cnt == 85) {
                                            echo '</ul></div><div class="seatplan"><ul class="r">';
                                            $cnt = 0;
                                        }
                                    } //ends for loop
                                    ?>
                                </ul>
                            </div>
                            <h1 class="level"><?php echo $ticketsData[$ticketids['Gold']]['name']; ?> (<img src="http://static.meraevents.com/content/images/rupee-icon.gif" width="12" height="12"/> <?php echo $ticketsData[$ticketids['Gold']]['price']; ?>)</h1>
                            <div class="seatplan">
                                <ul class="r">

                                    <?php
                                    $notype3 = isset($calculationDetails['ticketsData'][$ticketids['Gold']]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketids['Gold']]['selectedQuantity'] : 0;
                                    $cnt = 0;
                                    for ($i = 0; $i < count($ResSeatslevel3); $i++) {
                                        //$notype3 = 0;
                                        //$notype3 = isset($calculationDetails['ticketsData'][$ticketids['Rows I to J']]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketids['Rows E to H']]['selectedQuantity'] : 0;
                                        $cnt++;
                                        $rowno = preg_replace("/[0-9]+/","",$ResSeatslevel3[$i]['GridPosition']);
                                        if ($cnt == 1) {
                                            echo '<li class="ltr">' . $rowno . '</li>';
                                        }
                                        //var_dump($ResSeatslevel3[$i]['Seatno']);
                                        if ($ResSeatslevel3[$i]['Seatno'] == 0) {
                                            echo '<li class="b"></li>';
                                        } else {
                                            if ($notype3 == "" || $notype3 == 0) {
                                                echo '<li class="bl x" id="' . $rowno . $ResSeatslevel3[$i]['Seatno'] . '" ></li>';
                                            } else {
                                                if ($ResSeatslevel3[$i]['Status'] == 'Available') {
                                                    echo '<li class="s bl" onclick="CngClass3(this,' . $notype3 . ',' . $ResSeatslevel3[$i]['Id'] . ',' . $eventsignupId . ');" id="' . $rowno . $ResSeatslevel3[$i]['Seatno'] . '" title="' . $ResSeatslevel3[$i]['Seatno'] . '"></li>';
                                                } else if ($ResSeatslevel3[$i]['Status'] == 'Booked') {
                                                    echo '<li class="r rd" id="' . $rowno . $ResSeatslevel3[$i]['Seatno'] . '" ></li>';
                                                } else if ($ResSeatslevel3[$i]['Status'] == 'Reserved') {
                                                    echo '<li class="b x" id="' . $rowno . $ResSeatslevel3[$i]['Seatno'] . '" ></li>';
                                                } else if ($ResSeatslevel3[$i]['Status'] == 'InProcess') {
                                                    echo '<li class="r rd" id="' . $rowno . $ResSeatslevel3[$i]['Seatno'] . '" ></li>';
                                                }
                                            }
                                        }
                                        ?>





                                        <?php
                                        if ($cnt == 85) {
                                            echo '</ul></div><div class="seatplan"><ul class="r">';
                                            $cnt = 0;
                                        }
                                    } //ends for loop
                                    ?>
                                </ul>
                            </div>
							<h1 class="level"><?php echo $ticketsData[$ticketids['Silver']]['name']; ?> (<img src="http://static.meraevents.com/content/images/rupee-icon.gif" width="12" height="12"/> <?php echo $ticketsData[$ticketids['Silver']]['price']; ?>)</h1>
                            <div class="seatplan">
                                <ul class="r">

                                    <?php
                                    $notype4 = isset($calculationDetails['ticketsData'][$ticketids['Silver']]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketids['Silver']]['selectedQuantity'] : 0;
                                    $cnt = 0;
                                    for ($i = 0; $i < count($ResSeatslevel4); $i++) {
                                        //$notype3 = 0;
                                        //$notype3 = isset($calculationDetails['ticketsData'][$ticketids['Rows K to M']]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketids['Rows E to H']]['selectedQuantity'] : 0;
                                        $cnt++;
                                        $rowno = preg_replace("/[0-9]+/","",$ResSeatslevel4[$i]['GridPosition']);
                                        if ($cnt == 1) {
                                            echo '<li class="ltr">' . $rowno . '</li>';
                                        }
                                        //var_dump($ResSeatslevel4[$i]['Seatno']);
                                        if ($ResSeatslevel4[$i]['Seatno'] == 0) {
                                            echo '<li class="b"></li>';
                                        } else {
                                            if ($notype4 == "" || $notype4 == 0) {
                                                echo '<li class="bl x" id="' . $rowno . $ResSeatslevel4[$i]['Seatno'] . '" ></li>';
                                            } else {
                                                if ($ResSeatslevel4[$i]['Status'] == 'Available') {
                                                    echo '<li class="s bl" onclick="CngClass4(this,' . $notype4 . ',' . $ResSeatslevel4[$i]['Id'] . ',' . $eventsignupId . ');" id="' . $rowno . $ResSeatslevel4[$i]['Seatno'] . '" title="' . $ResSeatslevel4[$i]['Seatno'] . '"></li>';
                                                } else if ($ResSeatslevel4[$i]['Status'] == 'Booked') {
                                                    echo '<li class="r rd" id="' . $rowno . $ResSeatslevel4[$i]['Seatno'] . '" ></li>';
                                                } else if ($ResSeatslevel4[$i]['Status'] == 'Reserved') {
                                                    echo '<li class="b x" id="' . $rowno . $ResSeatslevel4[$i]['Seatno'] . '" ></li>';
                                                } else if ($ResSeatslevel4[$i]['Status'] == 'InProcess') {
                                                    echo '<li class="r rd" id="' . $rowno . $ResSeatslevel4[$i]['Seatno'] . '" ></li>';
                                                }
                                            }
                                        }
                                        ?>





                                        <?php
                                        if ($cnt == 85) {
                                            echo '</ul></div><div class="seatplan"><ul class="r">';
                                            $cnt = 0;
                                        }
                                    } //ends for loop
                                    ?>
                                </ul>
                            </div>
							<h1 class="level"><?php echo $ticketsData[$ticketids['Bronze']]['name']; ?> (<img src="http://static.meraevents.com/content/images/rupee-icon.gif" width="12" height="12"/> <?php echo $ticketsData[$ticketids['Bronze']]['price']; ?>)</h1>
                            <div class="seatplan">
                                <ul class="r">

                                    <?php
                                    $notype5 = isset($calculationDetails['ticketsData'][$ticketids['Bronze']]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketids['Bronze']]['selectedQuantity'] : 0;
                                    $cnt = 0;
                                    for ($i = 0; $i < count($ResSeatslevel5); $i++) {
                                        //$notype3 = 0;
                                        //$notype3 = isset($calculationDetails['ticketsData'][$ticketids['Rows N to P']]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketids['Rows E to H']]['selectedQuantity'] : 0;
                                        $cnt++;
                                        $rowno = preg_replace("/[0-9]+/","",$ResSeatslevel5[$i]['GridPosition']);
                                        if ($cnt == 1) {
                                            echo '<li class="ltr">' . $rowno . '</li>';
                                        }
                                        //var_dump($ResSeatslevel5[$i]['Seatno']);
                                        if ($ResSeatslevel5[$i]['Seatno'] == 0) {
                                            echo '<li class="b"></li>';
                                        } else {
                                            if ($notype5 == "" || $notype5 == 0) {
                                                echo '<li class="bl x" id="' . $rowno . $ResSeatslevel5[$i]['Seatno'] . '" ></li>';
                                            } else {
                                                if ($ResSeatslevel5[$i]['Status'] == 'Available') {
                                                    echo '<li class="s bl" onclick="CngClass5(this,' . $notype5 . ',' . $ResSeatslevel5[$i]['Id'] . ',' . $eventsignupId . ');" id="' . $rowno . $ResSeatslevel5[$i]['Seatno'] . '" title="' . $ResSeatslevel5[$i]['Seatno'] . '"></li>';
                                                } else if ($ResSeatslevel5[$i]['Status'] == 'Booked') {
                                                    echo '<li class="r rd" id="' . $rowno . $ResSeatslevel5[$i]['Seatno'] . '" ></li>';
                                                } else if ($ResSeatslevel5[$i]['Status'] == 'Reserved') {
                                                    echo '<li class="b x" id="' . $rowno . $ResSeatslevel5[$i]['Seatno'] . '" ></li>';
                                                } else if ($ResSeatslevel5[$i]['Status'] == 'InProcess') {
                                                    echo '<li class="r rd" id="' . $rowno . $ResSeatslevel5[$i]['Seatno'] . '" ></li>';
                                                }
                                            }
                                        }
                                        ?>





                                        <?php
                                        if ($cnt == 85) {
                                            echo '</ul></div><div class="seatplan"><ul class="r">';
                                            $cnt = 0;
                                        }
                                    } //ends for loop
                                    ?>
                                </ul>
                            </div>
						
                            <div align="center">
                                <input type="button" name="SubmitAttendee" value="Confirm Seats"  onclick="return validat_reg_form('<?= $eventsignupId; ?>',<?php echo round($calculationDetails['ticketsData'][$ticketids['Platinum']]['selectedQuantity'] + $calculationDetails['ticketsData'][$ticketids['Diamond']]['selectedQuantity'] + $calculationDetails['ticketsData'][$ticketids['Gold']]['selectedQuantity'] + $calculationDetails['ticketsData'][$ticketids['Silver']]['selectedQuantity'] + $calculationDetails['ticketsData'][$ticketids['Bronze']]['selectedQuantity']); ?>);"id="signin_submit" class="processbutton" style="margin:15px;" />
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