<!DOCTYPE html>
<html lang="en">
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php __('CMS'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
				
		
		echo $this->Html->css('reset');
		echo $this->Html->css('960');
		echo $this->Html->css('text');
		echo $this->Html->css('brightspark');
		
		?>

</head>
<body>
	<div id="content" class="container_12 clearfix">
		<div id="container" class="clearfix">
						
			<div class="content-item grid_12 alpha">
				<h1>Installer</h1>			
				<?php echo $this->Session->flash(); ?>
				<?php echo $content_for_layout; ?> 

			</div>		
		</div>
		
		<div  class="container_12">
			<div id="footer" class="grid_12 alpha clearfix">			
				<a target="_blank" href='http://www.asecondsystem.com/pages/view/tractor-cms'><img src="/img/tractor/powered-by-tractor.png"/></a>
			</div>
		</div>
	</div>
</body>
</html>