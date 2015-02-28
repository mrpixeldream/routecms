<?php
/**
 * Hash : 1a52291144faf68621056e56041a6c2b67f87295
 */
?>
<?php include("header.php") ?>
<?php include("menu.php") ?>
<div class="column">
    <header>
        <h2><?php echo routecms\Routecms::lang("system.page.title.members") ?> <span class="label round" style="font-size: 1.4rem;"><?php echo intval($this->vars['count']) ?></span>
        </h2>
    </header>
    <?php $this->vars["pageLinks"] = routecms\util\Pagination::getPagination("index.php?page=MemberList"."&amp;sortOrder=".$this->vars['sortOrder']."&amp;sortField=".$this->vars['sortField'], $this->vars["pages"], $this->vars["pageNo"]);
			echo $this->vars["pageLinks"];
			?>
    <div class="right small-no-right">
        <a href="index.php?page=UserAdd" class="button small"><?php echo routecms\Routecms::lang("system.global.add") ?></a>
    </div>
    <table class="responsive userTable" role="grid" style="width: 100%">
        <thead>
        <tr>
            <th<?php if($this->vars['sortField'] == 'userID') { ?> class="active <?php echo $this->vars['sortOrder'] ?>"<?php } ?>><a
                        href="index.php?page=MemberList&amp;pageNo=<?php echo $this->vars['pageNo'] ?>&amp;sortField=userID&amp;sortOrder=<?php if($this->vars['sortField'] == "userID" && $this->vars['sortOrder'] == "ASC") { ?>DESC<?php }else{ ?>ASC<?php } ?>"><?php echo routecms\Routecms::lang("system.global.id") ?></a>
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
                    <a href="index.php?page=userEdit&amp;userID=<?php echo intval($this->vars['user']->userID) ?>"><?php echo intval($this->vars['user']->userID) ?></a>
                    <?php if($this->vars['user']->userID != $this->vars['__Routecms']->getUser()->userID && $this->vars['__Routecms']->checkPermission("admin.can.delete.user") && $this->vars['__Routecms']->__call(array('routecms\system\user\User','canMangedUser'),array($this->vars['user']))) { ?>
                        <i class="ajaxMessage alert fi-x" aria-haspopup="true" data-tooltip
                           data-reveal-id="userDeleteID<?php echo intval($this->vars['user']->userID) ?>" title="<?php echo routecms\Routecms::lang("user.delete") ?>"></i>
                        <div class="reveal-modal ajax" data-action="delete" id="userDeleteID<?php echo intval($this->vars['user']->userID) ?>"
                             data-reveal>
                            <p><?php echo routecms\Routecms::lang("user.delete.sure") ?></p>
                            <button class="request" data-action="delete"
                                    data-link="index.php?page=DeleteUser&amp;userID=<?php echo intval($this->vars['user']->userID) ?>"
                                    data-delete-row-id="<?php echo intval($this->vars['user']->userID) ?>"><?php echo routecms\Routecms::lang("system.global.yes") ?>
                            </button>
                            <button class="close"><?php echo routecms\Routecms::lang("system.global.no") ?></button>
                            <a class="close-reveal-modal">&#215;</a>
                        </div>
                    <?php }else{ ?>
                        <i class="disabled alert fi-x"></i>
                    <?php } ?>
                    <?php if($this->vars['__Routecms']->checkPermission("admin.can.edit.user")) { ?>
                        <a href="index.php?page=userEdit&amp;userID=<?php echo intval($this->vars['user']->userID) ?>"><i aria-haspopup="true"
                                                                                         data-tooltip
                                                                                         class="fi-pencil"
                                                                                         title="<?php echo routecms\Routecms::lang("user.edit") ?>"></i></a>
                    <?php }else{ ?>
                        <i class="fi-pencil disabled"></i>
                    <?php } ?>
                </td>
                <td><?php echo routecms\util\String::HTMLEncode($this->vars['user']->username) ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php echo $this->vars['pageLinks'] ?>
    <div class="right small-no-right">
        <a href="index.php?page=UserAdd" class="button small"><?php echo routecms\Routecms::lang("system.global.add") ?></a>
    </div>
</div>
<?php include("footer.php") ?>