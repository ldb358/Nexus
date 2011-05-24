<?php
if(!defined('__nexus')){
    header("HTTP/1.0 404 not found");
    $redirect = new reroute();
    $redirect->route('error', '404');
}
$this->get('header');
?>
	<div id='main'>
		<div id="body">
			<div class='slider'>
				<div id='slidemask'>
					<div id="sliderimages">
						
					</div>
				</div>
				<span class='tl'></span>
				<span class='tr'></span>
				<span class='bl'></span>
				<span class='br'></span>
				<div class='buttonsbar'>
					<div class='buttons'>
					</div>
				</div>
			</div>
			<div class='maincontent'>
				<div class="icons">
					<div class='col'>
						<img src='<?php echo $this->lpath; ?>images/web.png' alt='Web' />
					</div>
					<div class='col'>
						<img src='<?php echo $this->lpath; ?>images/wordpress.png' alt='Web' />
					</div>
					<div class='col'>
						<img src='<?php echo $this->lpath; ?>images/checkmark.png' alt='Web' />
					</div>	
				</div>
				<span class='border'></span>
				<div class='col'>
					<?php echo $this->control->get_site_option('home_1'); ?>
				</div>
				<div class='col'>
					<?php echo $this->control->get_site_option('home_2'); ?>
				</div>
				<div class='col'>
					<?php echo $this->control->get_site_option('home_3'); ?>
				</div><br />
				<div id='blogindex'>
					<div class='blogdiv'>New From the Blog:</div>
					
					<?php
					$user = new user(true);
					$user_level = $user->get_user_info('level');
					if(!filter_var($user_level, FILTER_VALIDATE_INT)){
						$user_level = 10;
					}
					$feed = $this->module('feed')->level($user_level)->get_feed('post')->limit(2)->execute();
					foreach($feed->get_feed_objects() as $post):
						?>
						<div class='blogcolindex'>
							<h4><?php echo $post->get_title(); ?></h4>
							<?php echo $post->get_desc(); ?>
							</div><?php
					endforeach;
					?>
				</div>
				<!--
				<div id='twitterfeed'>
					<div class="twitterheader">Our Twitter Feed:</div>
					<span class='tweet'>Hello <b>at 4:50pm </b></span>
					<span class='tweet'>This is a test <b>at 4:50pm </b></span>
					<span class='tweet'>this is a live twitter feed that will use ajax to update so that you can see what i tweet <b>at 11:09am</b></span>
				</div>
				-->
			</div>
		</div>
	</div>
	<div id="footer">
		<div class='center'>
			<div id='footerfollow'>Follow us:</div>
			<ul id="followimages">
				<li><img src='<?php echo $this->lpath; ?>images/rss.png' alt='follow our rss feed' /></li>
				<li><img src='<?php echo $this->lpath; ?>images/facebook.png' alt='follow on facebook' /></li>
				<li><img src='<?php echo $this->lpath; ?>images/twitter.png' alt='follow on twitter' /></li>
			</ul>
			<div id='copyright'>Copyright &copy; <?php echo date('Y') ?> Lane Breneman</div>
		</div>
	</div>
	<script type="text/javascript">$('body').pngFix();</script>
</body>
</html>
