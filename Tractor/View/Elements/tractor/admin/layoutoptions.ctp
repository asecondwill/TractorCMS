<?php
$layouts =  $this->Directory->recursiveArray('/app/View/Themed/' . $this->theme .'/layouts' , true, array());
$views =  $this->Directory->recursiveArray('/app/View/Themed/' . $this->theme . '/' . $this->request->params['controller'] , true, array());



echo $this->Form->input('Content.layout', array('options'=>$layouts, 'empty'=>'default'));
echo $this->Form->input('Content.view', array('options'=>$views, 'empty'=>'view'));