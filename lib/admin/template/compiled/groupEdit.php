<?php
/**
 * Hash : 1c09552177270e6f49dfc073a4cb9b7209a2b3e7
 */
?>
<?php include("header.php") ?>
<?php include("menu.php") ?>


<form class="column" action="?page=groupEdit&groupID=<?php echo intval($this->vars['groupID']) ?>" method="post">
    <div class="content-box">
        <ul class="panel tabs" data-tab role="tablist">
            <?php $this->vars["first"] =true; ?>
            <?php foreach($this->vars['tree'] as $this->vars['category']){?>
                <li role="presentational"
                    class="tab-title small<?php if($this->vars['first']) { ?> active<?php $this->vars["first"] =false; ?><?php } ?>"><a
                            href="index.php?page=groupEdit&groupID=<?php echo intval($this->vars['groupID']) ?>#category<?php echo $this->vars['category']->categoryID ?>"><?php echo routecms\Routecms::lang("user.category.".$this->vars['category']->name) ?></a>
                </li>
            <?php } ?>
        </ul>
        <div class="tabs-content">
            <?php $this->vars["first"] =true; ?>
            <?php foreach($this->vars['tree'] as $this->vars['category']){?>
                <div class="column noContentTab content<?php if($this->vars['first']) { ?> active<?php $this->vars["first"] =false; ?><?php } ?>"
                     aria-hidden="true" id="category<?php echo $this->vars['category']->categoryID ?>">
                    <?php if(count($this->vars['category']->getParent()) > 0){ ?>
                        <ul class="panel tabs small" data-tab role="tablist">
                            <?php $this->vars["first"] =true; ?>
                            <?php foreach($this->vars['category']->getParent() as $this->vars['parent']){?>
                                <li role="presentational"
                                    class="tab-title<?php if($this->vars['first']) { ?> active<?php $this->vars["first"] =false; ?><?php } ?>"><a
                                            href="index.php?page=groupEdit&groupID=<?php echo intval($this->vars['groupID']) ?>#category<?php echo $this->vars['parent']->categoryID ?>"><?php echo routecms\Routecms::lang("user.category.".$this->vars['parent']->name) ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                        <div class="tabs-content">
                            <?php $this->vars["first"] =true; ?>
                            <?php foreach($this->vars['category']->getParent() as $this->vars['parent']){?>
                                <div class="column panel container content no-border-top<?php if($this->vars['first']) { ?> active<?php $this->vars["first"] =false; ?><?php } ?>"
                                     aria-hidden="true" id="category<?php echo $this->vars['parent']->categoryID ?>">
                                    <?php if(count($this->vars['parent']->getOptionList()) > 0){ ?>
                                        <fieldset>
                                            <legend><?php echo routecms\Routecms::lang("user.category.".$this->vars['parent']->name) ?></legend>
                                            <div class="row">
                                                <?php foreach($this->vars['parent']->getOptionList() as $this->vars["option"]){?>
                                                    <?php $this->vars["value"] =$this->vars['optionList'][$this->vars['option']->optionID]["output"]->getValue(); ?>
                                                    <?php echo $this->vars['optionList'][$this->vars['option']->optionID]["output"]->fetchTemplate() ?>
                                                <?php } ?>
                                            </div>
                                        </fieldset>
                                    <?php } ?>
                                    <?php foreach($this->vars['parent']->getParent() as $this->vars['optionCategory']){?>
                                        <?php if(count($this->vars['optionCategory']->getOptionList()) > 0){ ?>
                                            <fieldset>
                                                <legend><?php echo routecms\Routecms::lang("user.category.".$this->vars['optionCategory']->name) ?></legend>
                                                <div class="row">
                                                    <?php foreach($this->vars['optionCategory']->getOptionList() as $this->vars["option"]){?>
                                                        <?php $this->vars["value"] =$this->vars['optionList'][$this->vars['option']->optionID]["output"]->getValue(); ?>
                                                        <?php echo $this->vars['optionList'][$this->vars['option']->optionID]["output"]->fetchTemplate() ?>
                                                    <?php } ?>
                                                </div>
                                            </fieldset>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="row large-12 small-12 medium-12 fullRow">
        <div class="large-5 small-12 medium-3 columns">
        </div>
        <div class="large-7 small-12 medium-9 columns">
            <button type="submit"> <?php echo routecms\Routecms::lang("system.global.button.send") ?></button>
            <button type="submit"> <?php echo routecms\Routecms::lang("system.global.button.back") ?></button>
        </div>
    </div>
</form>
<?php include("footer.php") ?>