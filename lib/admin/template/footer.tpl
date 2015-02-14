{if $template != 'login' && $template != 'errorLogin'}
<footer>
    <a href="http://www.routecms.de"><p>{lang "system.copyright"}</p></a>
</footer>
</div>
</div>
</div>
</div>
{else}
</div>
<footer>
    <div>
        <a href="http://www.routecms.de"><p>{lang "system.copyright"}</p></a>
    </div>
</footer>
{/if}
<script>
    $lang = { };
    $lang["system.menu.back"] = '{lang "system.menu.back"}';
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
        {if $template == 'login' || $template == 'errorLogin'}
        stickyFooter();
        {/if}
    }).resize(function () {
        updateSidebar();
        {if $template == 'login' || $template == 'errorLogin'}
        stickyFooter();
        {/if}
    });
    $(document).foundation('tab', 'reflow');
</script>
<div class="reveal-modal" data-reveal id="ajaxError">
    <h1>{lang "error.unknown"}</h1>
    <span class="error">{lang "error.unknown.description"}</span>
    <a class="close-reveal-modal">&#215;</a>
</div>
</body>
</html>