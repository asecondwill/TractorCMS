<?php
if (empty($this->data['Message']['referer'])){
	$referer = $_SERVER['HTTP_REFERER'];
}else{
	$referer = $this->data['Message']['referer'];
}
?>
<section class="page clearfix">
  <p class="social">
    <a href="http://www.facebook.com/pages/Hunter-Valley-Wine-Industry-Association/75509093611"><?php echo $this->Html->image("facebook.png",  array('alt'=>"Become a fan on Facebook"));?></a> 
    <a href="http://twitter.com/_hunterwine"><?php echo $this->Html->image("twitter.png" , array('alt'=>"Follow us on Twitter",  'border'=>"0"));?></a>
  </p>
  <div id="crumbs">
    <?php echo $this->element('tractor/nav/crumbs') ?>  
  </div>
    
  <aside>        
   
    <?php echo $this->element('Event/latest', array("number_of_events"=>3)); ?>     
    <?php echo $this->element('subscribe'); ?>
  </aside>
    
  <article>
    <h1><?php echo $contact['Contact']['title'];?></h1>
    <? echo $contact['Contact']['body'] ?>
    <?php
		echo $this->Session->flash();
		echo $this->Form->create('Message', array('url'=>$contact['Content']['path']));
		echo $this->Form->input('Message.contact_id', array('type'=>'hidden', 'value'=>$contact['Contact']['id']));
		echo $this->Form->input('Message.email');
		echo $this->Form->input('Message.referer', array('value'=>$referer, 'type'=>'hidden'));
		echo $this->Form->input('Message.friends_email');
		echo $this->Form->input('Message.details', array('label'=>'Message', 'cols'=>80, 'rows'=>15, 'value'=>
"
Hello!

Check this link out:

{$referer}

The site is awesome and this event looks fantastic. We go?


			
"
		));
		echo $this->Form->end("Send Message");
	?>
  </article>

</section>