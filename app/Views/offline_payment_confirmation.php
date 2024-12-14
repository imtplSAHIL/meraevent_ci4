
<?php $this->load->view('includes/header');?>

<div class="page-container">
    <div class="wrap">
        <div class="container print_ticket" style="border: 1px solid black; border-radius: 5px; box-shadow: 1px 1px 16px 1px #ddd;">
            <div class="row">
                <div class="order_summary">
                    <div class="ShareEarn">
                        <h2 style="text-align: center;">Your payment is pending.</h2>
                        <p>Thank you for registering. The invoice has been sent to you on your registered email id <span style="color:blue;"><?php echo $purchaserDetails['email_id']; ?></span>. Request you to complete the payment to confirm your registration.</p>
                    </div>
                </div>
            </div>
          </div>
    </div>
</div>

<script type="text/javascript" language="javascript">
    var event_url = "<?php echo urlencode($viralticketUrl);?>";
</script>
<?php $this->load->view('includes/footer');?>