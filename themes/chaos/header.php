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
	<title><?php echo "{$this->site_name} - {$this->control->get_title()}"; ?></title>
	<link href='<?php echo $this->lpath; ?>style.css' type='text/css' rel='stylesheet' />
	<script src='<?php echo $this->lpath; ?>js/jquery.js' type='text/javascript'></script>
	<script src='<?php echo $this->lpath; ?>js/jquery.supersleight-min.js' type='text/javascript'></script>
	<script src='<?php echo $this->lpath; ?>js/jquery.pngFix.js' type='text/javascript'></script>
	<script type='text/javascript'> var base = '<?php echo $this->lpath; ?>'; </script>
	<!--[if !(ie 6)]>
	<script src='<?php echo $this->lpath; ?>js/bgload.js' type='text/javascript'></script>
	<![endif]-->
	<!--[if ie 7]>
	<link href='<?php echo $this->lpath; ?>ie7.css' type='text/css' rel='stylesheet' />
	<![endif]-->
	<script src='<?php echo $this->lpath; ?>js/actions.js' type='text/javascript'></script>
</head>
<body>
	<div id="header">
		 	<div class='center'>
				<h1><?php echo $this->site_name; ?></h1><h2> <?php echo $this->control->get_site_option('slogan'); ?></h2>
				<div id="linksdiv">
					<ul id="links">
						<?php
                        //get the current user info
                            @include_once '/modules/user/user.class.php';
                            $user = new user(true);
                            $user_level = $user->get_user_info('level');
                            if(!filter_var($user_level, FILTER_VALIDATE_INT)){
                                $user_level = 10;
                            }
                            $dbprefix = DBPREFIX;
                            $feed = $this->module('feed')->get_feed('page')->level($user_level)->order_by("{$dbprefix}page.id")->execute();
                            foreach($feed->get_feed_objects() as $post):
                            ?>
								<li>
									<?php if($this->control->get_title() == $post->get_title()){
									echo "<span class='current'></span>";
									} ?>
									<a href=' <?php echo $this->reroute->get_route('page', $post->get_id()); ?>'><?php echo $post->get_title(); ?></a>
								</li>
                            <?php
							endforeach;
                        ?>
					</ul>
				</div>
			</div>
	</div>