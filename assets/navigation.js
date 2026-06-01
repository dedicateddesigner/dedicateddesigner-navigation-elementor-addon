(function ($) {
    var DedicatedDesignerNavigationHandler = function ($scope) {
        var $wrapper = $scope.find('.dedicateddesigner-navigation-wrapper');
        if (!$wrapper.length) {
            return;
        }

        var widgetId = $scope.data('id') || Math.random().toString(36).substr(2, 9);
        var scrollEventName = 'scroll.dedicateddesigner_nav_' + widgetId;

        var $toggleBtn = $wrapper.find('.dedicateddesigner-mobile-toggle');
        var $closeBtn = $wrapper.find('.dedicateddesigner-drawer-close');
        var $overlay = $wrapper.find('.dedicateddesigner-drawer-overlay');

        var resizeEventName = 'resize.dedicateddesigner_nav_' + widgetId;

        function updateNavHeight() {
            var navHeight = $wrapper.outerHeight();
            document.documentElement.style.setProperty('--dedicateddesigner-nav-height', navHeight + 'px');
        }

        function handleScroll() {
            var scrollPos = $(window).scrollTop();
            if (scrollPos > 50) {
                $wrapper.addClass('dedicateddesigner-scrolled');
            } else {
                $wrapper.removeClass('dedicateddesigner-scrolled');
            }
            updateNavHeight();
        }

        // Run immediately to check initial scroll position and height on page load
        handleScroll();

        // Bind scroll and resize events with unique namespaces
        $(window).off(scrollEventName).on(scrollEventName, handleScroll);
        $(window).off(resizeEventName).on(resizeEventName, updateNavHeight);

        // Open Mobile Drawer
        $toggleBtn.off('click').on('click', function (e) {
            e.preventDefault();
            $wrapper.addClass('dedicateddesigner-drawer-open');
            $('body').addClass('dedicateddesigner-body-menu-open');
        });

        // Close Mobile Drawer
        function closeDrawer(e) {
            if (e) e.preventDefault();
            $wrapper.removeClass('dedicateddesigner-drawer-open');
            $('body').removeClass('dedicateddesigner-body-menu-open');
        }

        $closeBtn.off('click').on('click', closeDrawer);
        $overlay.off('click').on('click', closeDrawer);

        // Toggle mobile sub-menus on parent link click
        $wrapper.find('.dedicateddesigner-mobile-menu li.menu-item-has-children > a').off('click').on('click', function (e) {
            e.preventDefault();
            var $parentLi = $(this).parent('li');
            $parentLi.toggleClass('active-submenu');
            $parentLi.find('> ul.sub-menu').slideToggle(300);
        });

        // Close mobile drawer when any link is clicked, unless it is a submenu parent item toggle
        $wrapper.find('.dedicateddesigner-mobile-drawer a').off('click').on('click', function (e) {
            if ($(this).parent().hasClass('menu-item-has-children')) {
                return;
            }
            closeDrawer();
        });

        // Clean up events when the widget is reloaded/destroyed in the editor
        $scope.on('destroy', function () {
            $(window).off(scrollEventName);
            $(window).off(resizeEventName);
            $('body').removeClass('dedicateddesigner-body-menu-open');
        });
    };

    var initializeWidget = function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/dedicateddesigner-navigation.default', DedicatedDesignerNavigationHandler);
    };

    if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
        initializeWidget();
    } else {
        $(window).on('elementor/frontend/init', initializeWidget);
    }
})(jQuery);
