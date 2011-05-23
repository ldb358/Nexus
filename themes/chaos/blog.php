<!DOCTYPE html>
<html>
<head>
	<title>Chaos</title>
	<link href='style.css' type='text/css' rel='stylesheet' />
	<script src='js/jquery.js' type='text/javascript'></script>
	<script src='js/jquery.supersleight-min.js' type='text/javascript'></script>
	<script src='js/jquery.pngFix.js' type='text/javascript'></script>
	<!--[if !(ie 6)]>
	<script src='js/bgload.js' type='text/javascript'></script>
	<![endif]-->
	<!--[if ie 7]>
	<link href='ie7.css' type='text/css' rel='stylesheet' />
	<![endif]-->
    <script src='js/page.js' type='text/javascript'></script>
    
	
</head>
<body>
	<div id="header">
		 	<div class='center'>
				<h1>Chao&Sigma;</h1><h2>The Ultimate Theme</h2>
				<div id="linksdiv">
					<ul id="links">
						<li ><a href='index.php'>Home</a></li>
						<li><span class='current'></span><a href='blog.php'>Blog</a></li>
						<li><a href='about.php'>About</a></li>
						<li><a href='#'>Portfolio</a></li>
						<li><a href='#'>Contact</a></li>
					</ul>
				</div>
			</div>
	</div>
    <div id='main'>
		<div id="body">
            <div id='blogheader'>
				<h3>
				<span class='tr'> </span>
                <span class='br'> </span>
				Welcome to the Blog:
				</h3>
			</div>
			<div id='blogcol'>
				<form accept='' method='post'>
					<input type='text' value='Search...' name='search' id='searchbar' onclick="if(this.value == 'Search...') this.value = '';" />
					<input type='image' src='images/searchbtn.png' alt='Search Button' id='searchbtn' />
				</form>
				<div id='browseblog'>Browse: <a href='#'>Catagories</a> <a href='#'>Archives</a></div>
				<div class='minipost'>
					<h4>Creating a Php Login Script:</h4>
					<h5>By <span class='author'>Admin</span></h5>
					<p class="minisample">
						auris venenatis augue et neque eleifend suscipit. Etiam tempus varius tempor. Aenean vulputate, nisi eget molestie porta, dolor libero sodales lorem.
					</p>
					<span class='readmore'>Read More</span>
				</div>
			</div>
			<div id='blogfeed'>
				test
			</div>
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