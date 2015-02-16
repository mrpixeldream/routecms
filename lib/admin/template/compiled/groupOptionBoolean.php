<?php
/**
 * Hash : 46b5303ee4e5651fdd1221b48b9c638caf3d34fb
 */
?>
<div class="large-12 small-12 medium-12 columns">
    <input type="checkbox" id="<?php echo HTMLEncode($this->vars['option']->name) ?>" <?php if($this->vars['value']) { ?> checked="checked"<?php } ?>
           name="groupOptionValues[<?php echo HTMLEncode($this->vars['option']->name) ?>]" value="1"/>
    <label for="<?php echo HTMLEncode($this->vars['option']->name) ?>"><?php echo lang("user.grou.option.".$this->vars['option']->name) ?></label>
</div>
