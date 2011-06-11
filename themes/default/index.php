<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            <?php echo "{$this->site_name} - {$this->control->get_title()}"; ?>
        </title>
        <link href='<?php echo $this->lpath; ?>style.css' rel='stylesheet' />
    </head>
    <body>
        <?php
            echo "hello ".$this->module('user')->get_user()."<br />";
        ?>
        <h3><?php echo $this->control->get_title(); ?></h1>
        <p><?php echo $this->control->get_contents(); ?></p>
        <?php
        $feed = $this->module('feed')->get_feed('media')
            ->level(10)->has_value('users', 'firstname', 'lane')
            ->type('image')->execute();
        foreach($feed->get_feed_objects() as $post):
            ?><h4><?php echo $post->get_title(); ?></h4>
            <?php echo $post->get_embed();
        endforeach;
        ?>
        <img src='<?php echo $this->lpath; ?>images/businesscards.jpg' alt='The Developer' />
    </body>
</html>
