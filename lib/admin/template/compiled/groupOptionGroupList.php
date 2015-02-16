<?php
/**
 * Hash : ec813b8f1a327aa2995bf1174270ef9a849caf3f
 */
?>
<?php foreach($this->vars['groupList'] as $this->vars["groupOption"]){?>
    <div class="large-12 small-12 medium-12 columns">
        <input type="checkbox" id="<?php echo HTMLEncode($this->vars['option']->name) ?><?php echo HTMLEncode($this->vars['groupOption']->groupID) ?>" <?php if($this->vars['value']) { ?> checked="checked"<?php } ?>
               name="groupOptionValues[<?php echo HTMLEncode($this->vars['option']->name) ?>][<?php echo HTMLEncode($this->vars['groupOption']->groupID) ?>]" value="1"/>
        <label for="<?php echo HTMLEncode($this->vars['option']->name) ?><?php echo HTMLEncode($this->vars['groupOption']->groupID) ?>"><?php echo lang($this->vars['groupOption']->name) ?></label>
    </div>
<?php } ?>