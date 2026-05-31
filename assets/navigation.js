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

        function handleScroll() {
            var scrollPos = $(window).scrollTop();
            if (scrollPos > 50) {
                $wrapper.addClass('dedicateddesigner-scrolled');
            } else {
                $wrapper.removeClass('dedicateddesigner-scrolled');
            }
        }

        // Run immediately to check initial scroll position on page load
        handleScroll();

        // Bind scroll event with unique namespace to prevent listener duplication
        $(window).off(scrollEventName).on(scrollEventName, handleScroll);

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

        // Clean up events when the widget is reloaded/destroyed in the editor
        $scope.on('destroy', function () {
            $(window).off(scrollEventName);
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
