<?php
/**
 * Hash : 40b2e82237afb438dd40596601b00445f7a489e9
 */
?>
<?php include("header.php") ?>
<?php include("menu.php") ?>
<div class="column">
    <header>
        <h2><?php echo lang("system.page.title.members") ?> <span class="label round" style="font-size: 1.4rem;"><?php echo intval($this->vars['count']) ?></span>
        </h2>
    </header>
    <?php $this->vars["pageLinks"] = Pagination::getPagination("index.php?page=GroupList"."&amp;sortOrder=".$this->vars['sortOrder']."&amp;sortField=".$this->vars['sortField'], $this->vars["pages"], $this->vars["pageNo"]);
			echo $this->vars["pageLinks"];
			?>
    <table class="responsive userTable" role="grid" style="width: 100%">
        <thead>
        <tr>
            <th<?php if($this->vars['sortField'] == 'groupID') { ?> class="active <?php echo $this->vars['sortOrder'] ?>"<?php } ?>><a
                        href="index.php?page=GroupList&amp;pageNo=<?php echo $this->vars['pageNo'] ?>&amp;sortField=groupID&amp;sortOrder=<?php if($this->vars['sortField'] == "groupID" && $this->vars['sortOrder'] == "ASC") { ?>DESC<?php }else{ ?>ASC<?php } ?>"><?php echo lang("system.global.id") ?></a>
            </th>
            <th<?php if($this->vars['sortField'] == 'name') { ?> class="active <?php echo $this->vars['sortOrder'] ?>"<?php } ?>><a
                        href="index.php?page=GroupList&amp;pageNo=<?php echo $this->vars['pageNo'] ?>&amp;sortField=name&amp;sortOrder=<?php if($this->vars['sortField'] == "name" && $this->vars['sortOrder'] == "ASC") { ?>DESC<?php }else{ ?>ASC<?php } ?>"><?php echo lang("system.global.name") ?></a>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($this->vars['objects'] as $this->vars['group']){?>
            <tr data-row-id="<?php echo intval($this->vars['group']->groupID) ?>">
                <td>
                    <a href="index.php?page=groupEdit&amp;groupID=<?php echo intval($this->vars['group']->groupID) ?>"><?php echo intval($this->vars['group']->groupID) ?></a>
                    <?php if($this->vars['__Routecms']->checkPermission("admin.can.delete.group") && $this->vars['__Routecms']->in_array($this->vars['group']->groupID,$this->vars['__Routecms']->getPermission("admin.can.mange.group"))) { ?>
                        <i class="ajaxMessage alert fi-x" aria-haspopup="true" data-tooltip
                           data-reveal-id="groupDeleteID<?php echo intval($this->vars['group']->groupID) ?>" title="<?php echo lang("system.global.delete") ?>"></i>
                        <div class="reveal-modal ajax" data-action="delete" id="groupDeleteID<?php echo intval($this->vars['group']->groupID) ?>"
                             data-reveal>
                            <p><?php echo lang("group.delete.sure") ?></p>
                            <button class="request"
                                    data-link="index.php?page=DeleteGroup&amp;groupID=<?php echo intval($this->vars['group']->groupID) ?>"
                                    data-delete-row-id="<?php echo intval($this->vars['group']->groupID) ?>"><?php echo lang("system.global.yes") ?></button>
                            <button class="close"><?php echo lang("system.global.no") ?></button>
                            <a class="close-reveal-modal">&#215;</a>
                        </div>
                    <?php }else{ ?>
                        <i class="fi-x disabled"></i>
                    <?php } ?>
                    <?php if($this->vars['__Routecms']->checkPermission("admin.can.edit.group") && $this->vars['__Routecms']->in_array($this->vars['group']->groupID,$this->vars['__Routecms']->getPermission("admin.can.mange.group"))) { ?>
                        <a href="index.php?page=groupEdit&amp;groupID=<?php echo intval($this->vars['group']->groupID) ?>"><i aria-haspopup="true"
                                                                                             data-tooltip
                                                                                             class="fi-pencil"
                                                                                             title="<?php echo lang("system.global.edit") ?>"></i></a>
                    <?php }else{ ?>
                        <i class="fi-pencil disabled"></i>
                    <?php } ?>
                </td>
                <td><?php echo lang($this->vars['group']->name) ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php echo $this->vars['pageLinks'] ?>
</div>
<?php include("footer.php") ?>