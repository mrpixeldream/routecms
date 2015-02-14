{include file="header"}
{include file="menu"}
<div class="column">
    <header>
        <h2>{lang "system.page.title.members"} <span class="label round" style="font-size: 1.4rem;">{#$count}</span>
        </h2>
    </header>
    {pages print=true link="index.php?page=MemberList" sortField=$sortField sortOrder=$sortOrder}
    <table class="responsive userTable" role="grid" style="width: 100%">
        <thead>
        <tr>
            <th{if $sortField == 'userID'} class="active {@$sortOrder}"{/if}><a
                        href="index.php?page=MemberList&amp;pageNo={@$pageNo}&amp;sortField=userID&amp;sortOrder={if $sortField == "userID" && $sortOrder == "ASC"}DESC{else}ASC{/if}">{lang "system.global.id"}</a>
            </th>
            <th{if $sortField == 'username'} class="active {@$sortOrder}"{/if}><a
                        href="index.php?page=MemberList&amp;pageNo={@$pageNo}&amp;sortField=username&amp;sortOrder={if $sortField == "username" && $sortOrder == "ASC"}DESC{else}ASC{/if}">Username</a>
            </th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$objects item='user'}
            <tr data-row-id="{#$user->userID}">
                <td>
                    <a href="index.php?page=user&amp;userID={#$user->userID}">{#$user->userID}</a>
                    {if $__Routecms->checkPermission("admin.can.delete.user") && $__Routecms->__call(array('User', 'canMangedUser'), array($user))}
                        <i class="ajaxMessage alert fi-x" aria-haspopup="true" data-tooltip
                           data-reveal-id="userDeleteID{#$user->userID}" title="{lang "user.delete"}"></i>
                        <div class="reveal-modal ajax" data-action="delete" id="userDeleteID{#$user->userID}"
                             data-reveal>
                            <p>{lang "user.delete.sure"}</p>
                            <button class="request" data-action="delete"
                                    data-link="index.php?page=DeleteUser&amp;userID={#$user->userID}"
                                    data-delete-row-id="{#$user->userID}">Ja
                            </button>
                            <button class="close">Nein</button>
                            <a class="close-reveal-modal">&#215;</a>
                        </div>
                    {else}
                        <i class="disabled alert fi-x"></i>
                    {/if}
                    {if $__Routecms->checkPermission("admin.can.edit.user")}
                        <a href="index.php?page=user&amp;userID={#$user->userID}"><i aria-haspopup="true" data-tooltip
                                                                                     class="fi-pencil"
                                                                                     title="{lang "user.edit"}"></i></a>
                    {else}
                        <i class="fi-pencil disabled"></i>
                    {/if}
                </td>
                <td>{$user->username}</td>
            </tr>
        {/foreach}
        </tbody>
    </table>
    {@$pageLinks}
</div>
{include file="footer"}