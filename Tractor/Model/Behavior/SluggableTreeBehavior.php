<?php

// File -> app/models/behaviors/sluggable_tree.php

/** 
 * Thanks to Mariano Iglesias - the developer of Sluggable behavior,
 * which is the core of SluggableTree and thanks to CakePHP core team.
 *   
 * With SluggableTree behavior you will be able to make the nice
 * urls on tree based menus and translate the tree slug and tree path 
 * to any locales your application uses. This behavior will automatically
 * synchronize the tree path with leaf`s child slugs then it is modified.
 * 
 * @author sky_l3ppard
 * @version 1.0.0
 * @license MIT
 * @category Behaviors
 */
App::uses('SluggableBehavior', 'Model/Behavior'); 

class SluggableTreeBehavior extends SluggableBehavior {
    
    /**
     * List of options required for communication
     * between callback processes
     * 
     * @var array - list of runtime options
     * @access private
     */
    var $__runtime = array();
    
    /**
     * If any behavior which extends Translate is attached,
     * this variable is storing the name of this behavior.
     * Then SluggableTree behavior knows how to translate
     * the slug
     * 
     * @var string - name of Translate behavior attached
     * @access private
     */
    var $__translate = false;
    
    /**
     * If translate behavior is found. These fields
     * will be added for translation in runtime data
     * 
     * @var array - list of fields to translate
     * @access protected
     */
    var $_translatable = array();
    
    /**
     * Initiate behavior with specified settings, which are common
     * with extended Sluggable behavior
     *  
    * Available settings are:
     * 
     * For SluggableTree behavior
     * 
     * - delimiter:    (string, optional) The tree slug/path delimiter used to separate
     *                 slugs in path.
     * 
     * - pathField: (string, optional) If this field is not empty, the pathField will
     *                 contain the path of the tree leaf, if pathField value is false - 
     *                 then 'slug' field will be used to store the path.
     * 
     * For Sluggable behavior
     *  
     * - label:     (array | string, optional) set to the field name that contains the
     *                 string from where to generate the slug, or a set of field names to
     *                 concatenate for generating the slug. DEFAULTS TO: title
     *
     * - slug:        (string, optional) name of the field name that holds generated slugs.
     *                 DEFAULTS TO: slug
     *
     * - separator:    (string, optional) separator character / string to use for replacing
     *                 non alphabetic characters in generated slug. DEFAULTS TO: -
     *
     * - length:    (integer, optional) maximum length the generated slug can have.
     *                 DEFAULTS TO: 100
     *
     * - overwrite: (boolean, optional) set to true if slugs should be re-generated when
     *                 updating an existing record. DEFAULTS TO: false
     * 
     * - translation: allows you to specify two methods of built-in character translation 
     *                 (utf-8 and iso-8859-1) to keep specific characters from being considered 
     *                 as invalid, or declare your own translation tables.
     *     
     * @see cake/libs/model/ModelBehavior#setup($model, $config)
     * @param object $Model - reference to the Model
     * @param array $settings - list of settings used for this behavior
     * @return void
     * @access public
     */
    function setup(Model $Model, $settings = array()) {
        $default = array(
            'delimiter' => '/',
            'pathField' => 'path'
        );
        $settings = array_merge($default, (array)$settings);
        //settings passed to Sluggable behavior
        parent::setup($Model, (array)$settings);
    }
    
    /**
     * In this case beforeSave callback converts the label fields to the slug
     * and updates a slug by parent leafs. Also if record is being edited, 
     * this method will prepare data for synchronization of tree leaf childs
     * 
     * @see models/behaviors/SluggableBehavior#beforeSave($Model)
     * @param object $Model - reference to the Model
     * @return boolean - true on success, false on rollback
     * @access public
     */
    function beforeSave(Model $Model) {
        parent::beforeSave($Model);
        
        if (empty($Model->data[$Model->alias][$this->__settings[$Model->alias]['slug']])) {
            $this->_invalidateLabelFields($Model, __('Slug was not found in Model data'));
            return false;
        }
        //check for Translate behavior 
        $this->__isSlugTranslatable($Model);
        //prepare Tree synchronization data if Tree behavior is enabled
        $hasPathField = $this->__settings[$Model->alias]['pathField'] !== false;
        //find out which field to use for path
        $pathField = $hasPathField ? $this->__settings[$Model->alias]['pathField'] : $this->__settings[$Model->alias]['slug'];
        if ($Model->Behaviors->enabled('Tree') && ($Model->hasField($this->__settings[$Model->alias]['pathField']) || !$hasPathField)) {
            //get the slug and concat with elements in path
            $path = $Model->data[$Model->alias][$this->__settings[$Model->alias]['slug']];
            $parentId = $Model->data[$Model->alias]['parent_id'];
            while ($parentId) {
                $fields = array($Model->alias.'.'.$this->__settings[$Model->alias]['slug'], $Model->alias.'.parent_id');
                $conditions = array($Model->alias.'.'.$Model->primaryKey => $parentId);
                $recursive = -1;
                            
                $record = $Model->find('first', compact('conditions', 'fields', 'recursive'));
                $path = $record[$Model->alias][$this->__settings[$Model->alias]['slug']].$this->__settings[$Model->alias]['delimiter'].$path;
                
                $pathInfo = $Model->schema($pathField);
                
                if ($pathInfo['length'] and $pathInfo['length'] < strlen($path)) {
                    $this->_invalidateLabelFields($Model, __('Path is too long, check your sluggable field length'));
                    return false;
                }
                $parentId = $record[$Model->alias]['parent_id'];
                unset($record);
            }
            
            //check if is unique path
           $conditions = array($Model->alias.'.'.$pathField => $path, $Model->alias.'.id !=' => $Model->id);
            if ($Model->find('count', compact('conditions'))) {
                $this->_invalidateLabelFields($Model, __('Tree path must be unique'));
                return false;
            }
            
            if (!empty($Model->id)) {
                $newPath = explode('/', $path);
                $this->__runtime[$Model->alias]['changeTo'] = $Model->data[$Model->alias][$this->__settings[$Model->alias]['slug']];
                $position = array_search($this->__runtime[$Model->alias]['changeTo'], $newPath);
                $this->__runtime[$Model->alias]['position'] = $position;
                $this->__runtime[$Model->alias]['field'] = $pathField;
            }
            if (!$hasPathField) {
                $Model->data[$Model->alias][$this->__settings[$Model->alias]['slug']] = $path;
            } else {
                $Model->data[$Model->alias][$this->__settings[$Model->alias]['pathField']] = "/" . $path;
            }
        }
        
        //if you use another Translate or extended Translate bahavior, logic goes here
        if (!empty($this->__translate) && $Model->Behaviors->enabled($this->__translate)) {
            //Translate behavior must be executed before SluggableTree, changing order if necessary
            $attached = $Model->Behaviors->attached();
            if (array_search($this->__translate, $attached) > array_search('SluggableTree', $attached)) {
                unset($Model->Behaviors->_attached[array_search($this->__translate, $attached)]);
                array_unshift($Model->Behaviors->_attached, $this->__translate);
            }
            //checking if slug is a translatable field
            $trans =& $Model->Behaviors->{$this->__translate};
            foreach ($this->_translatable as $fld) {
                $trans->runtime[$Model->alias]['beforeSave'][$fld] = $Model->data[$Model->alias][$fld];
            }
        }
        return true;
    }
    
    /**
     * Synchronizes the saved leaf`s child slugs
     * 
     * @param object $Model - reference to the Model
     * @param boolean $created - true if record was inserted
     * @return void
     * @access public
     */
    function afterSave(Model $Model, $created) {
        parent::afterSave($Model, $created);
        
        if (empty($this->__runtime[$Model->alias])) {
            return;
        }
        //synchronization requires disabling this bahavior
        $Model->Behaviors->disable('SluggableTree');
        $this->_sync($Model, $Model->id);
        $Model->Behaviors->enable('SluggableTree');
        //clearing all runtime data
        unset($this->__runtime[$Model->alias]);
    }
    
    /**
     * Synchronizes child slugs
     * 
     * @param object $Model - reference to the Model
     * @param integer $leafId - id of leaf being updated
     * @return void
     * @access protected
     */
    function _sync(Model $Model, $leafId) {
        //getting runtime data
        $runtime =& $this->__runtime[$Model->alias];
        
        $conditions = array($Model->alias.'.parent_id' => $leafId);
        $fields = array($Model->alias.'.'.$Model->primaryKey, $Model->alias.'.'.$runtime['field']);
        $recursive = -1;
        //get all children
        $children = $Model->find('all', compact('conditions', 'fields', 'recursive'));
        if (empty($children)) {
            return;
        }
        foreach ($children as $child) {
        	
        	
            $childPath = explode('/', $child[$Model->alias][$runtime['field']]);
            
           
            // to avoid the duplication bug. 
           array_shift($childPath);
            
            $childPath[$runtime['position']] = $runtime['changeTo'];
            
      
            $path = "/" .  join('/', $childPath);

            $Model->create();
            $Model->id = $child[$Model->alias][$Model->primaryKey];
            $Model->data[$Model->alias][$runtime['field']] = $path;
            $Model->save();
            $this->_sync($Model, $child[$Model->alias][$Model->primaryKey]);
        }
    }
    
    /**
     * Checks for attached Translate behavior or any extended
     * Translate behavior and if slug is in the list of translatable
     * fields, then this behavior is used to translate the slug.
     * 
     * @param object $Model - reference to the Model
     * @return void
     * @access private
     */
    function __isSlugTranslatable(Model $Model) {
        if ($Model->Behaviors->attached('Translate')) {
            $this->__translate = 'Translate';
        } else {
            foreach ($Model->Behaviors->attached() as $behavior) {
                if (is_a($Model->Behaviors->{$behavior}, 'TranslateBehavior')) {
                    $this->__translate = $behavior;
                    break;
                }
            } 
        }
        
        if (empty($this->__translate)) {
            return;
        }
        
        //check for translatable fields
        $trans =& $Model->Behaviors->{$this->__translate};
        foreach ($trans->settings[$Model->alias] as $key => $field) {
            $translatableField = is_numeric($key) ? $field : $key;
            if (in_array($translatableField, array($this->__settings[$Model->alias]['slug'], $this->__settings[$Model->alias]['pathField']))) {
                $this->_translatable[] = $translatableField;
            }
        }
        if (count($this->_translatable)) {
            return;
        }
        //field slug and path are not translatable
        $this->__translate = false;
    }
    
    /**
     * Invalidates all label fields with given error message
     * 
     * @param object $Model - reference to the Model
     * @param string $message - message for invalid label fields
     * @return void
     * @access protected
     */
    function _invalidateLabelFields(Model $Model, $message) {
        if (empty($message)) {
            return;
        }
        
        foreach ($this->__settings[$Model->alias]['label'] as $field) {
            $Model->invalidate($field, $message);
        }
    }
}
