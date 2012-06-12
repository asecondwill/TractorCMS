<div class="install">
    
<?php
        echo $this->Form->create('Install', array('url' => array( 'controller' => 'install', 'action' => 'data')));
        
        echo "<h3>Create Admin User</h3>";	        
        echo $this->Form->input('Install.email', array('label' => 'Email', 'default' => ''));
        echo $this->Form->input('Install.password', array('label' => 'Password', 'default' => ''));
        echo $this->Form->input('Install.first_name');
        echo $this->Form->input('Install.last_name');

		echo "<h3>Configure Site</h3>";	        
        echo $this->Form->input('Install.name', array('label' => 'Site Name', 'type'=>'text',  'default' => 'Anouther Tractor in the padock'));
       
       
        echo $this->Form->end('Create Site');
    ?>
    
</div>