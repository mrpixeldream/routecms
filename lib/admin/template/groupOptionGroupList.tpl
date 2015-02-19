{foreach from=$groupList item="groupOption"}
    <div class="large-12 small-12 medium-12 columns">
        <input type="checkbox" id="{$option->name}{$groupOption->groupID}" {if $__Routecms->in_array($groupOption->groupID, $__Routecms->explode("\n", $value))} checked="checked"{/if}
               name="groupOptionValues[{$option->name}][{$groupOption->groupID}]" value="1"/>
        <label for="{$option->name}{$groupOption->groupID}">{lang $groupOption->name}</label>
    </div>
    {event name="test"}
{/foreach}