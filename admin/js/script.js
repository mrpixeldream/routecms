function stickyFooter() {
    if (window.innerHeight != document.body.offsetHeight) {
        var offset = window.innerHeight - document.body.offsetHeight;
        var footer = $('footer');
        var current = footer.css('margin-top');

        if (isNaN(current) == true) {
            footer.css('margin-top', 0);
            current = 0;
        } else {
            current = parseInt(current);
        }

        if (current + offset > parseInt(footer.css('margin-top'))) {
            footer.css('margin-top', (current + offset) + "px");
        }
    }
}

function removeHeight(){
    $('div[role="navigation"]').css({'min-height': ""});
    $('div[role="mainContent"]').css({'min-height': ""});
}

function updateSidebar() {
    removeHeight();
    var $height = document.documentElement.clientHeight,
        $main = jQuery('div[role="main"]').height();
    if ($main > $height) {
        $('div[role="navigation"]').css({'min-height': $main});
        $('div[role="mainContent"]').css({'min-height': $main});
    } else {
        $('div[role="navigation"]').css({'min-height': $height});
        $('div[role="mainContent"]').css({'min-height': $height});
    }
}

function sidebarMenu() {
    var $menu = $('div.sidebar-menu[role="navigation"]');
    $('#adminMenu').click(function () {
        if ($menu.data("open") == "0") {
            $menu.removeClass("show-for-medium-up");
            $menu.addClass("sidebar-small");
            $menu.css('left', '-' + $(document).width() + 'px');
            $menu.animate({
                left: "+=" + $(document).width(),
                height: "toggle"
            }, "slow", function () {
            });
            $menu.css('display', '');
            $menu.data("open", "1");
        }
    });
    $('#adminMenuClose').click(function () {
        if ($menu.data("open") == "1") {
            $menu.addClass("show-for-medium-up");
            $menu.animate({
                left: "-=" + $(document).width(),
                height: "toggle"
            }, "slow", function () {
                $menu.removeClass("sidebar-small");
                $menu.css('left', '0');
            });
            $menu.data("open", "0");
        }
    });
}

function adminMenu() {
    $('.side-nav > li > a.dropdownIcon').each(function () {
        var icon = $(this);
        var item = $(this);
        item.click(function () {
            self = $(this);
            var parent = self.parent().find('ul');
            if (parent.css('display') == "none") {
                parent.css('display', 'inline');
                icon.removeClass("fi-arrow-down");
                icon.addClass("fi-arrow-up");
            } else {
                parent.css('display', 'none');
                icon.removeClass("fi-arrow-up");
                icon.addClass("fi-arrow-down");
            }
        });
    });
}

$(document).ready(function () {
    var switched = false;
    var updateTables = function () {
        if (($(window).width() < 767) && !switched) {
            switched = true;
            $("table.responsive").each(function (i, element) {
                splitTable($(element));
            });
            return true;
        }
        else if (switched && ($(window).width() > 767)) {
            switched = false;
            $("table.responsive").each(function (i, element) {
                unsplitTable($(element));
            });
        }
    };

    $(window).load(updateTables);
    $(window).bind("resize", updateTables);


    function splitTable(original) {
        original.wrap("<div class='table-wrapper' />");

        var copy = original.clone();
        copy.find("td:not(:first-child), th:not(:first-child)").css("display", "none");
        copy.removeClass("responsive");

        original.closest(".table-wrapper").append(copy);
        copy.wrap("<div class='pinned' />");
        original.wrap("<div class='scrollable' />");
    }

    function unsplitTable(original) {
        original.closest(".table-wrapper").find(".pinned").remove();
        original.unwrap();
        original.unwrap();
    }

});
$(document).ready(function () {
    $('.ajax[data-action="delete"]').each(function () {
        self = $(this);
        var close = self.find('.close');
        close.click(function () {
            self.foundation('reveal', 'close');
        });
        self.find('.request').click(function () {
            $(this).foundation('reveal', 'close');
            var ajax = $(this);
            $.ajax({
                url: ajax.data('link'),
                success: function (data) {
                    $('table.userTable').find('tr[data-row-id="' + ajax.data('delete-row-id') + '"]').remove();
                },
                error: function (event) {
                    if (event.responseJSON) {
                        var data = event.responseJSON;
                        if (data.title && data.description) {
                            $('#ajaxError > h1').html(data.title);
                            $('#ajaxError > span').html(data.description);
                        }
                    }
                    $('#ajaxError').foundation('reveal', 'open');
                }
            });
        });
    });
});


