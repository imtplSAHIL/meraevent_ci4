<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CSV Data Preview</title>
</head>
<body>
    <h1>CSV Data Preview</h1>
    <p>Total Rows: <?php echo count($data); ?></p>
    
    <form method="post" action="<?php echo site_url('csv/send_email'); ?>">
    <table border="1">
        <?php foreach ($data as $row): ?>
            <tr>
                <?php foreach ($row as $cell): ?>
                    <td><?php echo htmlspecialchars($cell); ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>
    <input type="hidden" name="data" value='<?php echo htmlspecialchars(json_encode($data)); ?>' />
    <input type="submit" value="Send Email">
</form>



    <a href="<?php echo site_url('csv/upload_form'); ?>">Upload Another File</a>
</body>
</html>
