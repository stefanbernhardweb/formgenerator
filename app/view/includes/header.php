

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data["title"]; ?></title>

    <!-- CSS Imports -->
    <link rel="stylesheet" href="<?php echo $data["path"]; ?>vendor/jqueryui/jquery-ui.min.css">
    <link rel="stylesheet" href="<?php echo $data["path"]; ?>vendor/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?php echo $data["path"]; ?>vendor/bootstrap/css/bootstrap.css">
    <?php echo $data["css"]; ?>
    
    <!-- JS Imports -->
    <script src="<?php echo $data["path"]; ?>vendor/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo $data["path"]; ?>vendor/jqueryui/jquery-ui.min.js"></script>
    <script src="<?php echo $data["path"]; ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <?php echo $data["js"]; ?>

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
    
