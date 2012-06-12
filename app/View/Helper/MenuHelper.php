<?php
/**
 * Menu Helper
 * 
 * @author John Elliott (http://www.flipflops.org)
 * @package app
 * @subpackage app.views.helpers
 * @version 1.0
 * @lastmodified 2009-09-29
 * 
 * This helper is designed to work with the data arrays returned by the Tree behaviour or $model->find('threaded');
 * More specifically it is designed to generate menus composed of nested ULs for use in CMS systems where all the URLs are pretty:
 * 	- naviagtion menus (usually at the top of the page)
 * 	- context menus (usually found at the side) and showing the links in the current branch
 * 	- sitemaps
 * 
 * Overview (A bit of history)
 * 
 * The helper is designed to deal with navigation / page structures organised in simple /parent/child/grand-child like structures
 * for instance:
 * 
 * /home
 * /about
 * /about/company-history
 * /about/company-history/gallery
 * /about/ethos
 * /about/vacancies
 * /news
 * /news/2009/jan
 * /news/2009/feb
 * /news/2009/mar
 * /contact
 * (etc.)
 * 
 * -------------------
 * URLs are generated in the model or controller not in the view / helper
 * -------------------
 * In the system from which this is taken, I create a full slug for each page on $model->save();
 * Some of the pages are actual pages of text and others are palceholders for content in other models
 * but they allow you do things like control the content of left / right columns, set default meta tags etc.
 * The purpose being to create really easy site structures with nice urls, the 
 * In the example above /home, /about etc. are all from a single model 'Article' which is my master model 
 * /news however is a placeholder for the 'News' model and /contact for the 'Contact' model
 * 
 *
 * 
 * Required Fields
 * ------------------
 * title / name (defaults to 'title')
 * page url (defaults to 'slug_url' e.g. /about/ethos)
 * 
 * Optional Fields
 * ------------------
 * title_for_navigation
 * redirect_url
 * redirect_target
 * 
 * Example data
 * ------------------
 * [Article] => Array
                (
                    [name] => Find out about us
                    [slug_url] => /about-us
                    [title_for_navigation] => About Us
                    [redirect_url] => 
                    [redirect_target] => 
                    [lft] => 15
                    [id] => 105
                    [rght] => 24
                    [parent_id] => 
                )

            [children] => Array
                (
                    [0] => Array
                        (
                            [Article] => Array
                                (
                                    [name] => Philosophy
                                    [slug_url] => /about-us/philosophy
                                    [title_for_navigation] => 
                                    [redirect_url] => 
                                    [redirect_target] => 
                                    [lft] => 16
                                    [id] => 111
                                    [rght] => 21
                                    [parent_id] => 105
                                )
 * 
 * 
 * 
 *
 * Usage:
 * 
 * Include the helper in your controller as usual.
 * 
 * The helper operates in 2 modes 'tree' (which is default) and 'context'
 * 'tree' will produce a whole list of nested Uls - can be used to generate top level navigation (works well with things like suckerfish)
 * 'context' will only produce nested ULs for the current branch
 * 
 * Using the example above if you were on the /about/ethos page and you wanted the navigation fragment in the sidebar you would use context
 * /about
 * /about/company-history
 * /about/company-history/gallery
 * /about/ethos
 * /about/vacancies
 * 
 * In a view / element to generate complete menu
 * echo $menu->setup($menu_data, array('selected' => $this->here));
 * 
 * In a view / element to generate a context menu from the same data, set the class of the parent UL
 * echo $menu->setup($menu_data, array('selected' => $this->here, 'type' => 'context', 'menuClass' => 'context-menu'));
 * 
 * 
 * In a view / element to generate a sitemap from different data, let the helper know to use the 'Sitemap' model rather than the default 'Article' model and set the parent UL class.
 * $sitemap = new MenuHelper();
 * echo $sitemap->setup($data,  array('modelName' => 'Sitemap', 'menuClass' => 'sitemap'));
 * 
 * Version Details
 * 
 * 1.0
 * + Initial release.
 */
class MenuHelper extends AppHelper {
		
	/**
	 * Current page in application
	 *
	 * @var string
	 */
	private $selected = '';
	
	/** Internal variable for the data
	 *
	 * @var array
	 */
	private $array = array();
	
	/**
	 * Default css class applied to the menu
	 *
	 * @var string
	 */
	private $menuClass = 'menu';
	
	/**
	 * Default DOM id applied to menu
	 *
	 * @var string
	 */
	private $menuId = 'top-menu';
	
	/**
	 * CSS class applied to the selected node and its parent nodes 
	 *
	 * @var string
	 */
	private $selectedClass = 'selected';
	
	/**
	 * CSS class applied to the exact selected node in the tree - in addition to $selectedClass
	 *
	 * @var unknown_type
	 */
	private $selectedClassItem = 'item-selected';
	
	/**
	 * Default Slug
	 *
	 * @var string
	 */
	private $defaultSlug = 'home';
	
	/**
	 * Type of menu to be generated:
	 * 'tree' - to generate a complete tree
	 * 'context' - to only render the specific barnch under the current page
	 *
	 * @var string
	 */
	private $type = 'tree';
	
	/**
	 * Model name used in $array e.g. $data[0]['Article']['name']
	 *
	 * @var string
	 */
	private $modelName = 'Content';
	
	/**
	 * Database column name - (i.e. a shorter version of the name / title for use only in naviagtion)
	 * e.g. A page called 'Welcome to the giant flea circus' 
	 * might be set to show up on navigation as 'home'
	 *
	 * @var string
	 */
	private $titleForNavigation = 'title_for_navigation';
	
	/**
	 * Database column name for title / name
	 * @var string
	 */
	private $title = 'title';
	
	/**
	 * Database column name for complete page slug e.g. /about/history/early-years
	 *
	 * @var string
	 */
	private $slugUrl = 'path';
	
	/**
	 * Database column name for redirect_url for instance if /about/blog redirects to http://blog.somewebsite.com
	 *
	 * @var string
	 */
	private $redirectUrl = 'redirect_url';
	
	/**
	 * Target for redirect (see redirectUrl)
	 *
	 * @var string
	 */
	private $redirectTarget = 'redirect_target';
	
	/**
	 * Minumum number of items required to render a context menu
	 *
	 * @var int
	 */
	private $contextMinLength = 1;
	
	/**
	 * Internal Counter used in type: 'context'
	 *
	 * @var int
	 */
	private $li_count = 0;
	
	/**
	 * Internal flag to see if the page has been matched to an item
	 *
	 * @var bool
	 */
	private $matched = false;
	
	/**
	 * Internal counter
	 *
	 * @var int
	 */
	private $i = 0;
	
	/**
	 * Enter description here...
	 *
	 * @var unknown_type
	 */
	private $rootNode = '';
	
	function __construct(){
		
	}
	
	public function setOption($key, $value){
		$this->{$key} = $value;
	}
	
	public function getOption($key){
		return $this->{$key};
	}
	
	/**
	 * Setup the helper and return a string to echo
	 *
	 * @param array $array Data array containing the lists
	 * @param array $config Configuration variables to override the defaults
	 * @return string
	 */
	public function setup($array, $config = array()){

		// update and override the default variables 
		if(!empty($config)){
			foreach ($config as $key => $value) {
				$this->setOption($key, $value);
			}
		}
		
		// set the default slug selected if the current page does not match
		if($this->selected == '/'){
			$this->selected = $this->defaultSlug;
		}
		
		$this->array = $array;
		
		
		
		// get the root node of the selected tree if this a context menu
		if($this->type == 'context'){
			$this->rootNode = $this->getRootNode($this->selected);
		}
		
		$str = $this->buildMenu();
		
		// if the current page has matched one of the links in the tree
		// then get rid of the 'default_slected' placeholder
		if($this->matched == true){
			$str = str_replace('default_selected', '', $str);
		} else {
			$s = ' class="' . $this->selectedClass . '" ';
			$str = str_replace('default_selected', $s, $str);
		}
		
		// if this is a context menu, it looks daft if it only has 1 item 
		// if this is the case hide it
		if($this->type == 'context'){
			if($this->li_count < $this->contextMinLength){
				$str = '';
			}
		}
	
		
		return $this->output($str);	
		
	}
	/**
	 * Call the menu iterator method and if it returns a string warp it up in a UL
	 *
	 * @return string
	 */
	protected function buildMenu(){
		
		$str = $this->menuIterator($this->array);

		if($str != ''){
			$str = '<ul  id="' . $this->menuId . '" class="' . $this->menuClass . '">' . $str . '</ul>';
		}
		
		return $str;
	}
	
	/**
	 * Explode a url slug and get the root page
	 *
	 * @param string $string 
	 * @return string
	 */
	protected function getRootNode($string){
			$rootNode = '';
			if($string != ''){
				$node = explode('/', $string);
				// $node[0] will always be empty becuase the first char of $this->selected will always be '/'
				if (isset($node[1]))	$rootNode = $node[1];
			}
			return $rootNode;
	}
	
	
	/**
	 * Recursive method to loop down through the data array building menus and sub menus
	 *
	 * @param array $array
	 * @param int $depth
	 * @return string
	 */
	protected function menuIterator($array){
		
		$str = '';
		$is_selected = false;
		foreach($array as $var){
			
			$continue = true;
			$selected = '';
			$sub = '';
			
			if($this->type == 'context' && ($this->getRootNode($var[$this->modelName][$this->slugUrl]) != $this->rootNode)){
				$continue = false;
			}
			
			if($continue == true){
				
				// if this is the first list item set default_selected placeholder
				$default_selected = '';
				if($this->i == 0){
					$this->i = 1;
					$default_selected = 'default_selected';
				}
				
				
				
				if(!empty($var['children'])){
					$sub .= '<ul>';
					$sub .= $this->menuIterator($var['children']);
					$sub .= '</ul>';	
				}
				
				$p = strpos($this->selected, $var[$this->modelName][$this->slugUrl]);
				
				
				if($p === false){
					
				} elseif($p == 0){
						// this is the selected item or a parent node of the selected item
						$selected = ' class="' . $this->selectedClass . '" ';
						$is_selected = true;
						$this->matched = true;
				}
				
				if($this->selected == $var[$this->modelName][$this->slugUrl]){
					// this is the exact selected item
					$selected = ' class="' . $this->selectedClass . ' ' . $this->selectedClassItem . '" ';
				}
				
				// keep track if this is a contextual menu 
				if($this->type == 'context'){
					$this->li_count++;
				}
				
				
				// Get the name / title to be used for the link text
				$name = $this->getName($var);
				// Get the URL / target for the link
				$url = $this->getUrl($var);
				
				$str .= '<li ' . $selected . ' ' . $default_selected . '>';
					$str .= '<a  href="' . $url['url'] . '" ' . $url['target'] . '><span>' . $name . '</span></a>';
					$str .= $sub;
				$str .= '</li>';
			
			}
		}
		return $str;
	}
	/**
	 * Look in the data and check if this is a straight url
	 * or whether it is actually a redirect
	 *
	 * @param array $var
	 * @return array
	 */
	protected function getUrl($var = null){
			$url = array();
		
			if(isset($var[$this->modelName][$this->redirectUrl]) && !empty($var[$this->modelName][$this->redirectUrl])){
				$url['url'] = $var[$this->modelName][$this->redirectUrl];
				if(isset($var[$this->modelName][$this->redirectTarget]) && !empty($var[$this->modelName][$this->redirectTarget])){
					$url['target'] = ' target="' . $var[$this->modelName][$this->redirectTarget] . '" ';
				}
			} else {
				$url['url'] =   $var[$this->modelName][$this->slugUrl];
				$url['target'] = '';
			}
			return $url;
	}
	
	/**
	 * See if there is a title_for_navigation 
	 *
	 * @param array $var
	 * @return string
	 */
	protected function getName($var){
		if(isset($var[$this->modelName][$this->titleForNavigation]) && !empty($var[$this->modelName][$this->titleForNavigation])){
			$name = $var[$this->modelName][$this->titleForNavigation];
		} else {
			$name = $var[$this->modelName][$this->title];
		}
		return $name;
	}
		
		
		
}
?>