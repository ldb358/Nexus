<?php $this->get('header'); ?>
<div class='maincontents'>
    <?php //var_dump($this->get_widgets()); ?>
    <?php foreach($this->get_widgets() as $widget): ?>
    <div class='col'>
        <div class='content contentcollapse'>
            <h4 class='cheader'><?php echo $widget->get_header(); ?></h4>
            <div class='contents'><?php echo $widget->get_body(); ?></div>
        </div>  
    </div>
    <?php endforeach; ?>
</div>
</body>
</html>