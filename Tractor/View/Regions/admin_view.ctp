<div class="regions view">
<h2><?php echo __('Region');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $region['Region']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $region['Region']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Alias'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $region['Region']['alias']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $region['Region']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Block Count'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $region['Region']['block_count']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('Edit %s'), __('Region')), array('action' => 'edit', $region['Region']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('Delete %s'), __('Region')), array('action' => 'delete', $region['Region']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $region['Region']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Regions')), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Region')), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Blocks')), array('controller' => 'blocks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Block')), array('controller' => 'blocks', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php printf(__('Related %s'), __('Blocks'));?></h3>
	<?php if (!empty($region['Block'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Region Id'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Alias'); ?></th>
		<th><?php echo __('Body'); ?></th>
		<th><?php echo __('Show Title'); ?></th>
		<th><?php echo __('Class'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Weight'); ?></th>
		<th><?php echo __('Element'); ?></th>
		<th><?php echo __('Visibility Roles'); ?></th>
		<th><?php echo __('Visibility Paths'); ?></th>
		<th><?php echo __('Visibility Php'); ?></th>
		<th><?php echo __('Params'); ?></th>
		<th><?php echo __('Updated'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($region['Block'] as $block):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $block['id'];?></td>
			<td><?php echo $block['region_id'];?></td>
			<td><?php echo $block['title'];?></td>
			<td><?php echo $block['alias'];?></td>
			<td><?php echo $block['body'];?></td>
			<td><?php echo $block['show_title'];?></td>
			<td><?php echo $block['class'];?></td>
			<td><?php echo $block['status'];?></td>
			<td><?php echo $block['weight'];?></td>
			<td><?php echo $block['element'];?></td>
			<td><?php echo $block['visibility_roles'];?></td>
			<td><?php echo $block['visibility_paths'];?></td>
			<td><?php echo $block['visibility_php'];?></td>
			<td><?php echo $block['params'];?></td>
			<td><?php echo $block['updated'];?></td>
			<td><?php echo $block['created'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'blocks', 'action' => 'view', $block['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'blocks', 'action' => 'edit', $block['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'blocks', 'action' => 'delete', $block['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $block['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Block')), array('controller' => 'blocks', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
