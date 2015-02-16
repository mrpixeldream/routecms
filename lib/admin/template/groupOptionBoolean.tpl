<div class="large-12 small-12 medium-12 columns">
    <input type="checkbox" id="{$option->name}" {if $value} checked="checked"{/if}
           name="groupOptionValues[{$option->name}]" value="1"/>
    <label for="{$option->name}">{lang "user.grou.option.".$option->name}</label>
</div>
