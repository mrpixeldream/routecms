{include file="header"}
{include file="menu"}
<div class="column">
    <header>
        <h2>{lang "system.page.title.members"} <span class="label round" style="font-size: 1.4rem;">{#$count}</span>
        </h2>
    </header>
    {pages print=true link="index.php?page=GroupList" sortField=$sortField sortOrder=$sortOrder}
    <table class="responsive userTable" role="grid" style="width: 100%">
        <thead>
        <tr>
            <th{if $sortField == 'groupID'} class="active {@$sortOrder}"{/if}><a
                        href="index.php?page=GroupList&amp;pageNo={@$pageNo}&amp;sortField=groupID&amp;sortOrder={if $sortField == "groupID" && $sortOrder == "ASC"}DESC{else}ASC{/if}">{lang "system.global.id"}</a>
            </th>
            <th{if $sortField == 'name'} class="active {@$sortOrder}"{/if}><a
                        href="index.php?page=GroupList&amp;pageNo={@$pageNo}&amp;sortField=name&amp;sortOrder={if $sortField == "name" && $sortOrder == "ASC"}DESC{else}ASC{/if}">{lang "system.global.name"}</a>
            </th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$objects item='group'}
            <tr data-row-id="{#$group->groupID}">
                <td>
                    <a href="index.php?page=groupEdit&amp;groupID={#$group->groupID}">{#$group->groupID}</a>
                    {if ($__Routecms->checkPermission("admin.can.delete.group") && $__Routecms->in_array($group->groupID ,$__Routecms->getPermission("admin.can.mange.group"))) && !$__Routecms->in_array($group->groupID ,array(1,2))}
                        <i class="ajaxMessage alert fi-x" aria-haspopup="true" data-tooltip
                           data-reveal-id="groupDeleteID{#$group->groupID}" title="{lang "system.global.delete"}"></i>
                        <div class="reveal-modal ajax" data-action="delete" id="groupDeleteID{#$group->groupID}"
                             data-reveal>
                            <p>{lang "group.delete.sure"}</p>
                            <button class="request"
                                    data-link="index.php?page=DeleteGroup&amp;groupID={#$group->groupID}"
                                    data-delete-row-id="{#$group->groupID}">{lang "system.global.yes"}</button>
                            <button class="close">{lang "system.global.no"}</button>
                            <a class="close-reveal-modal">&#215;</a>
                        </div>
                    {else}
                        <i class="fi-x disabled"></i>
                    {/if}
                    {if $__Routecms->checkPermission("admin.can.edit.group") && $__Routecms->in_array($group->groupID ,$__Routecms->getPermission("admin.can.mange.group"))}
                        <a href="index.php?page=groupEdit&amp;groupID={#$group->groupID}"><i aria-haspopup="true"
                                                                                             data-tooltip
                                                                                             class="fi-pencil"
                                                                                             title="{lang "system.global.edit"}"></i></a>
                    {else}
                        <i class="fi-pencil disabled"></i>
                    {/if}
                </td>
                <td>{lang $group->name}</td>
            </tr>
        {/foreach}
        </tbody>
    </table>
    {@$pageLinks}
</div>
{include file="footer"}