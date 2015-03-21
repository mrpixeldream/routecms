<?php
/**
 * Hash : 63ec2223666b9c24edbdaf7fe3bec9dcce98b012
 */
?>
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
                <?php foreach($this->vars['menuTree'] as $this->vars['item']){?>
                    <li<?php if($this->vars['pageName'] == $this->vars['item']->page) { ?> class="active"<?php } ?>>
                        <a class="menuItem"
                           href="index.php?page=<?php echo $this->vars['item']->page ?>"><?php echo routecms\Routecms::lang("system.page.admin.menu.".$this->vars['item']->name) ?></a>
                        <?php if(count($this->vars['item']->getParent()) > 0){ ?>
                            <a class="dropdownIcon fi-arrow-down"></a>
                            <ul class="side-nav-parent" style="display: none;">
                                <?php foreach($this->vars['item']->getParent() as $this->vars['parent']){?>
                                    <li<?php if($this->vars['pageName'] == $this->vars['parent']->page) { ?> class="active"<?php } ?>>
                                        <a class="parentMenuItem"
                                           href="index.php?page=<?php echo $this->vars['parent']->page ?>"><?php echo routecms\Routecms::lang("system.page.admin.menu.".$this->vars['parent']->name) ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="small-12 medium-9 large-10 columns right" role="mainContent" style="padding: 0">
<?php include("tob-bar.php") ?>