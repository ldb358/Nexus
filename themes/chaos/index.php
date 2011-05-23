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
					<div class='blogcolindex'>
					<h4>Why this theme is simply the best!</h4>
					ac odio ut erat laoreet sollicitudin ut vitae est. Sed non nibh eget purus porta ultrices ut at nisi.
					Vestibulum dictum eros nec neque tristique et tristique nulla dictum. Aenean ornare ligula ac tellus sodales convallis. Donec
					mauris dolor, malesuada nec sodales et, rutrum in mi...</div>
					<div class='blogcolindex'><h4>This is the Stright off the blog</h4>Nullam massa augue, sagittis non hendrerit nec, facilisis id massa.
					Donec eget dolor dolor. Donec placerat ullamcorper elit nec lacinia. In semper diam quis enim pretium fermentum. Nunc laoreet, velit
					sed adipiscing convallis, dui eros tincidunt felis, at porta sapien sapien posuere nunc. </div>
				</div>
				<div id='twitterfeed'>
					<div class="twitterheader">Our Twitter Feed:</div>
					<span class='tweet'>Hello <b>at 4:50pm </b></span>
					<span class='tweet'>This is a test <b>at 4:50pm </b></span>
					<span class='tweet'>this is a live twitter feed that will use ajax to update so that you can see what i tweet <b>at 11:09am</b></span>
				</div>
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
