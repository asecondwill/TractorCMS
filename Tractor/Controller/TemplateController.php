<?php
/*******************************************************************************************************
*	Powered by tractor CMS. Copyright aSecondSystem.com
*
*	Usage granted for one domain and website.
*
*	Not for resale or distribution or any other use without permission from the authors. 
*
********************************************************************************************************/
class TemplateController extends AppController {

	var $helpers = array('Directory');

	public function admin_index($file = null){
		
		if(!empty($file)){
			
			$this->set('file_pass', $file);		
		
			$file =str_replace("%7Cslash%7C", "/", $file);			
			$this->set('file', $file);					
			
			$file = ROOT .$file;
									
			if($this->request->data){
				$f= fopen($file, 'w') ;
				fwrite($f, $this->data['Template']['contents'])	;
				fclose($f);
				$this->Session->setFlash(__('The Template has been saved'),	'default', array('class'=>'success'));
				
			}
					
			$f = fopen($file, 'r');
			$size = filesize($file);
			
			$data= fread($f, 20000);
			
			fclose($f);
			
			$this->set('template_content', $data);	
		}
	
		$this->set('theme_name', $this->theme);
	}

}