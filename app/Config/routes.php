<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
// 	Router::connect('/visitor-information', array('controller'=>'pages', 'action'=>'view', 'visitor-information'));

	if (!file_exists(APP . 'Config' . DS.'tractor_settings.php')) {    	

		Router::connect('/install/:action', array('controller' => 'install',  'plugin'=>'install'));
    	Router::connect('/*', array('controller' => 'install', 'action'=>'index', 'plugin'=>'install'));
    	
	}else{
		
	
			# DYNAMIC ROUTING. GO!	
		// Cache::delete('contents'); 
		if($contents = Cache::read('contents') === false ){		   
		    App::Import( 'Model', 'Content');
		    $Content = new Content;
		    $contents = $Content->find('all');
		   
		    Cache::write('contents', $contents);
		}else{
			$contents = Cache::read('contents');
		}	
			
		foreach($contents as $content){
			
		    Router::connect( $content['Content']['path'], array(
		    	'controller' => $content['Content']['class_name'], 
		    	'action' => $content['Content']['action_name'], 
		    	'plugin' => $content['Content']['plugin'],
		    	$content['Content']['slug']
		    ));
			 	
		     
		    if ( !empty($content['Content']['parameter_types'])){  # is this hack? it might be hack.  
		    	$variablys = explode(",", $content['Content']['parameter_types']);
		    	foreach($variablys as $variablie){
		    		 Router::connect( $content['Content']['path'] . "/{$variablie}/*", array('controller' => $content['Content']['class_name'], 'action' => $content['Content']['action_name'], $content['Content']['slug'], $variablie));	
		    		debug($content['Content']['path'] . "/{$variablie}/*");
		    	} 
		    }			    
		}    	
		
		# stop.

		Router::connect('/', array('controller' => 'pages', 'action' => 'view', 'home'));

	
	
		Router::connect('/admin', array('controller' => 'pages', 'admin'=>'true', 'action'=>'index'));
	
		Router::connect('/cache_css/*', array('plugin' => 'asset_compress', 'controller' => 'css_files', 'action' => 'get'));
		Router::connect('/cache_js/*', array('plugin' => 'asset_compress', 'controller' => 'js_files', 'action' => 'get'));
		
		Router::connect('/', array('controller' => 'pages', 'action' => 'view', 'home')); 
	}
	
	
	
	
	
	
	
		

/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';


 	Router::parseExtensions('rss','xml'); 
	