<?php
/**
 * Hash : 1f0f013069422902f4527f8898f923b34a90849b
 */
?>
<?php include("header.php") ?>
<?php include("menu.php") ?>
<div class="column">
    <header>
        <h2><?php echo lang("system.page.title.members") ?> <span class="label round" style="font-size: 1.4rem;"><?php echo intval($this->vars['count']) ?></span>
        </h2>
    </header>
    <?php $this->vars["pageLinks"] = Pagination::getPagination("index.php?page=MemberList"."&amp;sortOrder=".$this->vars['sortOrder']."&amp;sortField=".$this->vars['sortField'], $this->vars["pages"], $this->vars["pageNo"]);
			echo $this->vars["pageLinks"];
			?>
    <table class="responsive userTable" role="grid" style="width: 100%">
        <thead>
        <tr>
            <th<?php if($this->vars['sortField'] == 'userID') { ?> class="active <?php echo $this->vars['sortOrder'] ?>"<?php } ?>><a
                        href="index.php?page=MemberList&amp;pageNo=<?php echo $this->vars['pageNo'] ?>&amp;sortField=userID&amp;sortOrder=<?php if($this->vars['sortField'] == "userID" && $this->vars['sortOrder'] == "ASC") { ?>DESC<?php }else{ ?>ASC<?php } ?>"><?php echo lang("system.global.id") ?></a>
            </th>
            <th<?php if($this->vars['sortField'] == 'username') { ?> class="active <?php echo $this->vars['sortOrder'] ?>"<?php } ?>><a
                        href="index.php?page=MemberList&amp;pageNo=<?php echo $this->vars['pageNo'] ?>&amp;sortField=username&amp;sortOrder=<?php if($this->vars['sortField'] == "username" && $this->vars['sortOrder'] == "ASC") { ?>DESC<?php }else{ ?>ASC<?php } ?>">Username</a>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($this->vars['objects'] as $this->vars['user']){?>
            <tr data-row-id="<?php echo intval($this->vars['user']->userID) ?>">
                <td>
                    <a href="index.php?page=user&amp;userID=<?php echo intval($this->vars['user']->userID) ?>"><?php echo intval($this->vars['user']->userID) ?></a>
                    <?php if($this->vars['__Routecms']->checkPermission("admin.can.delete.user") && $this->vars['__Routecms']->__call(array('User','canMangedUser'),array($this->vars['user']))) { ?>
                        <i class="ajaxMessage alert fi-x" aria-haspopup="true" data-tooltip
                           data-reveal-id="userDeleteID<?php echo intval($this->vars['user']->userID) ?>" title="<?php echo lang("user.delete") ?>"></i>
                        <div class="reveal-modal ajax" data-action="delete" id="userDeleteID<?php echo intval($this->vars['user']->userID) ?>"
                             data-reveal>
                            <p><?php echo lang("user.delete.sure") ?></p>
                            <button class="request" data-action="delete"
                                    data-link="index.php?page=DeleteUser&amp;userID=<?php echo intval($this->vars['user']->userID) ?>"
                                    data-delete-row-id="<?php echo intval($this->vars['user']->userID) ?>">Ja
                            </button>
                            <button class="close">Nein</button>
                            <a class="close-reveal-modal">&#215;</a>
                        </div>
                    <?php }else{ ?>
                        <i class="disabled alert fi-x"></i>
                    <?php } ?>
                    <?php if($this->vars['__Routecms']->checkPermission("admin.can.edit.user")) { ?>
                        <a href="index.php?page=user&amp;userID=<?php echo intval($this->vars['user']->userID) ?>"><i aria-haspopup="true" data-tooltip
                                                                                     class="fi-pencil"
                                                                                     title="<?php echo lang("user.edit") ?>"></i></a>
                    <?php }else{ ?>
                        <i class="fi-pencil disabled"></i>
                    <?php } ?>
                </td>
                <td><?php echo HTMLEncode($this->vars['user']->username) ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php echo $this->vars['pageLinks'] ?>
</div>
<?php include("footer.php") ?>