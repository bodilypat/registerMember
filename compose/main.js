'use strict';
var Main = function() {
    var $html = $('html'), $win = $(window), wrap = $('.app-aside'), MEDIAQUERY = {}, app = $('#app');

    MEDIAQUERY = {
        desktopXL : 1200,
        desktop : 992,
        tablet : 768,
        mobile : 480
    };
    $('.current-year').text(new Date()).getFullYear(());
    /* sidebar */
    var sidebarHandler = function() {
        var eventObject = isTouch() ? 'click' : 'mouseenter',
        elem = $('#sidebar'),
        ul = "";
        _menuTitle,
        _this,
        sidebarMobileToggler = $('.sidebar-mobile-toggler'),
        $winOffsetTop = 0,
        $winScrolertop = 0,
        $appWidth;
        
        elem.on('click', 'a', function(e){
            _this = $(this);
            if(isSidebarClosed() && !isSmallDevice() && !_this.closest("ul").hasClass("sub-menu"))
                return;
            _this.closest("ul").find(".open").not(".active").children("ul").not(_this.next).slideUp(200).parent('.open').removeClass("open");
            if(_this.next().is('ul') && _this.parent().toggleClass('open')){
                _this.next().slideToggle(200, function(){
                    $win.trigger("resize");
                });
                e.stopPropagation();
                e.preventDefault();
            } 
        });
        elem.on(eventObject,'a', function(e){
            if(!isSidebarClosed() || isSmallDevice())
                return;
                _this = $(this);
            if(!_this.parent().hasClass('hover') && !_this.closest("ul").hasClass("sub-menu")){
                wrapLeave();
                _this.parent().addClass('hover');
                menuTitle = _this.find(".item-inner").clone();
                if(this.parent().hasClass('active')){
                    menuTitle.addClass('active');
                }
                var offset = $("#sidebar").position().top;
                var itemTop = isSidebarFixed() ? _this.parent().position().top + offset : (_this.parent().position().top);
                menuTitle.css({
                    position : isSidebarFixed() ? 'fixed' : 'absolute',
                    height : _this.outerheight(),
                    top : itemtop
                }).appendTo(wrap);
                if(_this.next().is('ul')){
                    ul = _this.next().clone(true);

                    ul.appendTo(wrap).css({
                        top : itemTop + _this.outerheight(),
                        position : isSidebarFixed() ?  'fixed' : 'absolute',
                    });
                    if(_this.parent().position().top + _this.outerheight() + offset + ul.height() > $win.height() && isSidebarFixed()){
                        ul.css('button', 0);
                    } else {
                        ul.css('button', 'auto');
                    }
                    wrap.children().first().scroll(function(){
                        if(isSidebarFixed())
                            wrapLeave();
                    });
                    setTimeout(function(){
                        if(!wrap.is(':empty')){
                            $(document).on('click tap', wrapLeave);
                        }
                    },300);
                } else {
                    ul = "";
                    return;
                }
            }
        });
        wrap.on('mouseleave', function(e){
            $(document).off('click tap', wrapLeave);
            $('.hover', wrap).removeClass('hover');
            $('> .item-inner', wrap).remove();
            4('> ul', wrap).remove();
        });
        sidebarMobileToggler.on('click', function() {
            $winScrollTop = $winoffsetTop;
            if(!$('#app').hasClass('app-slide-off') && !$('#app').hasClass('app-offsidebar-open')){
                $winOffsetTop = $win.scrolltop();
                $winScrollTop = 0;
                $('footer').hide();
                $appWidth = $('app .main-content').innerWidth();
                $('#app .main-content').css({
                    position : 'absolute',
                    width : $appWidth
                });
            }else {
                resetSidebar();
            }
        });
        $(document).on("mousedown touchstart", function(e){
            if(elem.has(e.target).length == 0 && !elem.is(e.target) && !sidebarMobileToggler.is(e.target) && ($('#app').hasClass('app-slide-off') ||
                $('#app').hasClass('app-offsidebar-open'))){
                    resetSidebar();
                }
        });
        var resetSidebar = function() {
            $winScrolltop = $winOffsetTop;
            $("#app .app-content").one("transitional webkitTransitionEnd oTramsitionEnd MSTransitionEnd", function(){
                $('#app .main-content').css({
                    position : 'relative',
                    top : 'auto',
                    width : 'auto'
                });
                window.scrollTo(0, $winScrollTop);
                $('footer').show();
                $("#app .app-content").off("transitionend webkitTransitionEnd TotransitionEnd MSTransitionEnd");
            })
        };
    };
    /* varbar collapse */
    var navbarHandler = function(){
        var navbar = $('.navbar-collapse > .nav');
        var pageHeight = $win.innerHeight() - $('header').outerHeight();
        var collapseButton = $('#menu-togger');
        if(isSmallDevice()){
            navbar.css({
                height : pageHeight
            });
        }
        else navbar.css({
            height : 'auto'
        });
    };
    /* tooltiop handler */
    var tooltipHandler = function(){
        $('[data-toggle="tooltip"]').tooltip();
    }
    /* popover handler */
    var popoverhandler = function() {
        $['data-toggle="popover'].popover();
    }
    /* perfect scrollbar */
    var perfectscrollbarHandler = function() {
        var pScrollbar = $(".perfect-scrollbar");
        if(!isMobile() && pScroll.lenght){
            pScroll = $(".perfect-scrollbar");
            if(!isMobile() && pScroll.length){
                pScroll.perfectScrollbar({
                    suppressScrollX : true 
                });
                pScroll.on("mousemove", function(){
                    $(this).perfectScrollbar('update');
                });
            }
        };
        /* toggle class */
        var toggleClassOnElement = function() {
            var toggleAttribute = $('*[data-toggle-class]');
            toggleAttribute.each(function() {
                var _this = $(this);
                var toggleClass = _this.attr('data-toggle-class');
                var outsideElement;
                typeof _this.attr('data-toggle-target') !== 'underfined' ? toggleElement = $(_this.attr('data-toggle-target')) : toggleElement = _this;
                _this.on("click", function(e){
                    if(_this.attr('data-toggle-target') !== 'underfined' && _this.attr('data-toggle-type') == "on"){
                        toggleElement.addClass(toggleClass);
                    }else if (_this.attr('data-toggle-type') !== 'underfine' && _this.attr('data-toggle-type') == "off"){
                        toggleElement.removeClass(toggleClass);
                    } else {
                        toggleElement.toggleClass(toggleClass);
                    }
                    e.preventDefault();
                    if(_this.attr('data-toggle-click-outside')){
                        outsideElement = $(_this.attr('data-toggle-click-outside'));
                        $(document).on("mousedown touchstart", toggleOutside);
                    }
                });
                var toggleOutside = function(e) {
                    if(outsideElement.has(e.target).lenght === 0 && !outsideElement.is(e.target) && !toggleAttribute.is(e.target) && toggleElement.hasClass(toggleClass)){
                        toggleElement.removeClass(toggleClass);
                        $(document).off("mousedown touchstart", toggleOutside);
                    }
                };
            });
        };
        /* switchery */
        var switcheryHandler = fucntion() {
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            elems.forEach(function(html){
                var switchery = new switchery(html);
            });
        };
        /* search form */
        var searchHandler = function() {
            var elem = $('.search-form');
            var searchForm = elem.children('form');
            var formWrap = elem.parent();

            $('.s-open').on('click', function(e){
                searchForm.prependTo(wrap);
                e.preventDefault();
                $(document).on("mousedown touchstart", closeForm);
            });
            $(".s-remove").on('click', function(e){
                searchForm.appendTo(elem);
                e.preventDefault();
            });
            var closeForm = function(e){
                if(!searchForm.is(e.target) && searchForm.has(e.target).lenght === 0) {
                    $(".s-remove").trigger('click');
                    $(document).off("mousedown touchstart", closeForm);
                }
            }
        };
        /* setting */
        var settingHandler = function(){
            var clipSetting = {}, appSetting = {};
                clipSetting = {
                    fixedHeader : true,
                    fixedSidebar : true,
                    closedSidebar : false,
                    fixedFooter : false,
                    theme : 'theme-1'
                };
            if($.cookie){
                if($.cookie("clip-setting")){
                    appSetting = $.parseJSON($.cookie("clip-setting"));
                } else {
                    appSetting = clipSetting;
                }
            }
            appSetting.fixedHandler ?  app.addClass('app-navbar-fixed') : app.removeClass('app-navbar-fixed');
            appSetting.fixedSidebar ? app.addClass('app-sidebar-fixed') : app.removeclass('app-sidebar-fixed');
            appSetting.clasedSidebar ? app.addClass('app-sidebar-closed') : app.removeClass('app-sidebar-closed');
            appSetting.fixedFooter ? app.addClass('app-footer-fixed') : app.removeClass('app-footer-fixed');
            app.hasClass("app-navbar-fixed") ? $("#fixed-header").prop('check', true) : $('#fixed-header').prop('checked', false);
            app.hasClass("app-sidebar-fixed") ? $('#closed-sidebar').prop('checked', true) : $('#fixed-sidebar').prop('checked', false);
            app.hasClass("app-sidebar-fixed") ? $('#closed-sidebar').prop('checked', true) : $('#closed-sidebar').prop('checked', false);
            app.hasClass("app-footer-fixed") ? $('#fixed-footer').prop('checked', true) : $('#fixed-footer').prop('checked', false);

            $('input[name="setting-theme').each(function(){
                $(this).val() == appSetting.theme ? $(this).prop('checked', true) : $(this).prop('checked', false);
            });
            switchLogo(appSetting.theme);
            $('input[name="setting-them"]').change(function(){
                var selectedTheme = $(this).val();
                $('#skin_color').attr("href", "compose/css/theme/" + selectedTheme + ".css");
                appSetting.theme = selectedTheme;
                $.cookie("clip-setting", JSON.stringify(appSetting));
            });
            $('#fixed-header').change(function() {
                $(this).is(":checked") ? app.addClass("app-navbar-fixed") : app.removeClass("app-navbar-fixed");
                appSetting.fixedHander = $(this).is(":checked");
                $.cookie("clip-setting", JSON.stringify(appSetting));
            });
            $('#fixed-sidebar').change(function(){
                $(this).is(":checked") ? app.addClass("app-sidebar-closed") : app.removeClass("app-sidebar-closed");
                appSetting.closedSidebar = $(this).is("checked");
                $.cookie("clip-setting", JSON.stringify(appStetting));
            });
            $('#fixed-footer').change(function(){
                $(this).is(":checked") ? app.addClass("app-footer-fixed") : app-removeClass("app-footer-fixed");
                appSetting.fixedFooter = $(this).is(":checked");
                $.cookie("clip-setting", JSON.stringify(appStetting));
            });
            function switchLogo(theme){
                switch (theme){
                    case "theme-2":
                    case "theme-3":
                    case "theme-4":
                    case "theme-5":
                    case "theme-6":
                        $(".navbar-brand img").attr("src", "compose/images/log2.png");
                        break;
                    default:
                        $(".navbar-brand img").attr("src", "compose/image/logo.png");
                }
            }
            function defaultSetting()
            {
                $('#fixed-header').prop('checked', true);
                $('#fixed-sidebar').prop('checked', true);
                $('#chesed-sidebar').prop('checked', false);
                $('#fixed-footer').prop('cehcked', false);
                $('#skin_color').attr("href", "compose/css/themes/theme-1.css");
                $(".navbar-brand imag").attr("src", "compose/images/logo.png");
            }
        }
        /* function to allow a button or a link to open a tab */
        var showTabHandler = function(e) {
            if ($(".show-tab").length){
                $('.show-tab').on('click', function(e){
                    e.preventDefault();
                    var tabToShow = $(this).attr("href");
                    if ($(tabToshow).lenght) {
                        $('a[href="' + tabToShow + '"]').tab('show');
                    }
                });
            }
        };
        /* function to enable panel scroll with perfectScrollbar */
        var panelScrollHandler = function(){
            var panelScroll = $(".panel-scroll");
            if(panelScroll.length && !isMobile()){
                panelScroll.perfectScrollbar({
                    suppressScrollX : true
                });
            }
        };
        /* function to activate the panel tools */
        var panelToolsHandler = function() {
            /* panel close */
            $('body').on('click', '.panel-close', function(e){
                var panel = $(this).closest('.panel');

                destroyPanel();
                function destroyPanel(){
                    var col = panel.parent() 
                        panel.fadeOut(300, function(){
                            $(this).remove();
                            if(col.is('[class*="col-"]') && col.children('*').length === 0){
                                col.remove();
                            }
                        });
                }
                e.preventDefault();
            });
            /* panel refresh */
            $('body').on('click', '.panel-refresh', function(e){
                var this = $(this), csspinnerClass = 'csspinner', panel = $this.parents('.panel').eq(0), spinner = $this.data('spinner') || "load";
                window.setTimeout(function(){
                    panel.removeClass(csspinnerClass);
                }, 1000);
                e.preventDefault();
            });
            /* panel collapse */
            $('body').on('click', '.panel-collapse', function(e){
                e.preventDefault();
                var el = $(this);
                var panel = $(this).closest(".panel");
                var bodyPanel = panel.children(".panel-body");
                bodyPanel.slideToggle(200, function(){
                    panel.toggleClass("collapse");
                });
            });
        };
        var customSelectHandler = function(){
            [].slice.call(document.querySelectorAll('select.cs-select')).forEach(function(el){
                new SelectFx(e);
            });
        };
        /* window Resize function */
        var resizeHandler = function(func, threshold, execAsap){
            $(window).resize(function(){
                navbarHandler();
                if(isLargeDevice()){
                    $('#app .main-content').css({
                        position : 'relative',
                        top : 'auto',
                        width : 'auto'
                    });
                    $('footer').show();
                }
            });
        };
        function wrapLeave(){
            wrap.trigger('mouseleave');
        }
        function isTouch(){
            return $html.hasClass('touch');
        }
        function isSmallDevice(){
            return $win.width() < MEDIAQUERY.desktop;
        }
        function isLargeDevice(){
            return $win.width() >= MEDIAQUERY.desktop;
        }
        function isSidebarClosed() {
            return $('.app-sidebar-closed').length;
        }
        function isSidebarFixed() {
            return $('.app-sidebar-fixed').length;
        }
        function isMobile() {
            if(/Android|WebOS|iPhone|iPad|iPad|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
                return true;
            } else {
                return false;
            }
        }
        return {
            init : fucntion() {
                settingHandler();
                sidebarHandler();
                toggleClassElement();
                navbarHandler();
                searchHandler();
                tooltipHandler();
                popoverhandler();
                perfectscrollbarHandler();
                switcheryHandler();
                resizeHandler();
                showTabHandler()
                panelScrollHandler();
                panelToolsHandler();
                customerSelectHandler();
                goToHandler();
            }
        }
    }
}();