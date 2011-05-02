<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $this->title; ?></title>
</head>
<body>
    <?php
        echo $this->error;
        if(isset($this->form)){
            echo $this->form;
        }
    ?>
</body>
</html>