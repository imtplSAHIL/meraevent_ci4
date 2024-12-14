<style>
#preview {
  max-height: 400px;  /* Adjust the height based on your needs */
  overflow-y: auto;   /* Enables vertical scrolling */
}
</style>
<div class="rightArea">
     <?php  
        $guestListBookingFlashMessage=$this->customsession->getData('guestListBookingSuccessMessage');
        $this->customsession->unSetData('guestListBookingSuccessMessage');
        $errorUrl = $this->customsession->getData('errorCsvFile');
    ?>
    
    <?php if($guestListBookingFlashMessage){?>
        <div class="db-alert db-alert-success flashHide">
            <strong>  <?php echo $guestListBookingFlashMessage; ?></strong> 
        </div>
    <?php }?>   
                 <?php if(isset($messages)){?>
                <?php if($status == false) { ?>
                <div id="Message" class="db-alert db-alert-danger flashHide">
            <strong>  <?php echo $messages;?></strong>  </div> 
             <?php } ?>
                       
        <?php }?>  
    <?php //if(isset($errorUrl) && $errorUrl!=''){?>
            
          <?php //}?>
    <style>
    .dots-loader {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 5px;  /* Space between dots */
  padding:10px;
}

.dots-loader span {
  display: block;
  width: 8px;  /* Size of each dot */
  height: 8px; /* Size of each dot */
  border-radius: 50%;
  background-color: white; /* White color for dots */
  animation: dot-blink 1.5s infinite ease-in-out;
}

.dots-loader span:nth-child(1) {
  animation-delay: 0s;
}

.dots-loader span:nth-child(2) {
  animation-delay: 0.3s;
}

.dots-loader span:nth-child(3) {
  animation-delay: 0.6s;
}

@keyframes dot-blink {
  0%, 100% {
    opacity: 0;
  }
  50% {
    opacity: 1;
  }
}

    </style>
    <div class="heading">
        <h2>Bulk Booking : <?php echo  $eventName;?><span><?php if(isset($errorUrl) && $errorUrl!=''){?>
            <a href="#" style="color: #bb1818; padding-left: 25px;" class="downlond_error_csv" id="downlond_error_csv">Download Error CSV File</a>
            <input type="hidden" name="errorcsvfile" id="downloaderrorcsv" value="<?php echo $errorUrl; ?>">
        <?php $this->customsession->unSetData('errorCsvFile'); }?></span></h2>
    </div>
    <!--Data Section Start-->

    <div class="fs-form">
        <h2 class="fs-box-title">Bulk Booking</h2>
        <div class="editFields">
        <form enctype="multipart/form-data" method="post" name="guestlistbooking" id="guestlistbooking" action=''>
     <input type="hidden" name="eventId" id="eventId" class="eventId" value="<?php echo $eventId; ?>">
            <div class="clearBoth"></div>

            <label>Ticket Type <span class="mandatory">*</span></label>
            <label>
                <span style="top:10px;" class="float-left icon-downarrow"></span>
                <select id="ticketId" name="ticketId" class="events_ticket">
                    <option value="">Select Ticket</option>
                    <?php foreach ($tickets as $ticket) { ?>
                        <option value="<?php echo $ticket['id']; ?>"> <?php echo $ticket['name']; ?></option>
                    <?php } ?>
                </select>
            </label>
            <div id="filedownloadcontent" class="filedownloadcontent" style="display:none;">
                <div class="download_link" id="download_link" ><a href="#" style="color: #0000FF;">Download sample csv file here</a></div>
                <label>CSV File <span class="mandatory">*</span></label>
                <input type="file" name="csvfile" id="csvfile" class="textfield">
                <div id="preview"></div>
                <div id="record_count"></div>
                <input type="hidden" name="data" value='' id="data" />
 
                <button id="upload_btn" type="button" class="createBtn float-right">Preview</button>

                <input type="submit" onclick="changeTextAndSubmit(this)" style="display:none;" name="guestBooking" id="guestBooking" class="createBtn float-right" value="Upload"/>
                <span id="loadingbulk" style="display:none;margin-right: -71px;" class="createBtn float-right"></span>
            </div>
        </form>


            <input type="hidden" id="downloadsamplecsv" class="downloadsamplecsv">
    </div>
    </div>
</div>
</div>

<script>
var api_bookingOfflineBooking = "<?php echo commonHelperGetPageUrl('api_bookingOfflineBooking');?>";
var api_getTicketCalculation = "<?php echo commonHelperGetPageUrl('api_getTicketCalculation');?>";
var api_promoteattendeeSampleCsv = "<?php echo commonHelperGetPageUrl('api_promoteattendeeSampleCsv');?>";
var api_promotedownloadattendeeSampleCsv = "<?php echo commonHelperGetPageUrl('api_promotedownloadattendeeSampleCsv');?>";
</script>

<script>
       $(document).ready(function() {
    $('#upload_btn').click(function() {
        var file_data = $('#csvfile').prop('files')[0];
        if (!file_data) {
            alert("Please select a file first.");
            return;
        }

        var reader = new FileReader();
        reader.onload = function(event) {
            var csvContent = event.target.result;
            var rows = csvContent.split('\n');
            var data = [];
            var isFirstRow = true;

            rows.forEach(function(row) {
                if (isFirstRow) {
                    isFirstRow = false; // Skip header row
                    return;
                }

                var columns = row.split(',');
                if (columns.length >= 8) { // Minimum number of columns needed
                    data.push({
                        fullName: columns[0],
                        email: columns[1],
                        mobile: columns[2],
                        city: columns[3],
                        companyName: columns[4],
                        designation: columns[5],
                        quantity: columns[6],
                        discountCode: columns[7]
                    });
                }
            });

            if (data.length > 0) {
                var table = '<table> <thead> <tr> <th>Sno</th> <th>Full Name</th> <th>Email Id</th> <th>Mobile No</th> <th>City</th> <th>Company Name</th> <th>Designation</th> <th>Quantity</th> <th>Discount Code</th> </tr> </thead> <tbody>';
                var maxRows = Math.min(data.length, 11);

                for (var i = 0; i < maxRows; i++) {
                    var row = data[i];
                    table += '<tr>';
                    table += '<td>' + (i + 1) + '</td>';
                    table += '<td>' + row.fullName + '</td>';
                    table += '<td>' + row.email + '</td>';
                    table += '<td>' + row.mobile + '</td>';
                    table += '<td>' + row.city + '</td>';
                    table += '<td>' + row.companyName + '</td>';
                    table += '<td>' + row.designation + '</td>';
                    table += '<td>' + row.quantity + '</td>';
                    table += '<td>' + row.discountCode + '</td>';
                    table += '</tr>';
                }
                table += '</tbody></table>';

                $('#preview').html(table);
                $('#record_count').text('Total Records: ' + data.length);
                $('#upload_btn').hide();
                
                $('#guestBooking').show();
                $('#save_btn').data('csvData', JSON.stringify(data));
            } else {
                alert("No valid data found in the CSV file.");
            }
        };

        reader.readAsText(file_data);
    });

    $('#save_btn').click(function() {
        var csvData = $(this).data('csvData');

        $.ajax({
            url: '<?php echo site_url("samplecsv/saveData"); ?>',
            type: 'POST',
            data: { data: csvData },
            success: function(response) {
                var result = JSON.parse(response);
                alert(result.message);
            }
        });
    });
});
function changeTextAndSubmit(button) {
    $(button).css('opacity','0');
$('#loadingbulk').html('<div class="dots-loader"> <span></span> <span></span> <span></span> </div>');
$('#loadingbulk').css('display','block');

}
    </script>