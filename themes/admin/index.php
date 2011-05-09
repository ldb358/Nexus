<?php $this->get('header'); ?>
<div class='maincontents'>
    <?php
    $widgets = $this->get_widgets();
    $widgets_1 = array_slice($widgets,0,ceil(count($widgets)/2));
    $widgets_2 = array_slice($widgets,ceil(count($widgets)/2),floor(count($widgets)/2));
    ?>
    <div class='col'>
    <?php foreach($widgets_1 as $widget): ?>
        <div class='content contentcollapse'>
            <h4 class='cheader'><?php echo $widget->get_header(); ?></h4>
            <div class='contents'><?php echo $widget->get_body(); ?></div>
        </div>  
    <?php endforeach; ?>
    </div>
    <div class='col'>
    <?php foreach($widgets_2 as $widget): ?>
        <div class='content contentcollapse'>
            <h4 class='cheader'><?php echo $widget->get_header(); ?></h4>
            <div class='contents'><?php echo $widget->get_body(); ?></div>
        </div>      
    <?php endforeach; ?>
    </div>
</div>
</body>
</html>