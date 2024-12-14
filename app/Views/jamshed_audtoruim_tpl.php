
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
                 $ticketids = array('Member Entry Pass Level 1' => 97004, 'Member Entry Pass Level 2' => 97006,  'Member Entry Pass Level 3' => 97008, 'Member Entry Pass Level 4' => 97010, 'Member Entry Pass Level 5' => 97012, 'Member Entry Pass Level 6' => 97014, 'Member Entry Pass Level 7' => 97016);
                //$eventId = '96703'; //$c_1
            }elseif ($_SERVER['HTTP_HOST'] == 'dev2.meraevents.com') {
                $ticketids = array('Member Entry Pass Level 1' => 97004, 'Member Entry Pass Level 2' => 97006,  'Member Entry Pass Level 3' => 97008, 'Member Entry Pass Level 4' => 97010, 'Member Entry Pass Level 5' => 97012, 'Member Entry Pass Level 6' => 97014, 'Member Entry Pass Level 7' => 97016);
                //$eventId = '101737'; //$c_1
            } elseif ($_SERVER['HTTP_HOST'] == 'stage.meraevents.com') {
               $ticketids = array('Member Entry Pass Level 1' => 96785, 'Member Entry Pass Level 2' => 96786,  'Member Entry Pass Level 3' => 96787, 'Member Entry Pass Level 4' => 96788, 'Member Entry Pass Level 5' => 96789, 'Member Entry Pass Level 6' => 96790, 'Member Entry Pass Level 7' => 96791);
                //$eventId = '101737'; //$c_1
            }elseif ($_SERVER['HTTP_HOST'] == 'www.meraevents.com') {
                $ticketids = array('Member Entry Pass Level 1' => 109418, 'Member Entry Pass Level 2' => 109419,  'Member Entry Pass Level 3' => 109420, 'Member Entry Pass Level 4' => 109421, 'Member Entry Pass Level 5' => 109422, 'Member Entry Pass Level 6' => 109423, 'Member Entry Pass Level 7' => 109424);
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

                            <div id="stage"></div>

                            <h1 class="level"><?php echo $ticketsData[$ticketids['Member Entry Pass Level 3']]['name']; ?> (<img src="http://static.meraevents.com/content/images/rupee-icon.gif" width="12" height="12" /> <?php echo $ticketsData[$ticketids['Member Entry Pass Level 3']]['price']; ?>)</h1>
                            <div class="seatplan">
                                <ul class="r">

                                    <?php
                                    $notype1 = isset($calculationDetails['ticketsData'][$ticketids['Member Entry Pass Level 3']]['selectedQuantity'] ) ? $calculationDetails['ticketsData'][$ticketids['Member Entry Pass Level 3']]['selectedQuantity'] : 0;
									$cnt = 0;									
									//print_r($result);
									$result = $ResSeatslevel3;
                                    for ($i = 0; $i < count($result); $i++) {
                                        $cnt++;
                                        $rowno = substr($result[$i]['GridPosition'], 0, 2);
                                        if ($cnt == 1) {
                                            echo '<li class="ltr">' . $rowno . '</li>';
                                        }

                                        //var_dump((int)$ResSeatslevel1[$i]['Seatno']);
                                        if ((int) $result[$i]['Seatno'] == 0) {
                                            echo '<li class="b"></li>';
                                        } else {
                                            if ($notype1 == "" || $notype1 == 0) {
                                                echo '<li class="bl x" id="' . $rowno . $result[$i]['Seatno'] . '" ></li>';
                                            } else {
                                                if ($result[$i]['Status'] == 'Available') {
                                                    echo '<li class="s bl" onclick="CngClass1(this,' . $notype1 . ',' . $result[$i]['Id'] . ',' . $eventsignupId . ');" id="' . $rowno . $result[$i]['Seatno'] . '" title="' . $result[$i]['Seatno'] . '"></li>';
                                                } else if ($result[$i]['Status'] == 'Booked') {
                                                    echo '<li class="r rd" id="' . $rowno . $result[$i]['Seatno'] . '" ></li>';
                                                } else if ($result[$i]['Status'] == 'Reserved') {
                                                    echo '<li class="b x" id="' . $rowno . $result[$i]['Seatno'] . '" ></li>';
                                                } else if ($result[$i]['Status'] == 'InProcess') {
                                                    echo '<li class="r rd" id="' . $rowno . $result[$i]['Seatno'] . '" ></li>';
                                                }
                                            }
                                        }



                                        if ($cnt == 68) {
                                            echo '</ul></div><div class="seatplan"><ul class="r">';
                                            $cnt = 0;
                                        }
                                    } //ends for loop
                                    ?>
                                </ul>
                            </div>
                            <h1 class="level"><?php echo $ticketsData[$ticketids['Member Entry Pass Level 1']]['name']; ?> (<img src="http://static.meraevents.com/content/images/rupee-icon.gif" width="12" height="12" /> <?php echo $ticketsData[$ticketids['Member Entry Pass Level 1']]['price']; ?>)</h1>
                            <div class="seatplan">
                                <ul class="r">

                                    <?php
                                    $cnt = 0;
                                    $notype2 = isset($calculationDetails['ticketsData'][$ticketids['Member Entry Pass Level 1']]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketids['Member Entry Pass Level 1']]['selectedQuantity'] : 0;
									
									$result1 = $ResSeatslevel1;
                                    for ($i = 0; $i < count($result1); $i++) {
                                        $cnt++;
                                        //$notype2 = 0;
                                        //$notype2 = isset($calculationDetails['ticketsData'][$ticketids['Rows I to J']]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketids['Rows I to J']]['selectedQuantity'] : 0;
                                        $rowno = substr($result1[$i]['GridPosition'], 0, 1);
                                        if ($cnt == 1) {
                                            echo '<li class="ltr">' . $rowno . '</li>';
                                        }

                                        if ((int) $result1[$i]['Seatno'] == 0) {
                                            echo '<li class="b"></li>';
                                        } else {
                                            if ($notype2 == "" || $notype2 == 0) {
                                                echo '<li class="bl x" id="' . $rowno . $result1[$i]['Seatno'] . '" ></li>';
                                            } else {
                                                if ($result1[$i]['Status'] == 'Available') {
                                                    echo '<li class="s bl" onclick="CngClass2(this,' . $notype2 . ',' . $result1[$i]['Id'] . ',' . $eventsignupId . ');" id="' . $rowno . $result1[$i]['Seatno'] . '" title="' . $result1[$i]['Seatno'] . '"></li>';
                                                } else if ($result1[$i]['Status'] == 'Booked') {
                                                    echo '<li class="r rd" id="' . $rowno . $result1[$i]['Seatno'] . '" ></li>';
                                                } else if ($result1[$i]['Status'] == 'Reserved') {
                                                    echo '<li class="b x" id="' . $rowno . $result1[$i]['Seatno'] . '" ></li>';
                                                } else if ($result1[$i]['Status'] == 'InProcess') {
                                                    echo '<li class="r rd" id="' . $rowno . $result1[$i]['Seatno'] . '" ></li>';
                                                }
                                            }
                                        }
                                        ?>





                                        <?php
                                        if ($cnt == 68) {
                                            echo '</ul></div><div class="seatplan"><ul class="r">';
                                            $cnt = 0;
                                        }
                                    } //ends for loop
                                    ?>
                                </ul>
                            </div>
                            <h1 class="level"><?php echo $ticketsData[$ticketids['Member Entry Pass Level 2']]['name']; ?> (<img src="http://static.meraevents.com/content/images/rupee-icon.gif" width="12" height="12"/> <?php echo $ticketsData[$ticketids['Member Entry Pass Level 2']]['price']; ?>)</h1>
                            <div class="seatplan">
                                <ul class="r">

                                    <?php
                                    $notype3 = isset($calculationDetails['ticketsData'][$ticketids['Member Entry Pass Level 2']]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketids['Member Entry Pass Level 2']]['selectedQuantity'] : 0;
								
                                    $cnt = 0;
									$result2 = $ResSeatslevel2;
                                    for ($i = 0; $i < count($result2); $i++) {
                                        //$notype3 = 0;
                                        //$notype3 = isset($calculationDetails['ticketsData'][$ticketids['Rows I to J']]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketids['Rows E to H']]['selectedQuantity'] : 0;
                                        $cnt++;
                                        $rowno = preg_replace("/[0-9]+/","",$result2[$i]['GridPosition']);
                                        if ($cnt == 1) {
                                            echo '<li class="ltr">' . $rowno . '</li>';
                                        }
                                        //var_dump($result2[$i]['Seatno']);
                                        if ($result2[$i]['Seatno'] == 0) {
                                            echo '<li class="b"></li>';
                                        } else {
                                            if ($notype3 == "" || $notype3 == 0) {
                                                echo '<li class="bl x" id="' . $rowno . $result2[$i]['Seatno'] . '" ></li>';
                                            } else {
                                                if ($result2[$i]['Status'] == 'Available') {
                                                    echo '<li class="s bl" onclick="CngClass3(this,' . $notype3 . ',' . $result2[$i]['Id'] . ',' . $eventsignupId . ');" id="' . $rowno . $result2[$i]['Seatno'] . '" title="' . $result2[$i]['Seatno'] . '"></li>';
                                                } else if ($result2[$i]['Status'] == 'Booked') {
                                                    echo '<li class="r rd" id="' . $rowno . $result2[$i]['Seatno'] . '" ></li>';
                                                } else if ($result2[$i]['Status'] == 'Reserved') {
                                                    echo '<li class="b x" id="' . $rowno . $result2[$i]['Seatno'] . '" ></li>';
                                                } else if ($result2[$i]['Status'] == 'InProcess') {
                                                    echo '<li class="r rd" id="' . $rowno . $result2[$i]['Seatno'] . '" ></li>';
                                                }
                                            }
                                        }
                                        ?>





                                        <?php
                                        if ($cnt == 68) {
                                            echo '</ul></div><div class="seatplan"><ul class="r">';
                                            $cnt = 0;
                                        }
                                    } //ends for loop
                                    ?>
                                </ul>
                            </div>
							<h1 class="level"><?php echo $ticketsData[$ticketids['Member Entry Pass Level 4']]['name']; ?> (<img src="http://static.meraevents.com/content/images/rupee-icon.gif" width="12" height="12"/> <?php echo $ticketsData[$ticketids['Member Entry Pass Level 4']]['price']; ?>)</h1>
                            <div class="seatplan">
                                <ul class="r">

                                    <?php
                                    $notype4 = isset($calculationDetails['ticketsData'][$ticketids['Member Entry Pass Level 4']]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketids['Member Entry Pass Level 4']]['selectedQuantity'] : 0;
									
                                    $cnt = 0;
									$result3 = $ResSeatslevel4;
                                    for ($i = 0; $i < count($result3); $i++) {
                                        //$notype3 = 0;
                                        //$notype3 = isset($calculationDetails['ticketsData'][$ticketids['Rows K to M']]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketids['Rows E to H']]['selectedQuantity'] : 0;
                                        $cnt++;
                                        $rowno = preg_replace("/[0-9]+/","",$result3[$i]['GridPosition']);
                                        if ($cnt == 1) {
                                            echo '<li class="ltr">' . $rowno . '</li>';
                                        }
                                        //var_dump($result3[$i]['Seatno']);
                                        if ($result3[$i]['Seatno'] == 0) {
                                            echo '<li class="b"></li>';
                                        } else {
                                            if ($notype4 == "" || $notype4 == 0) {
                                                echo '<li class="bl x" id="' . $rowno . $result3[$i]['Seatno'] . '" ></li>';
                                            } else {
                                                if ($result3[$i]['Status'] == 'Available') {
                                                    echo '<li class="s bl" onclick="CngClass4(this,' . $notype4 . ',' . $result3[$i]['Id'] . ',' . $eventsignupId . ');" id="' . $rowno . $result3[$i]['Seatno'] . '" title="' . $result3[$i]['Seatno'] . '"></li>';
                                                } else if ($result3[$i]['Status'] == 'Booked') {
                                                    echo '<li class="r rd" id="' . $rowno . $result3[$i]['Seatno'] . '" ></li>';
                                                } else if ($result3[$i]['Status'] == 'Reserved') {
                                                    echo '<li class="b x" id="' . $rowno . $result3[$i]['Seatno'] . '" ></li>';
                                                } else if ($result3[$i]['Status'] == 'InProcess') {
                                                    echo '<li class="r rd" id="' . $rowno . $$result3[$i]['Seatno'] . '" ></li>';
                                                }
                                            }
                                        }
                                        ?>





                                        <?php
                                        if ($cnt == 68) {
                                            echo '</ul></div><div class="seatplan"><ul class="r">';
                                            $cnt = 0;
                                        }
                                    } //ends for loop
                                    ?>
                                </ul>
                            </div>
							<h1 class="level"><?php echo $ticketsData[$ticketids['Member Entry Pass Level 5']]['name']; ?> (<img src="http://static.meraevents.com/content/images/rupee-icon.gif" width="12" height="12"/> <?php echo $ticketsData[$ticketids['Member Entry Pass Level 5']]['price']; ?>)</h1>
                            <div class="seatplan">
                                <ul class="r">

                                    <?php
                                    $notype5 = isset($calculationDetails['ticketsData'][$ticketids['Member Entry Pass Level 5']]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketids['Member Entry Pass Level 5']]['selectedQuantity'] : 0;
									
                                    $cnt = 0;
									$result4 = $ResSeatslevel5;
                                    for ($i = 0; $i < count($result4); $i++) {
                                        //$notype3 = 0;
                                        //$notype3 = isset($calculationDetails['ticketsData'][$ticketids['Rows N to P']]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketids['Rows E to H']]['selectedQuantity'] : 0;
                                        $cnt++;
                                        $rowno = preg_replace("/[0-9]+/","",$result4[$i]['GridPosition']);
                                        if ($cnt == 1) {
                                            echo '<li class="ltr">' . $rowno . '</li>';
                                        }
                                        //var_dump($result4[$i]['Seatno']);
                                        if ($result4[$i]['Seatno'] == 0) {
                                            echo '<li class="b"></li>';
                                        } else {
                                            if ($notype5 == "" || $notype5 == 0) {
                                                echo '<li class="bl x" id="' . $rowno . $result4[$i]['Seatno'] . '" ></li>';
                                            } else {
                                                if ($result4[$i]['Status'] == 'Available') {
                                                    echo '<li class="s bl" onclick="CngClass5(this,' . $notype5 . ',' . $result4[$i]['Id'] . ',' . $eventsignupId . ');" id="' . $rowno . $result4[$i]['Seatno'] . '" title="' . $result4[$i]['Seatno'] . '"></li>';
                                                } else if ($result4[$i]['Status'] == 'Booked') {
                                                    echo '<li class="r rd" id="' . $rowno . $result4[$i]['Seatno'] . '" ></li>';
                                                } else if ($result4[$i]['Status'] == 'Reserved') {
                                                    echo '<li class="b x" id="' . $rowno . $result4[$i]['Seatno'] . '" ></li>';
                                                } else if ($result4[$i]['Status'] == 'InProcess') {
                                                    echo '<li class="r rd" id="' . $rowno . $result4[$i]['Seatno'] . '" ></li>';
                                                }
                                            }
                                        }
                                        ?>





                                        <?php
                                        if ($cnt == 68) {
                                            echo '</ul></div><div class="seatplan"><ul class="r">';
                                            $cnt = 0;
                                        }
                                    } //ends for loop
                                    ?>
                                </ul>
                            </div>
							<h1 class="level"><?php echo $ticketsData[$ticketids['Member Entry Pass Level 6']]['name']; ?> (<img src="http://static.meraevents.com/content/images/rupee-icon.gif" width="12" height="12"/> <?php echo $ticketsData[$ticketids['Member Entry Pass Level 6']]['price']; ?>)</h1>
                            <div class="seatplan">
                                <ul class="r">

                                    <?php
                                   $notype6 = isset($calculationDetails['ticketsData'][$ticketids['Member Entry Pass Level 6']]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketids['Member Entry Pass Level 6']]['selectedQuantity'] : 0;
									
                                    $cnt = 0;
									$result5 = $ResSeatslevel6;
                                    for ($i = 0; $i < count($result5); $i++) {
                                        //$notype3 = 0;
                                        //$notype3 = isset($calculationDetails['ticketsData'][$ticketids['Rows Q to S']]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketids['Rows E to H']]['selectedQuantity'] : 0;
                                        $cnt++;
                                        $rowno = preg_replace("/[0-9]+/","",$result5[$i]['GridPosition']);
                                        if ($cnt == 1) {
                                            echo '<li class="ltr">' . $rowno . '</li>';
                                        }
                                        //var_dump($result5[$i]['Seatno']);
                                        if ($result5[$i]['Seatno'] == 0) {
                                            echo '<li class="b"></li>';
                                        } else {
                                            if ($notype6 == "" || $notype6 == 0) {
                                                echo '<li class="bl x" id="' . $rowno . $result5[$i]['Seatno'] . '" ></li>';
                                            } else {
                                                if ($result5[$i]['Status'] == 'Available') {
                                                    echo '<li class="s bl" onclick="CngClass6(this,' . $notype6 . ',' . $result5[$i]['Id'] . ',' . $eventsignupId . ');" id="' . $rowno . $result5[$i]['Seatno'] . '" title="' . $result5[$i]['Seatno'] . '"></li>';
                                                } else if ($result5[$i]['Status'] == 'Booked') {
                                                    echo '<li class="r rd" id="' . $rowno . $result5[$i]['Seatno'] . '" ></li>';
                                                } else if ($result5[$i]['Status'] == 'Reserved') {
                                                    echo '<li class="b x" id="' . $rowno . $result5[$i]['Seatno'] . '" ></li>';
                                                } else if ($result5[$i]['Status'] == 'InProcess') {
                                                    echo '<li class="r rd" id="' . $rowno . $result5[$i]['Seatno'] . '" ></li>';
                                                }
                                            }
                                        }
                                        ?>





                                        <?php
                                        if ($cnt == 68) {
                                            echo '</ul></div><div class="seatplan"><ul class="r">';
                                            $cnt = 0;
                                        }
                                    } //ends for loop
                                    ?>
                                </ul>
                            </div>
							<h1 class="level"><?php echo $ticketsData[$ticketids['Member Entry Pass Level 7']]['name']; ?> (<img src="http://static.meraevents.com/content/images/rupee-icon.gif" width="12" height="12"/> <?php echo $ticketsData[$ticketids['Member Entry Pass Level 7']]['price']; ?>)</h1>
                            <div class="seatplan">
                                <ul class="r">

                                    <?php
                                   $notype7 = isset($calculationDetails['ticketsData'][$ticketids['Member Entry Pass Level 7']]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketids['Member Entry Pass Level 7']]['selectedQuantity'] : 0;
									$cnt = 0;
									$result6 = $ResSeatslevel7;
                                    for ($i = 0; $i < count($result6); $i++) {
                                        //$notype3 = 0;
                                        //$notype3 = isset($calculationDetails['ticketsData'][$ticketids['Rows T to X']]['selectedQuantity']) ? $calculationDetails['ticketsData'][$ticketids['Rows E to H']]['selectedQuantity'] : 0;
                                        $cnt++;
                                        $rowno = preg_replace("/[0-9]+/","",$result6[$i]['GridPosition']);
                                        if ($cnt == 1) {
                                            echo '<li class="ltr">' . $rowno . '</li>';
                                        }
                                        //var_dump($result6[$i]['Seatno']);
                                        if ($result6[$i]['Seatno'] == 0) {
                                            echo '<li class="b"></li>';
                                        } else {
                                            if ($notype7 == "" || $notype7 == 0) {
                                                echo '<li class="bl x" id="' . $rowno . $result6[$i]['Seatno'] . '" ></li>';
                                            } else {
                                                if ($result6[$i]['Status'] == 'Available') {
                                                    echo '<li class="s bl" onclick="CngClass7(this,' . $notype7 . ',' . $result6[$i]['Id'] . ',' . $eventsignupId . ');" id="' . $rowno . $result6[$i]['Seatno'] . '" title="' . $result6[$i]['Seatno'] . '"></li>';
                                                } else if ($result6[$i]['Status'] == 'Booked') {
                                                    echo '<li class="r rd" id="' . $rowno . $result6[$i]['Seatno'] . '" ></li>';
                                                } else if ($result6[$i]['Status'] == 'Reserved') {
                                                    echo '<li class="b x" id="' . $rowno . $result6[$i]['Seatno'] . '" ></li>';
                                                } else if ($result6[$i]['Status'] == 'InProcess') {
                                                    echo '<li class="r rd" id="' . $rowno . $result6[$i]['Seatno'] . '" ></li>';
                                                }
                                            }
                                        }
                                        ?>





                                        <?php
                                        if ($cnt == 68) {
                                            echo '</ul></div><div class="seatplan"><ul class="r">';
                                            $cnt = 0;
                                        }
                                    } //ends for loop
                                    ?>
                                </ul>
                            </div>
                            <div align="center">
                                <input type="button" name="SubmitAttendee" value="Confirm Seats"  onclick="return validat_reg_form('<?= $eventsignupId; ?>',<?php echo round($calculationDetails['ticketsData'][$ticketids['Member Entry Pass Level 1']]['selectedQuantity'] + $calculationDetails['ticketsData'][$ticketids['Member Entry Pass Level 2']]['selectedQuantity'] + $calculationDetails['ticketsData'][$ticketids['Member Entry Pass Level 3']]['selectedQuantity'] + $calculationDetails['ticketsData'][$ticketids['Member Entry Pass Level 4']]['selectedQuantity'] + $calculationDetails['ticketsData'][$ticketids['Member Entry Pass Level 5']]['selectedQuantity'] + $calculationDetails['ticketsData'][$ticketids['Member Entry Pass Level 6']]['selectedQuantity'] + $calculationDetails['ticketsData'][$ticketids['Member Entry Pass Level 7']]['selectedQuantity']); ?>);"id="signin_submit" class="processbutton" style="margin:15px;" />
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