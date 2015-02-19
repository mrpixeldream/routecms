<?php
/**
 * Hash : 662c3aa5cb763558034c06806c4f37104c2916a1
 */
?>
<?php foreach($this->vars['groupList'] as $this->vars["groupOption"]){?>
    <div class="large-12 small-12 medium-12 columns">
        <input type="checkbox" id="<?php echo HTMLEncode($this->vars['option']->name) ?><?php echo HTMLEncode($this->vars['groupOption']->groupID) ?>" <?php if($this->vars['__Routecms']->in_array($this->vars['groupOption']->groupID,$this->vars['__Routecms']->explode("\n",$this->vars['value']))) { ?> checked="checked"<?php } ?>
               name="groupOptionValues[<?php echo HTMLEncode($this->vars['option']->name) ?>][<?php echo HTMLEncode($this->vars['groupOption']->groupID) ?>]" value="1"/>
        <label for="<?php echo HTMLEncode($this->vars['option']->name) ?><?php echo HTMLEncode($this->vars['groupOption']->groupID) ?>"><?php echo lang($this->vars['groupOption']->name) ?></label>
    </div>
    
<?php } ?>