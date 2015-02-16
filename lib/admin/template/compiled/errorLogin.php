<?php
/**
 * Hash : f6332e3ed2a757c882a00a1fb488e20b691cf3fb
 */
?>
<?php include("header.php") ?>
<div class="row" style="max-width: 500px;">
    <div class="topBox small-12 medium-12 large-12 medium-centered large-centered columns">
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
                            <div class="small-12 medium-12 large-12  columns">
                                    <span class="error">
                                <h1><?php echo lang("exception.permission.denied") ?> </h1>  <?php echo lang("exception.permission.denied.description") ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>
<?php include("footer.php") ?>