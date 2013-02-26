<?php
class MultivalidatableBehavior extends ModelBehavior {

    /**
     * Stores previous validation ruleset
     *
     * @var Array
     */
    var $__oldRules = array();

    /**
     * Stores Model default validation ruleset
     *
     * @var unknown_type
     */
    var $__defaultRules = array();

    function setup(Model $Model, $config = array()) {
        $this->__defaultRules[$Model->name] = $Model->validate;
    }

    /**
     * Installs a new validation ruleset
     *
     * If $rules is an array, it will be set as current validation ruleset,
     * otherwise it will look into Model::validationSets[$rules] for the ruleset to install
     *
     * @param Object $model
     * @param Mixed $rules
     */
    function setValidation(Model $Model, $rules = array()) {
        if (is_array($rules)){
            $this->_setValidation($Model, $rules);
        } elseif (isset($Model->validationSets[$rules])) {
            $this->setValidation($Model, $Model->validationSets[$rules]);
        }
    }

    /**
     * Restores previous validation ruleset
     *
     * @param Object $model
     */
    function restoreValidation(Model $Model) {
        $Model->validate = $this->__oldRules[$Model->name];
    }

    /**
     * Restores default validation ruleset
     *
     * @param Object $model
     */
    function restoreDefaultValidation(Model $Model) {
        $Model->validate = $this->__defaultRules[$Model->name];
    }

    /**
     * Sets a new validation ruleset, saving the previous
     *
     * @param Object $model
     * @param Array $rules
     */
    function _setValidation(Model $Model, $rules) {
            $this->__oldRules[$Model->name] = $Model->validate;
            $Model->validate = $rules;
    }

}

?>