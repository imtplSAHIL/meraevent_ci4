<div class="page-container">
    <div class="wrap">
        <div class="container print_ticket" style="padding: 50px 0px; height: 450px">
            <div class="row">
                <div class="col-lg-4 col-md-4 order_summary">
                    <div class="ShareEarn">
                        <h2>Your Membership is Confirmed</h2>
                        <!-- <h2>You are going to Entertainment Category</h2> -->
                        <p>Your order has been saved to my memberships</p>
                        <p id="sendsuccess" style=" text-align: center;padding: 0;margin: 10px 0;">
                        </p>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 order_summary">
                    <h1>Order Summary</h1>
                    Dear <?php echo ucfirst($confirmationData['userName']); ?>, Your registered successfully for the membership of <b><?php echo ucfirst($confirmationData['chapterName']); ?>.</b> <br>
                    Your Membership Valids from <?php echo date("d-F-Y", strtotime($confirmationData['validfrom'])); ?> upto <?php if($confirmationData['type'] == 'lifetime'){ echo "lifetime"; }else{echo date("d-F-Y", strtotime($confirmationData['validto']));} ?><br>
                    Your Registration Number : <?php echo $confirmationData['signupid']; ?><br/>
                    Total Amount Paid : INR: <?php echo $confirmationData['totalamount']; ?>
                </div>
            </div>
        </div>
    </div>
</div>