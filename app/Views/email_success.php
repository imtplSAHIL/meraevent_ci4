<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Sent</title>
</head>
<body>
    <h1>Email Sent</h1>
    <p><?php echo $emailCount; ?> email(s) have been sent successfully!</p>
    <a href="<?php echo site_url('csv'); ?>">Upload Another File</a>
</body>
</html>
