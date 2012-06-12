<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>    <?php echo $title_for_layout; ?></title>
  <meta name="description" content="">
  <meta name="author" content="">

  <?php
  	echo $this->Html->meta('icon');  
	echo $this->Html->css (array('reset', 'style', 'debug', 'mac-classic'))
  ?>
  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  <script src="js/libs/modernizr-1.7.min.js"></script>
</head>
<body>
  <div id="container" class="clearfix">
    <header>
		<h1><sup>#</sup>2</h1>
		<nav>
			<?php	echo $this->Menu->setup($contents, array('type'=> 'tree', 'modelName'=>'Content', 'title'=>'title', 'depth' =>0, 'slugUrl' =>'path',  'selected' => $this->here)); 			
			?>
		</nav>
		
		<p>Tractor.  Simple.  Powerfull. Magnificent.  It's <em>the little Cms that can</em>.  Check out the <a href='http://www.tractorcms.com'>plugins</a> and <a href='http://www.tractorcms.com'>elements</a> for it, or <a href='http://wwwtractorcms.com/docs'>get your geek on</a> and start building out whatever <a href='kindleman.com.au'>you can dream</a>.</p>
		
    </header>
    
    
	<section id='content'>
	<?php echo $content_for_layout ?> 
		
	</section>
    <aside>
 
		<h1>Connect</h1>
		<ul id='social'>
			<li class="twitter">
				<a  href="/twitter.com/asecondwill">
					<?php echo $this->Html->image("icons/icon-twitter.png"); ?>
					Twitter
				</a>
			</li>
			<li>
				<a class="linkedin" href="/twitter.com/asecondwill">
					<?php echo $this->Html->image("icons/icon-flickr.png"); ?>
					Linked In
				</a>
			</li>
			<li>
				<a class="rss" href="/twitter.com/asecondwill">
					<?php echo $this->Html->image("icons/icon-rss.png"); ?>
					RSS				
				</a>
			</li>	
		</ul>
		<h1>Tweets!</h1>
				<?php
					echo $this->Twitter->tweet('asecondWill',5);
				?>
				
				<p><a href="http://twitter.com/aSecondWill" id="twitter-link" >Connect with me on Twitter</a> </p>
				
    </aside>
    <footer>
		<p class="copyright">@copy; 2011 Will Barker All rights reserved.</p>
		<p class="power"><a href=''>Powered By Tractor!</a></p>
		<p class="clear"><?php echo $this->element('Menu/show', array('name'=>'Footer', 'level'=>0, 'after'=>" / ", 'li'=>false));?></p>
		
		
    </footer>
  </div> <!--! end of #container -->


  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
  <!--  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.js"></script>
  <script>window.jQuery || document.write("<script src='js/libs/jquery-1.5.1.min.js'>\x3C/script>")</script>-->


  <!-- scripts concatenated and minified via ant build script-->
  <script src="js/plugins.js"></script>
  <script src="js/script.js"></script>
  <!-- end scripts-->


  <!--[if lt IE 7 ]>
    <script src="js/libs/dd_belatedpng.js"></script>
    <script>DD_belatedPNG.fix("img, .png_bg"); // Fix any <img> or .png_bg bg-images. Also, please read goo.gl/mZiyb </script>
  <![endif]-->



</body>
</html>



