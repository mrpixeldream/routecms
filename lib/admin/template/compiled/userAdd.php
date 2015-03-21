<?php
/**
 * Hash : b1567987a861533b56bd6a6aa39219a3500154e5
 */
?>
<?php include("header.php") ?>
<?php include("menu.php") ?>


<form class="column" action="?page=<?php if($this->vars['action'] == "add") { ?>userAdd<?php }else{ ?>userEdit&amp;userID=<?php echo intval($this->vars['userID']) ?><?php } ?>" method="post">
    <div class="content-box">
        <?php if(isset($this->vars['success'])){ ?><span class="alert-box success"><?php echo routecms\Routecms::lang("system.global.success.".$this->vars['action']) ?></span><?php } ?>
        <ul class="panel tabs" data-tab role="tablist">
            <li role="presentational"
                class="tab-title small active"><a
                        href="index.php?page=<?php if($this->vars['action'] == "add") { ?>userAdd<?php }else{ ?>userEdit&amp;userID=<?php echo intval($this->vars['userID']) ?><?php } ?>#categoryGeneral"><?php echo routecms\Routecms::lang("user.profil.category.general") ?></a>
            </li>
        </ul>
        <div class="tabs-content">
            <div class="column content panel container active" aria-hidden="true" id="categoryGeneral">
                <fieldset>
                    <legend><?php echo routecms\Routecms::lang("user.user") ?></legend>
                    <div class="row">
                        <div class="large-12 small-12 medium-12 columns">
                            <label><?php echo routecms\Routecms::lang("user.username") ?>
                                <input type="text"<?php if(isset($this->vars["errorInput"]) && $this->vars["errorInput"] == "username"){ ?> class="error"<?php } ?> name="username" id="username" value="<?php echo routecms\util\String::HTMLEncode($this->vars['username']) ?>">
                            </label>
                            <?php if(isset($this->vars["errorInput"]) && $this->vars["errorInput"] == "username"){ ?>
                                <small class="error">
                                    <?php if($this->vars['errorType'] == "empty") { ?>
                                        <?php echo routecms\Routecms::lang("system.form.empty") ?>
                                    <?php }else{ ?><?php echo routecms\Routecms::lang("user.profil.error.username.".$this->vars['errorType']) ?>
                                    <?php } ?>
                                </small>
                            <?php } ?>
                        </div>
                        <div class="large-12 small-12 medium-12 columns">
                            <label><?php echo routecms\Routecms::lang("user.category.admin.groups") ?></label>
                            <?php foreach($this->vars['groups'] as $this->vars["group"]){?>
                                <div class="large-12 small-12 medium-12 columns">
                                    <input type="checkbox"
                                           id="group<?php echo routecms\util\String::HTMLEncode($this->vars['group']->groupID) ?>"<?php if(isset($this->vars["errorInput"]) && $this->vars["errorInput"] == "groupIDs"){ ?> class="error"<?php } ?> <?php if($this->vars['__Routecms']->in_array($this->vars['group']->groupID,$this->vars['groupIDs'])) { ?> checked="checked"<?php } ?>
                                           name="groupIDs[<?php echo routecms\util\String::HTMLEncode($this->vars['group']->groupID) ?>]" value="1"/>
                                    <label for="group<?php echo routecms\util\String::HTMLEncode($this->vars['group']->groupID) ?>"><?php echo routecms\Routecms::lang($this->vars['group']->name) ?></label>
                                    <?php if(isset($this->vars["errorInput"]) && $this->vars["errorInput"] == "groupIDs"){ ?>
                                        <small class="error">
                                            <?php if($this->vars['errorType'] == "empty") { ?>
                                                <?php echo routecms\Routecms::lang("system.form.empty") ?>
                                            <?php } ?>
                                        </small>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend><?php echo routecms\Routecms::lang("user.password.change") ?></legend>
                    <div class="row">
                        <div class="large-12 small-12 medium-12 columns">
                            <label><?php echo routecms\Routecms::lang("user.password") ?>
                                <input type="password"<?php if(isset($this->vars["errorInput"]) && $this->vars["errorInput"] == "password"){ ?> class="error"<?php } ?> name="password" id="password" value="">
                            </label>
                            <?php if(isset($this->vars["errorInput"]) && $this->vars["errorInput"] == "password"){ ?>
                                <small class="error">
                                    <?php if($this->vars['errorType'] == "empty") { ?>
                                        <?php echo routecms\Routecms::lang("system.form.empty") ?>
                                    <?php }else{ ?><?php echo routecms\Routecms::lang("user.profil.error.password.".$this->vars['errorType']) ?>
                                    <?php } ?>
                                </small>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 small-12 medium-12 columns">
                            <label><?php echo routecms\Routecms::lang("user.password.again") ?>
                                <input type="password"<?php if(isset($this->vars["errorInput"]) && $this->vars["errorInput"] == "passwordAgain"){ ?> class="error"<?php } ?> name="passwordAgain" id="passwordAgain" value="">
                            </label>
                            <?php if(isset($this->vars["errorInput"]) && $this->vars["errorInput"] == "passwordAgain"){ ?>
                                <small class="error">
                                    <?php if($this->vars['errorType'] == "empty") { ?>
                                        <?php echo routecms\Routecms::lang("system.form.empty") ?>
                                    <?php }else{ ?><?php echo routecms\Routecms::lang("user.profil.error.password.".$this->vars['errorType']) ?>
                                    <?php } ?>
                                </small>
                            <?php } ?>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend><?php echo routecms\Routecms::lang("user.mail.change") ?></legend>
                    <div class="row">
                        <div class="large-12 small-12 medium-12 columns">
                            <label><?php echo routecms\Routecms::lang("user.mail") ?>
                                <input type="text"<?php if(isset($this->vars["errorInput"]) && $this->vars["errorInput"] == "mail"){ ?> class="error"<?php } ?> name="mail" id="mail" value="<?php echo routecms\util\String::HTMLEncode($this->vars['mail']) ?>">
                            </label>
                            <?php if(isset($this->vars["errorInput"]) && $this->vars["errorInput"] == "mail"){ ?>
                                <small class="error">
                                    <?php if($this->vars['errorType'] == "empty") { ?>
                                        <?php echo routecms\Routecms::lang("system.form.empty") ?>
                                    <?php }else{ ?><?php echo routecms\Routecms::lang("user.profil.error.mail.".$this->vars['errorType']) ?>
                                    <?php } ?>
                                </small>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 small-12 medium-12 columns">
                            <label><?php echo routecms\Routecms::lang("user.mail.again") ?>
                                <input type="text"<?php if(isset($this->vars["errorInput"]) && $this->vars["errorInput"] == "mailAgain"){ ?> class="error"<?php } ?> name="mailAgain" id="mailAgain" value="<?php echo routecms\util\String::HTMLEncode($this->vars['mailAgain']) ?>">
                            </label>
                            <?php if(isset($this->vars["errorInput"]) && $this->vars["errorInput"] == "mailAgain"){ ?>
                                <small class="error">
                                    <?php if($this->vars['errorType'] == "empty") { ?>
                                        <?php echo routecms\Routecms::lang("system.form.empty") ?>
                                    <?php }else{ ?><?php echo routecms\Routecms::lang("user.profil.error.mail.".$this->vars['errorType']) ?>
                                    <?php } ?>
                                </small>
                            <?php } ?>
                        </div>
                    </div>
                </fieldset>
            </div>
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