<html>
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
    <script src="js/jquery-2.2.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/moment.js"></script>
    <script src="js/bootstrap-datetimepicker.js"></script>
</head>

<body>
<hr>
<?php
    echo(!empty($_SESSION['usermessage']) ? ($_SESSION['usermessage']) : '');
    $_SESSION['usermessage'] = '';
?>
<hr>