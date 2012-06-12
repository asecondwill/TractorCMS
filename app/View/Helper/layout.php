<?php
/*******************************************************************************************************
*	Powered by tractor CMS. Copyright aSecondSystem.com
*
*	Usage granted for one domain and website.
*
*	Not for resale or distribution or any other use without permission from the authors. 
*
********************************************************************************************************/
App::uses('View', 'View');

class LayoutHelper extends AppHelper {
/**
 * Other helpers used by this helper
 *
 * @var array
 * @access public
 */
    var $helpers = array(
        'Html',
        'Form',
        'Session',
        'Js',
        'Tree',
        'MTree'
    );
    
      /** 
     * The base directory containing your elements. 
     * Set to '' to include all elements in your views/elements folder 
     */ 
    var $baseDir = 'templates'; 
     
    /** 
     * Applies all the formatting defined in this helper 
     * to $str 
     * (Currently only $this->getElements() ) 
     *  
     * @return $str Formatted string  
     * @param string $str  
     */ 
    function filter($str) { 
        $str =& $this->getElements($str); 
        return $str; 
    } 
     
    /** 
     *  
     * Replaces [element:element_name] tags in a string with  
     * output from cakephp elements 
     * Options can be defined as follows: 
     *         [element:element_name id=123 otherVar=var1 nextvar="also with quotes"] 
     *      [e:element_name] 
     *   
     * @return formatted string  
     * @param $str string 
     */ 
    function getElements(&$str){ 
              
        preg_match_all('/\[(element|e|t):([A-Za-z0-9_\-\/]*)(.*?)\]/i', $str, $tagMatches); 
         //debug($tagMatches);

        for($i=0; $i < count($tagMatches[1]); $i++){ 
             
            $regex = '/(\S+)=[\'"]?((?:.(?![\'"]?\s+(?:\S+)=|[>\'"]))*.)[\'"]?/i'; 
            preg_match_all($regex, $tagMatches[3][$i], $attributes); 
             
            $element = $tagMatches[2][$i]; 
            $options = array(); 
            for($j=0; $j < count($attributes[0]); $j++){ 
            	$attrib = trim($attributes[1][$j]);
            	//debug("*$attrib*");	 trim dosnt work :(            	
                $options[$attrib] = $attributes[2][$j];  
            } 
            
            $str = str_replace($tagMatches[0][$i], $this->_View->element($element,$options), $str); 
                          
        } 
         
        return $str; 
    } 
    
    
    
}
?>