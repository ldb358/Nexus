<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $this->site_name; ?> - Admin Panel</title>
    <link href='<?php echo $this->lpath; ?>styles/style.css' rel='stylesheet' media='all' />
    <script type='text/javascript' src='<?php echo $this->lpath; ?>js/jquery-1.4.2.min.js'></script>
    <script type='text/javascript' src='<?php echo $this->lpath; ?>js/jquery-ui-1.8.5.custom.min.js'></script>
    <script type='text/javascript' src='<?php echo $this->lpath; ?>js/confirm.js'></script>
    <script type='text/javascript' src='<?php echo $this->lpath; ?>js/actions.js'></script>
</head>
<body>
    <div id="header">
        <div id="nexuslogo">
            <img src='<?php echo $this->lpath ?>images/nexuslogo.png' alt='nexus' />
            <div class='sitename'>
                <h1><a href='<?php echo $this->get_url(); ?>'><?php echo $this->site_name; ?></a></h1>
            </div>
        </div><!-- end #nexuslogo -->
        <div id="quick">
            <div id="logout">
                <a href='<?php echo $this->reroute->get_route('user', 'logout'); ?>'>Logout</a>
            </div>
            <div id="user">
                <h5>Hello, <?php echo $this->module('user')->get_user(); ?></h5>
            </div>
        </div>
        <div id="nav">
            <a <?php if($this->control->method == 'default') echo 'class="current"'; ?> href="<?php echo $this->reroute->get_route('admin', 'default'); ?>"><img src="<?php echo $this->lpath ?>images/1.png" alt="control panel" /></a>
            <img class="spacer" src="<?php echo $this->lpath ?>images/div.png" alt="div" />
            <a <?php if($this->control->method == 'community') echo 'class="current"'; ?> href="<?php echo $this->reroute->get_route('admin', 'community'); ?>"><img src="<?php echo $this->lpath ?>images/2.png" alt="your site" /></a>
            <img class="spacer" src="<?php echo $this->lpath ?>images/div.png" alt="div" />
            <a <?php if($this->control->method == 'media') echo 'class="current"'; ?> href="<?php echo $this->reroute->get_route('admin', 'media'); ?>"><img src="<?php echo $this->lpath ?>images/3.png" alt="media" /></a>
            <img class="spacer" src="<?php echo $this->lpath ?>images/div.png" alt="div" />
            <a <?php if($this->control->method == 'socialmedia') echo 'class="current"'; ?> href="<?php echo $this->reroute->get_route('admin', 'socialmedia'); ?>"><img src="<?php echo $this->lpath ?>images/4.png" alt="social media" /></a>
            <img class="spacer" src="<?php echo $this->lpath ?>images/div.png" alt="div" />
            <a <?php if($this->control->method == 'university') echo 'class="current"'; ?> href="<?php echo $this->reroute->get_route('admin', 'university'); ?>"><img src="<?php echo $this->lpath ?>images/5.png" alt="university mail" /></a>
            <img class="spacer" src="<?php echo $this->lpath ?>images/div.png" alt="div" />
            <a <?php if($this->control->method == 'appearance') echo 'class="current"'; ?> href="<?php echo $this->reroute->get_route('admin', 'appearance'); ?>"><img src="<?php echo $this->lpath ?>images/6.png" alt="appearance" /></a>
            <img class="spacer" src="<?php echo $this->lpath ?>images/div.png" alt="div" />
            <a <?php if($this->control->method == 'page') echo 'class="current"'; ?> href="<?php echo $this->reroute->get_route('admin', 'page'); ?>"><img src="<?php echo $this->lpath ?>images/7.png" alt="pages" /></a>
            <img class="spacer" src="<?php echo $this->lpath ?>images/div.png" alt="div" />
            <a <?php if($this->control->method == 'feedback') echo 'class="current"'; ?> href="<?php echo $this->reroute->get_route('admin', 'feedback'); ?>"><img src="<?php echo $this->lpath ?>images/8.png" alt="feedback" /></a>
            <img class="spacer" src="<?php echo $this->lpath ?>images/div.png" alt="div" />
            <a <?php if($this->control->method == 'manager') echo 'class="current"'; ?> href="<?php echo $this->reroute->get_route('admin', 'manager'); ?>"><img src="<?php echo $this->lpath ?>images/9.png" alt="proman" /></a>
        </div><!-- end #nav -->
    </div><!-- end #header -->
    <div id="cpinfo">
        <p class="cpinfo-left">
            WHAT IS THE CONTROL PANEL? The control panel is the well.. the control panel of the nexus.It allows you to easily upload, edit, manage your content and alows for a completely customizable product. 
        </p>
        <p class="cpinfo-right">
            TIP OF THE DAY: CONSISTENCY. When creating your portfolio you must always keep your media in mind because a consistent portfolio is a happy portfolio! :) 1/6/11 
        </p>
    </div> <!-- end cpinfo -->