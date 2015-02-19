<?php
/**
 * Hash : b06a56c304b70a591c6a2a1966c47684f57bc039
 */
?>
<?php foreach($this->vars['groupList'] as $this->vars["groupOption"]){?>
    <div class="large-12 small-12 medium-12 columns">
        <input type="checkbox" id="<?php echo HTMLEncode($this->vars['option']->name) ?><?php echo HTMLEncode($this->vars['groupOption']->groupID) ?>" <?php if($this->vars['__Routecms']->in_array($this->vars['groupOption']->groupID,$this->vars['__Routecms']->explode("\n",$this->vars['value']))) { ?> checked="checked"<?php } ?>
               name="groupOptionValues[<?php echo HTMLEncode($this->vars['option']->name) ?>][<?php echo HTMLEncode($this->vars['groupOption']->groupID) ?>]" value="1"/>
        <label for="<?php echo HTMLEncode($this->vars['option']->name) ?><?php echo HTMLEncode($this->vars['groupOption']->groupID) ?>"><?php echo lang($this->vars['groupOption']->name) ?></label>
    </div>
<?php } ?>