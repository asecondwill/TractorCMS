<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">

<head>
  <meta charset="utf-8">

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title><?php 
  	echo  $settings['site'] . " - " ;
    echo !empty($content) ? $content['Content']['title'] : ""; 
  ?></title>
  <meta name="description" content="<?php echo !empty($content) ? $content['Content']['description'] : ""; ?>">
  <meta name="keywords" content="<?php echo !empty($content) ?  $content['Content']['keywords'] : ""; ?>">  
  <meta name="author" content="will@kindleman.com.au">
  <?php echo !empty($content) ?   $content['Content']['meta_tags']  : ""; ?>


<?php
  	echo $this->Html->meta('icon');
	echo $this->Html->css (array('reset','superfish', 'style', 'debug', 'style')); 
?>
	<!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  <script src="/theme/hunter/js/libs/modernizr-1.7.min.js"></script>

</head>
<body>
<div id="wrapper">
	<header> 
		<div id="Logo"><?php echo $this->Html->image('Hunter-Valley-Logo.png' ,array('alt'=>'Hunter Valley Logo'));?></div>
		<div id="Main-Title"><?php echo $this->Html->image('hunter_valley_uncorked.png', array('alt'=>'Hunter Valley - Uncorked', 'title'=>'Hunter Valley - Uncorked'));?></div>
		<nav>
		
		<?php echo $this->element('Menu/show', array('name'=>'Little', 'class'=>'', 'li'=>false,  'id'=>'nav', 'after'=> " | ", 'level'=>0)); ?>
		
		</nav>
	</header>
	<nav id='main_nav'>
	<?php echo $this->element('Menu/show', array('name'=>'Main', 'class'=>'sf-menu', 'id'=>'nav', 'li'=>true, 'after'=>"", 'level'=>0)); ?>
	</nav>
	
	
	
	<?php	echo $content_for_layout	?>
	
	
	
	<footer class="clearfix">
		<div id="copyright"><span>&copy; Hunter Valley Wine Industry Association. All rights reserved.</span></div>
		
		<nav>
		<?php echo $this->element('Menu/show', array('name'=>'Footer', 'level'=>0, 'after'=>"", 'li'=>true)); ?>
		</nav>
	</footer>
</div>

 <!-- JavaScript at the bottom for fast page loading -->


  <!-- scripts concatenated and minified via ant build script-->
<?php
	echo $this->Html->script(array('libs/jquery-1.5.1', 'plugins','script'));
	echo $scripts_for_layout;
	
 ?>

  <!-- end scripts-->




</body>
</html>
