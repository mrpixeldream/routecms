<?php
/**
 * Hash : a59372a9b9a7a0d05fd387a3b67f4d238efdc6d9
 */
?>
<?php if($this->vars['template'] != 'login' && $this->vars['template'] != 'errorLogin') { ?>
    <footer>
        <a href="http://www.routecms.de"><p><?php echo lang("system.copyright") ?></p></a>
    </footer>
    </div>
    </div>
    </div>
    </div>
<?php }else{ ?>
    </div>
    <footer>
        <div>
            <a href="http://www.routecms.de"><p><?php echo lang("system.copyright") ?></p></a>
        </div>
    </footer>
<?php } ?>
<script>
    $lang = { };
    $lang["system.menu.back"] = '<?php echo lang("system.menu.back") ?>';
</script>
<script src="js/vendor/jquery.js"></script>
<script src="js/foundation.min.js"></script>
<script src="js/script.js"></script>
<script>
    $(document).foundation();
    sidebarMenu();
    adminMenu();
    $(window).load(function () {
        updateSidebar();
        <?php if($this->vars['template'] == 'login' || $this->vars['template'] == 'errorLogin') { ?>
        stickyFooter();
        <?php } ?>
    });
    $(window).resize(function () {
        updateSidebar();
        <?php if($this->vars['template'] == 'login' || $this->vars['template'] == 'errorLogin') { ?>
        stickyFooter();
        <?php } ?>
    });
    $(document).foundation('tab', 'reflow');
    $(document).ready(function () {
        $('.tabs').each(function () {
            $(this).tabs({
                select: function(event, ui){
                    updateSidebar();
                    <?php if($this->vars['template'] == 'login' || $this->vars['template'] == 'errorLogin') { ?>
                    stickyFooter();
                    <?php } ?>
                }
            });

        });
    });
</script>
<div class="reveal-modal" data-reveal id="ajaxError">
    <h1><?php echo lang("error.unknown") ?></h1>
    <span class="error"><?php echo lang("error.unknown.description") ?></span>
    <a class="close-reveal-modal">&#215;</a>
</div>
</body>
</html>