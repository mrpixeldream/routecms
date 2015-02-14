<div class="row fullRow">
    <div class="small-12 medium-12 large-12">
        <div class="show-for-medium-up medium-3 large-2 columns left sidebar-menu" role="navigation" data-open="0">
            <div class="logo-area">
                <div>
                    <div class="show-for-small">
                        <a id="adminMenuClose"><span class="fi-list"></span> </a>
                    </div>
                </div>
                <img src="images/logo.png" alt="logo">
            </div>
            <ul class="side-nav">
                {foreach from=$menuTree item=item}
                    <li{if $pageName == $item->page} class="active"{/if}>
                        <a class="menuItem"
                           href="index.php?page={@$item->page}">{lang "system.page.admin.menu.".$item->name}</a>
                        {count var=$item->getParent() min=0}
                            <a class="dropdownIcon fi-arrow-down"></a>
                            <ul class="side-nav-parent" style="display: none;">
                                {foreach from=$item->getParent() item=parent}
                                    <li{if $pageName == $parent->page} class="active"{/if}>
                                        <a class="parentMenuItem"
                                           href="index.php?page={@$parent->page}">{lang "system.page.admin.menu.".$parent->name}</a>
                                    </li>
                                {/foreach}
                            </ul>
                        {/count}
                    </li>
                {/foreach}
            </ul>
        </div>
        <div class="small-12 medium-9 large-10 columns right" role="mainContent" style="padding: 0">
{include file="tob-bar"}