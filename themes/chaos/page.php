<?php if($this->control->get_title() == 'home'){ $this->get('index'); exit(); } ?>
<?php $this->get('header'); ?>
    <div id='main'>
		<div id="body">
            <?php echo $this->control->get_contents(); ?>
			<?php
			$user = new user(true);
			$user_level = $user->get_user_info('level');
			if(!filter_var($user_level, FILTER_VALIDATE_INT)){
				$user_level = 10;
			}
			$feed = $this->module('feed')->level($user_level)->get_feed('media')->type('image')->limit(3)->execute();
			foreach($feed->get_feed_objects() as $image):
				?>
				<div class='blogcolindex'>
					<h4><?php echo $image->get_title(); ?></h4>
					<?php echo $image->get_embed('300'); ?>
					</div><?php
			endforeach;
			?>
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
</body>
</html>