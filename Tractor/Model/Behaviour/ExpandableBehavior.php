<?php

/**
 * undocumented class
 *
 * @package default
 * @access public
 */
class ExpandableBehavior extends ModelBehavior{
	var $settings = array();

	function setup(&$Model, $settings = array()) {
		$base = array('schema' => $Model->schema());
		if (isset($settings['with'])) {
			$conventions = array('foreignKey', $Model->hasMany[$settings['with']]['foreignKey']);
			return $this->settings[$Model->alias] = am($base, $conventions, $settings);
		}
		foreach ($Model->hasMany as $assoc => $option) {
			if (strpos($assoc, 'Field') !== false) {
				$conventions = array('with' => $assoc, 'foreignKey' => $Model->hasMany[$assoc]['foreignKey']);
				return $this->settings[$Model->alias] = am($base, $conventions, !empty($settings) ? $settings : array());
			}
		}
	}

	function afterFind(&$Model, $results, $primary) {
		extract($this->settings[$Model->alias]);
		if (!Set::matches('/'.$with, $results)) {
			return;
		}
		foreach ($results as $i => $item) {
			foreach ($item[$with] as $field) {
				$results[$i][$Model->alias][$field['key']] = $field['val'];
			}
		}
		return $results;
	}

	function afterSave(&$Model) {
		extract($this->settings[$Model->alias]);
		$fields = array_diff_key($Model->data[$Model->alias], $schema);
		$id = $Model->id;
		foreach ($fields as $key => $val) {
			$field = $Model->{$with}->find('first', array(
				'fields' => array($with.'.id'),
				'conditions' => array($with.'.'.$foreignKey => $id, $with.'.key' => $key),
				'recursive' => -1,
			));
			$Model->{$with}->create(false);
			if ($field) {
				$Model->{$with}->set('id', $field[$with]['id']);
			} else {
				$Model->{$with}->set(array($foreignKey => $id, 'key' => $key));
			}
			$Model->{$with}->set('val', $val);
			$Model->{$with}->save();
		}
	}
}

?>