<?php if($this->control->get_title() == 'home'){ $this->get('index'); exit(); }
<?php $this->get('header'); ?>
    <div id='main'>
		<div id="body">
            
        </div>
    </div>
    <div id="footer">
        <div class='center'>
			<div id='footerfollow'>Follow us:</div>
			<ul id="followimages">
				<li><img src='images/rss.png' alt='follow our rss feed' /></li>
				<li><img src='images/facebook.png' alt='follow on facebook' /></li>
				<li><img src='images/twitter.png' alt='follow on twitter' /></li>
			</ul>
			<div id='copyright'>Copyright &copy; <?php echo date('Y') ?> Lane Breneman</div>
		</div>
	</div>
	<script type="text/javascript">$('body').pngFix();</script>
</body>
</body>
</html>