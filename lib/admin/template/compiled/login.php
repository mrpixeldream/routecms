<?php
/**
 * Hash : 5749025becd5fd7982156ff5db61c81be0e541ec
 */
?>
<?php include("header.php") ?>
<div class="row" style="max-width: 500px;">
    <div class="topBox small-12 medium-12 large-12 medium-centered large-centered columns">
        <form action="?page=Login" method="post">
            <div class="loginBox">
                <fieldset>
                    <div class="row">
                        <div class="small-12 medium-12 large-12 columns">
                            <div class="row">
                                <div class="small-4 medium-4 large-5 columns"></div>
                                <div class="small-8 medium-8 large-8 columns" id="logo">
                                    <a href="index.php?page=Login"><img src="images/logo.png" alt="logo"></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-12 medium-12 large-12 first-column columns">
                                    <?php echo lang("system.page.login.title") ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-12 medium-12 large-12 second-column columns">
                                    <div class="icon-in-input">
                                        <span class="fi-torso"> | </span>
                                        <input type="text"<?php if(isset($this->vars["errorInput"]) && $this->vars["errorInput"] == "username"){ ?> class="error"<?php } ?>
                                               value="<?php echo HTMLEncode($this->vars['username']) ?>"
                                               name="username" placeholder="<?php echo lang("system.username") ?>">
                                        <?php if(isset($this->vars["errorInput"]) && $this->vars["errorInput"] == "username"){ ?>
                                            <small class="error">
                                                <?php if($this->vars['errorType'] == "empty") { ?>
                                                    <?php echo lang("system.form.empty") ?>
                                                <?php }else{ ?><?php echo lang("user.login.error.".$this->vars['errorType']) ?>
                                                <?php } ?>
                                            </small>
                                        <?php } ?>
                                    </div>
                                    <div class="icon-in-input">
                                        <span class="fi-unlock"> | </span>
                                        <input type="password"<?php if(isset($this->vars["errorInput"]) && $this->vars["errorInput"] == "password"){ ?> class="error"<?php } ?> value=""
                                               name="password" placeholder="<?php echo lang("system.password") ?>">
                                        <?php if(isset($this->vars["errorInput"]) && $this->vars["errorInput"] == "password"){ ?>
                                            <small class="error">
                                                <?php if($this->vars['errorType'] == "empty") { ?>
                                                    <?php echo lang("system.form.empty") ?>
                                                <?php }else{ ?><?php echo lang("user.login.password.error.".$this->vars['errorType']) ?>
                                                <?php } ?>
                                            </small>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-12 medium-12 large-12 last-column columns">
                                    <button type="submit"
                                            class="fi-arrow-right"> <?php echo lang("system.page.login.submit") ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </form>
    </div>
</div>
<?php include("footer.php") ?>