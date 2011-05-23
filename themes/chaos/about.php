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
    <script type="text/javascript"
    src="http://maps.google.com/maps/api/js?sensor=true">
    </script>
    <script src='http://code.google.com/apis/gears/gears_init.js' type='text/javascript'></script>
    <script src='js/googlemaps.js' type='text/javascript'></script>
    
	
</head>
<body>
	<div id="header">
		 	<div class='center'>
				<h1>Chao&Sigma;</h1><h2>The Ultimate Theme</h2>
				<div id="linksdiv">
					<ul id="links">
						<li ><a href='index.php'>Home</a></li>
						<li><a href='blog.php'>Blog</a></li>
						<li><span class='current'></span><a href='about.php'>About</a></li>
						<li><a href='#'>Portfolio</a></li>
						<li><a href='#'>Contact</a></li>
					</ul>
				</div>
			</div>
	</div>
    <div id='main'>
		<div id="body">
            <div id='aboutusheader'>
                    <h3>
                        <span class='tr'> </span>
                        <span class='br'> </span>
                        About Us:    
                    </h3>
                    <span class='favoriteworkheader'>Favorite Work:</span>
            </div>
            <div id='aboutleft'>
                <div id="googlemap"></div>
                <div id='aboutuscontent'>
                    <p>This should be a clever introduction that tells the
                    user about you company for example where you
                    are located and what you are about.</p>
                
                    <p>Sed egestas libero et sem mollis id rhoncus arcu sagittis.
                    Donec fringilla, justo vel vehicula varius, dui lacus vehicula quam,
                    et cursus nibh dui et ipsum. </p>
    
                    <p>Vivamus turpis libero, gravida convallis tincidunt ac, feugiat sit amet sem.
                    Proin sodales, orci sit amet consectetur porta, tellus velit rutrum eros, ac
                    varius augue nibh consectetur ligula.</p>
    
                    <p>Curabitur eu turpis est. Cras quam turpis, aliquet et pellentesque sit amet,
                    malesuada id mauris. Ut semper tortor eu ante fermentum hendrerit. Praesent
                    at libero eget risus suscipit auctor.</p>
                </div>
                <div id="bulletpoints">
                    What We Do:
                    <ul>
                        <li class='image'><img src='images/web.png' alt='Web Design' /></li>
                        <li class='content'>Web design - Every business needs their own website it allows them to give
                        The right impression to future customers but we go beyond this our web sites
                        are built with you and your future customers in mind to make sure that they
                        suit your need</li>
                        <li class='image'><img src='images/wordpress.png' alt='wordpress' /></li>
                        <li class='content'>Wordpress - Not everyone can be a coder or take the time to learn html which
                        would typically leave you stuck hiring some one to make all the little content
                        changes but with a site built in Wordpress this is no longer needed you can have
                         full control of many aspects of your site without learning to code</li>
                        <li class='image'><img src='images/puzzle.png' alt='Hand coded' /></li>
                        <li class='content'>Hand coded solution - Sometimes your project doesn’t fit the mold of an existing
                        CMS( Content Management System) or you project is to small for a CMS to be
                        beneficial that’s okay because we can help you create exactly what you need for
                        every situation</li>
                        <li class='image'><img src='images/question.png' alt='Consultation' /></li>
                        <li class='content'>Don’t Know what you want - That’s fine we are here to help we offer consultation
                        so that we can find the perfect solution for you and your business </li>
                    </ul>
                </div>
                <div id='aboutusteam'>
                    <span>Why Choose Us:</span>
                    <p>This should be a detailed description of you expertise and why you go above and beyond your competition.
                    Proin sodales, orci sit amet consectetur porta, tellus velit rutrum eros, ac varius augue nibh consectetur
                    ligula.</p>
                    <span>Meet the Team:</span>
                    <div id='aboutteamdesc'>
                        <div class='member'>
                            <img src='images/person.png' alt='The Boss' /><br />
                            The Boss<br />
                            Project Manager
                        </div>
                        <div class='member'>
                            <img src='images/person.png' alt='The Boss' /><br />
                            An Artist<br />
                            Web Designer
                        </div>
                        <div class='member'>
                            <img src='images/person.png' alt='The Boss' /><br />
                            Lane Breneman<br />
                            Web Developer
                        </div>
                    </div>
                </div>
            </div>
            <div id='aboutfavprojects'>
                <div class='favproject'>
                    <img src='images/p3rf3ction.png' /><div class='label'>P3Rf3CTION</div>
                </div>
                <div class='favproject'>
                    <img src='images/pandora.png' /><div class='label'>Pandora</div>
                </div>
                <div class='favproject'>
                    <img src='images/lanesportfolio.png' /><div class='label'>Lanes Portfolio</div>
                </div>
                <div class='favproject'>
                    <img src='images/lanesblog.png' /><div class='label'>Lanes Blog</div>
                </div>
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