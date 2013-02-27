<?php 
/*******************************************************************************************************
*	Powered by tractor CMS. Copyright aSecondSystem.com
*
*	Usage granted for one domain and website.
*
*	Not for resale or distribution or any other use without permission from the authors. 
*
*	v 2,  with seperators
********************************************************************************************************/
class MTreeHelper extends Helper
{
  var $tab = "  ";
  function show($name, $data)
  {
    list($modelName, $fieldName) = explode('/', $name);
    $output = $this->list_element($data, $modelName, $fieldName, 0);
    
    return $this->output($output);
  }
  
  function list_element($data, $modelName, $fieldName, $level)
  {
  
  
    $tabs = "\n" . str_repeat($this->tab, $level * 2);
    $li_tabs = $tabs . $this->tab;
    
    $output = $tabs. "<ul>";
    foreach ($data as $key=>$val)
    {
      $output .= $li_tabs . "<li><a href='/admin/menu_items/index/" . $val[$modelName]['menu_id'] . "/" . $val[$modelName]['id'] . "'>".$val[$modelName][$fieldName] . "</a>";
      if(isset($val['children'][0]))
      {
        $output .= $this->list_element($val['children'], $modelName, $fieldName, $level+1);
        $output .= $li_tabs . "</li>";
      }
      else
      {
        $output .= "</li>";
      }
    }
    $output .= $tabs . "</ul>";
    
    return $output;
  }
  
  function sitemap($data,  $options)
  {
 	$defaults = array(	
	    'attributes' 	=>	'',
    	'level' 		=>	0,
	    'after'			=>	"",
	    'li'			=> false,
	    'after'		=> ''
  	);

  $settings = am($defaults, $options);
  
  //debug($settings);
 	
  	$output="";
    $tabs = "\n" . str_repeat($this->tab, $settings['level'] * 2);
    $li_tabs = $tabs . $this->tab;
    
    if ($settings['li']){
    	 $output = $tabs. "<ul ";
	    if ($settings['level'] == 0) $output .= $settings['attributes'];
    	$output .= " >";
    }
        	$i = 0;
        	
        	
    $numItems = count($data);
  
    
	$i_count = 1;    	
    foreach ($data as $key=>$val)
    {

    	$i=$i+1;
    	if ($settings['li'])   $output .= $li_tabs . "<li class='item_{$i}'>";	
      	$output .= $li_tabs . "<a href='" ;
        if (!empty($val['Content']['path'])){
        	$output .= $val['Content']['path'] ;
        }else{
        	$output .= $val['MenuItem']['link'] ;
        }	
        $output .= "'>";
      if ($val['MenuItem']['Image']){
      	$output .= "<img src='/media/" .  $val['MenuItem']['Image'] . "' alt='" . $val['MenuItem']['title'] . "' title='" . $val['MenuItem']['title'] . "'/>";      
      }else{
      	$output .= $val['MenuItem']['title'];
      }
      $output .=   "</a>";
      if($i_count < $numItems)  $output .= $settings['after'];
      $i_count++;
      if(isset($val['children'][0]))
      {
        $output .= $this->sitemap($val['children'],  array('level'=>$settings['level']+1, 'li'=>$settings['li']));
        $output .= $li_tabs ;
        if ($settings['li'])  $output .=  "</li>";
      }
      else
      {
        if ($settings['li'])   $output .= "</li>";
      }
    }
    $output .= $tabs ;
    if ($settings['li']) $output .=  "</ul>";
    
    # make last last class
    
    
    return $output;
  }
  
  
  	function context($event_categories){
  		echo "<ul>";
  		foreach ($event_categories as $ec){
			echo "<li><a href='{$ec['Content']['path']}'>{$ec['Content']['title']}</a>";
			$this->context( $ec['children']);
			echo "</li>";			
		}
		echo "</ul>";
  	}
  	
  	
  	function contentTypes($types){
  		$s="";
  		foreach ($types as $ec){
  		
			$s .=  "<li><a href='{$ec['path']}'>{$ec['title']}</a>";
			if(!empty($ec['children'])) $kids = $this->contenttypes( $ec['children']);
			if (!empty($kids)) $s.= "<ul>$kids</ul>";
			
			$s.= "</li>";			
		}
		return $s;
  	}
  	
}