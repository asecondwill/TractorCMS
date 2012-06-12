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

    function setUp(&$model, $config = array()) {
        $this->__defaultRules[$model->name] = $model->validate;
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
    function setValidation(&$model, $rules = array()) {
        if (is_array($rules)){
            $this->_setValidation($model, $rules);
        } elseif (isset($model->validationSets[$rules])) {
            $this->setValidation($model, $model->validationSets[$rules]);
        }
    }

    /**
     * Restores previous validation ruleset
     *
     * @param Object $model
     */
    function restoreValidation(&$model) {
        $model->validate = $this->__oldRules[$model->name];
    }

    /**
     * Restores default validation ruleset
     *
     * @param Object $model
     */
    function restoreDefaultValidation(&$model) {
        $model->validate = $this->__defaultRules[$model->name];
    }

    /**
     * Sets a new validation ruleset, saving the previous
     *
     * @param Object $model
     * @param Array $rules
     */
    function _setValidation(&$model, $rules) {
            $this->__oldRules[$model->name] = $model->validate;
            $model->validate = $rules;
    }

}

?>