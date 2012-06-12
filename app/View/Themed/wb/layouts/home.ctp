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
//  echo $this->Html->css('text');
  
  echo $this->Html->css (array('reset', 'style', 'debug', 'twilight'))

?>


  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  <script src="js/libs/modernizr-1.7.min.js"></script>

</head>

<body>

  <div id="container" class="clearfix">
    <header>
		<h1><sup>#</sup>2</h1>
		
		<nav>
			<?php	echo $menu->setup($contents, array('type'=> 'tree', 'modelName'=>'Content', 'title'=>'title', 'depth' =>0, 'slugUrl' =>'path',  'selected' => $this->here)); 
			?>
		</nav>
		
		<p>Will <a href='/projects'>creates</a> nice web-things, builds <a href=''>awesome ideas</a>, and <a href='/partners'>collaborates</a> with other creative types. Find out <a href=''>more about him</a>.</p>
		
    </header>
    
    <section id='portfolio'>
		    <?php echo $this->element('latest_portfolios', array("number_of_portfolios"=>8, 'detail'=>true))	; ?>
			<!--  
			<figure><a href=''><?php echo $this->Html->image("portfolio/thumbs/250x135_hhd_full.png"); ?></a></figure>
			<figure><a href=''><?php echo $this->Html->image("portfolio/thumbs/250x142_posta-1.png"); ?></a></figure>
			<figure><a href=''><?php echo $this->Html->image("portfolio/thumbs/250x144_bundy.png"); ?></a></figure>
			<figure><a href=''><?php echo $this->Html->image("portfolio/thumbs/250x152_milo_ashes.jpg"); ?></a></figure>
			<figure><a href=''><?php echo $this->Html->image("portfolio/thumbs/250x156_ginger.png"); ?></a></figure>
			<figure><a href=''><?php echo $this->Html->image("portfolio/thumbs/250x156_thehappiempire.png"); ?></a></figure>
			
			<figure><a href=''><?php echo $this->Html->image("portfolio/thumbs/250x156_uncletobys2.png"); ?></a></figure>
			<figure ><a href=''><?php echo $this->Html->image("portfolio/thumbs/250x156_zip.png"); ?></a></figure>
			-->
    </section>
    
	<section id='content'>
	<?php echo $content_for_layout ?> 
	<?php echo $this->element('latest_posts', array("number_of_posts"=>2, 'detail'=>true))	; ?>
		
	</section>
    <aside>
    	<h1>Topics</h1>
    			<ul id="tagcloud">
	<?php 
		
			$tags =	$this->requestAction(array('controller' => 'posts', 'action' => 'cloud'));
			
			echo $this->TagCloud->display($tags, array(
			'before' => '<li style="font-size:%size%px" class="tag">',
			'minSize'=> '9',
			'maxSize'=> '20',
			'named' => 'tag',
			'url' 	 => array('controller' => 'posts', 'action'=>'index'),
			'after'  => '</li>'));
			
	?>
	
	
	</ul>
 
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
					echo $this->Twitter->tweet('asecondWill',3);
				?>
				
				<p><a href="http://twitter.com/aSecondWill" id="twitter-link" >Connect with me on Twitter</a> </p>
				
    </aside>
    <footer>
		<p class="copyright">@copy; 2011 Will Barker All rights reserved.</p>
		<p class="power"><a href=''>Powered By Tractor!</a></p>
		
		
		
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



