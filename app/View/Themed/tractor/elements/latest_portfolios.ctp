<?php
$portfolios = Cache::read("portfolios_$number_of_portfolios");
if ($portfolios == false){
	$portfolios =	$this->requestAction(array(
		'controller' => 'portfolios', 
		'action' => 'latest'
		), array('pass' => array(  $number_of_portfolios , 'desc', 'created'	)));
}


if ($portfolios){
	foreach($portfolios as $portfolio){
	
	$heros = explode(",",$portfolio['Portfolio']['hero']);

foreach($heros as $key => $item)
{
   if(trim($item) == "")
   {
       unset($heros[$key]); //Remove from teh array.
   }
}
$heros_str = implode($heros);
$heros = explode(",", $heros_str);


		echo "<figure>
				<a href=''>
					{$image->resize("/../media/" . $heros[0] , 250, 165, true,array('border'=>'0', 'alt'=> $heros[0]))}
				</a></figure>";
		
	
	}
}
