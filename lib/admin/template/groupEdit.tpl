{include file="header"}
{include file="menu"}


<form class="column">
    <div class="content-box">
        <ul class="panel tabs" data-tab role="tablist">
            {assign var="first" value=true}
            {foreach from=$tree item=category}
                <li role="presentational"
                    class="tab-title small{if $first} active{assign var="first" value=false}{/if}"><a
                            href="index.php?page=groupEdit&groupID={#$groupID}#category{@$category->categoryID}">{lang "user.category.".$category->name}</a>
                </li>
            {/foreach}
        </ul>
        <div class="tabs-content">
            {assign var="first" value=true}
            {foreach from=$tree item=category}
                <div class="column noContentTab content{if $first} active{assign var="first" value=false}{/if}"
                     aria-hidden="true" id="category{@$category->categoryID}">
                    {count var=$category->getParent()  min=0}
                        <ul class="panel tabs small" data-tab role="tablist">
                            {assign var="first" value=true}
                            {foreach from=$category->getParent() item=parent}
                                <li role="presentational"
                                    class="tab-title{if $first} active{assign var="first" value=false}{/if}"><a
                                            href="index.php?page=groupEdit&groupID={#$groupID}#category{@$parent->categoryID}">{lang "user.category.".$parent->name}</a>
                                </li>
                            {/foreach}
                        </ul>
                        <div class="tabs-content">
                            {assign var="first" value=true}
                            {foreach from=$category->getParent() item=parent}
                                <div class="column panel container content no-border-top{if $first} active{assign var="first" value=false}{/if}"
                                     aria-hidden="true" id="category{@$parent->categoryID}">
                                    <fieldset>
                                        <legend>{lang "user.category.".$parent->name}</legend>
                                        {foreach from=$parent->getOptionList() item="option"}
                                            {assign var="templateName" value=$optionList[$option->optionID]["output"]->getTemplate()}
                                            {include file=$templateName}
                                        {/foreach}
                                    </fieldset>
                                    {foreach from=$parent->getParent() item=optionCategory}
                                        <fieldset>
                                            <legend>{lang "user.category.".$optionCategory->name}</legend>
                                            {foreach from=$optionCategory->getOptionList() item="option"}
                                                {assign var="templateName" value=$optionList[$option->optionID]["output"]->getTemplate()}
                                                {include file=$templateName}
                                            {/foreach}
                                        </fieldset>
                                    {/foreach}
                                </div>
                            {/foreach}
                        </div>
                    {/count}
                </div>
            {/foreach}
        </div>
    </div>
    <div class="row large-12 small-12 medium-12 fullRow">
        <div class="large-5 small-12 medium-3 columns">
        </div>
        <div class="large-7 small-12 medium-9 columns">
            <button type="submit"> {lang "system.global.button.send"}</button>
            <button type="submit"> {lang "system.global.button.back"}</button>
        </div>
    </div>
</form>
{include file="footer"}