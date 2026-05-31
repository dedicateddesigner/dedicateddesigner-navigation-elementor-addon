<?php

if (!defined('ABSPATH')) {
    exit;
}

if ( class_exists( '\Elementor\Widget_Base' ) && ! class_exists( 'DedicatedDesigner_Navigation_Widget' ) ) {
class DedicatedDesigner_Navigation_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'dedicateddesigner-navigation';
    }

    public function get_title() {
        return __('Dedicated Designer Navigation', 'dedicateddesigner-navigation');
    }

    public function get_icon() {
        return 'eicon-nav-menu';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_style_depends() {
        return ['dedicateddesigner-navigation-css'];
    }

    public function get_script_depends() {
        return ['dedicateddesigner-navigation-js'];
    }

    private function get_available_menus() {
        $menus = wp_get_nav_menus();
        $options = [ '0' => esc_html__( 'Select Menu', 'dedicateddesigner-navigation' ) ];
        foreach ( $menus as $menu ) {
            $options[ $menu->slug ] = $menu->name;
        }
        return $options;
    }

    protected function register_controls() {

        // --- CONTENT SECTION ---
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Navigation Settings', 'dedicateddesigner-navigation'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Logo
        $this->add_control(
            'logo',
            [
                'label' => __('Logo Image', 'dedicateddesigner-navigation'),
                'type'  => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        // Logo Link
        $this->add_control(
            'logo_link',
            [
                'label' => __('Logo Link URL', 'dedicateddesigner-navigation'),
                'type'  => \Elementor\Controls_Manager::URL,
                'placeholder' => home_url('/'),
            ]
        );

        // Menu Selector
        $this->add_control(
            'menu',
            [
                'label' => __('Select WordPress Menu', 'dedicateddesigner-navigation'),
                'type'  => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_available_menus(),
                'default' => '0',
            ]
        );

        // Button Text
        $this->add_control(
            'button_text',
            [
                'label'   => __('Register Button Text', 'dedicateddesigner-navigation'),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => 'Register',
                'separator' => 'before',
            ]
        );

        // Button URL
        $this->add_control(
            'button_url',
            [
                'label' => __('Register Button URL', 'dedicateddesigner-navigation'),
                'type'  => \Elementor\Controls_Manager::URL,
            ]
        );

        $this->end_controls_section();

        // --- STYLE SECTION ---

        // 1. General Header Bar Style
        $this->start_controls_section(
            'section_header_style',
            [
                'label' => __('Header Bar', 'dedicateddesigner-navigation'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Sticky Header
        $this->add_control(
            'sticky_header',
            [
                'label' => __('Sticky Header', 'dedicateddesigner-navigation'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'dedicateddesigner-navigation'),
                'label_off' => __('No', 'dedicateddesigner-navigation'),
                'return_value' => 'yes',
                'default' => 'yes',
                'prefix_class' => 'dedicateddesigner-sticky-',
            ]
        );

        // Content Max Width
        $this->add_responsive_control(
            'content_max_width',
            [
                'label' => __('Content Max Width', 'dedicateddesigner-navigation'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw' ],
                'range' => [
                    'px' => [
                        'min' => 500,
                        'max' => 1600,
                    ],
                    '%' => [
                        'min' => 50,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 1140,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .dedicateddesigner-header-container' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Menu Alignment
        $this->add_control(
            'menu_alignment',
            [
                'label'   => __('Menu Alignment', 'dedicateddesigner-navigation'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'left'   => __('Left', 'dedicateddesigner-navigation'),
                    'center' => __('Center', 'dedicateddesigner-navigation'),
                    'right'  => __('Right', 'dedicateddesigner-navigation'),
                ],
                'prefix_class' => 'dedicateddesigner-menu-align-',
            ]
        );

        // Background Color (Normal)
        $this->add_control(
            'nav_bg_color',
            [
                'label' => __('Default Background Color', 'dedicateddesigner-navigation'),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'default' => 'transparent',
                'selectors' => [
                    '{{WRAPPER}} .dedicateddesigner-navigation-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Background Color (On Scroll)
        $this->add_control(
            'nav_scrolled_bg_color',
            [
                'label' => __('Scroll Background Color (Solid Blue)', 'dedicateddesigner-navigation'),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'default' => '#0b2c5c',
            ]
        );

        // Header Padding
        $this->add_responsive_control(
            'header_padding',
            [
                'label' => __('Header Padding', 'dedicateddesigner-navigation'),
                'type'  => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '20',
                    'bottom' => '20',
                    'left' => '0',
                    'right' => '0',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .dedicateddesigner-header-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Header Border Bottom
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'header_border',
                'selector' => '{{WRAPPER}} .dedicateddesigner-navigation-wrapper',
            ]
        );

        $this->end_controls_section();

        // 2. Logo Size Style
        $this->start_controls_section(
            'section_logo_style',
            [
                'label' => __('Logo Settings', 'dedicateddesigner-navigation'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Desktop Logo Height
        $this->add_responsive_control(
            'logo_max_height',
            [
                'label' => __('Logo Max Height (px)', 'dedicateddesigner-navigation'),
                'type'  => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 150,
                    ],
                ],
                'default' => [
                    'size' => 60,
                ],
                'selectors' => [
                    '{{WRAPPER}} .dedicateddesigner-logo-img' => 'max-height: {{SIZE}}px;',
                ],
            ]
        );

        $this->end_controls_section();

        // 3. Menu Links Style
        $this->start_controls_section(
            'section_menu_style',
            [
                'label' => __('Desktop Menu Navigation', 'dedicateddesigner-navigation'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Menu Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'menu_typography',
                'selector' => '{{WRAPPER}} .dedicateddesigner-desktop-menu-container ul.dedicateddesigner-desktop-menu li a',
            ]
        );

        // Menu Tabs: Normal & Hover
        $this->start_controls_tabs( 'tabs_menu_style' );

        $this->start_controls_tab(
            'tab_menu_normal',
            [
                'label' => __('Normal', 'dedicateddesigner-navigation'),
            ]
        );

        $this->add_control(
            'menu_link_color',
            [
                'label'     => __('Link Color', 'dedicateddesigner-navigation'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .dedicateddesigner-desktop-menu-container ul.dedicateddesigner-desktop-menu li a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_menu_hover',
            [
                'label' => __('Hover', 'dedicateddesigner-navigation'),
            ]
        );

        $this->add_control(
            'menu_link_hover_color',
            [
                'label'     => __('Link Hover Color', 'dedicateddesigner-navigation'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#0073e6',
                'selectors' => [
                    '{{WRAPPER}} .dedicateddesigner-desktop-menu-container ul.dedicateddesigner-desktop-menu li a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // 4. Register Button Style
        $this->start_controls_section(
            'section_button_style',
            [
                'label' => __('Register Button', 'dedicateddesigner-navigation'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Button Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'button_typography',
                'selector' => '{{WRAPPER}} .dedicateddesigner-register-btn',
            ]
        );

        // Tabs: Normal & Hover
        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_btn_normal',
            [
                'label' => __('Normal', 'dedicateddesigner-navigation'),
            ]
        );

        // Button Text Color
        $this->add_control(
            'btn_text_color',
            [
                'label'     => __('Text Color', 'dedicateddesigner-navigation'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .dedicateddesigner-register-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Button Background Color
        $this->add_control(
            'btn_bg_color',
            [
                'label'     => __('Background Color', 'dedicateddesigner-navigation'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#0073e6',
                'selectors' => [
                    '{{WRAPPER}} .dedicateddesigner-register-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_btn_hover',
            [
                'label' => __('Hover', 'dedicateddesigner-navigation'),
            ]
        );

        // Button Hover Text Color
        $this->add_control(
            'btn_hover_text_color',
            [
                'label'     => __('Text Hover Color', 'dedicateddesigner-navigation'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .dedicateddesigner-register-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Button Hover Background Color
        $this->add_control(
            'btn_hover_bg_color',
            [
                'label'     => __('Background Hover Color', 'dedicateddesigner-navigation'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#005bb5',
                'selectors' => [
                    '{{WRAPPER}} .dedicateddesigner-register-btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        // Button Padding
        $this->add_responsive_control(
            'btn_padding',
            [
                'label'      => __('Padding', 'dedicateddesigner-navigation'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'    => [
                    'top' => '12',
                    'bottom' => '12',
                    'left' => '24',
                    'right' => '24',
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .dedicateddesigner-register-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'btn_border_radius',
            [
                'label'      => __('Border Radius', 'dedicateddesigner-navigation'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top' => '6',
                    'bottom' => '6',
                    'left' => '6',
                    'right' => '6',
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .dedicateddesigner-register-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // 5. Mobile Toggle & Menu Style
        $this->start_controls_section(
            'section_mobile_style',
            [
                'label' => __('Mobile Menu & Hamburger', 'dedicateddesigner-navigation'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Hamburger Toggle Color
        $this->add_control(
            'toggle_color',
            [
                'label'     => __('Hamburger Bar Color', 'dedicateddesigner-navigation'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .dedicateddesigner-hamburger-bar' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Hamburger Toggle Hover Color
        $this->add_control(
            'toggle_hover_color',
            [
                'label'     => __('Hamburger Bar Hover Color', 'dedicateddesigner-navigation'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#0073e6',
                'selectors' => [
                    '{{WRAPPER}} .dedicateddesigner-mobile-toggle:hover .dedicateddesigner-hamburger-bar' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Mobile Menu Background Color
        $this->add_control(
            'mobile_menu_bg',
            [
                'label'     => __('Slide-out Menu Background', 'dedicateddesigner-navigation'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#0b2c5c',
                'selectors' => [
                    '{{WRAPPER}} .dedicateddesigner-mobile-drawer' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Mobile Menu Link Color
        $this->add_control(
            'mobile_menu_link_color',
            [
                'label'     => __('Mobile Link Color', 'dedicateddesigner-navigation'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .dedicateddesigner-mobile-menu-container ul.dedicateddesigner-mobile-menu li a' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Mobile Menu Link Hover Color
        $this->add_control(
            'mobile_menu_link_hover_color',
            [
                'label'     => __('Mobile Link Hover Color', 'dedicateddesigner-navigation'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#0073e6',
                'selectors' => [
                    '{{WRAPPER}} .dedicateddesigner-mobile-menu-container ul.dedicateddesigner-mobile-menu li a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        // 1. Logo HTML
        $logo_html = '';
        if ( ! empty( $settings['logo']['url'] ) ) {
            $logo_url = esc_url($settings['logo']['url']);
            $logo_link = ! empty( $settings['logo_link']['url'] ) ? esc_url($settings['logo_link']['url']) : home_url('/');
            $logo_html = '<a href="' . $logo_link . '" class="dedicateddesigner-logo-link"><img src="' . $logo_url . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" class="dedicateddesigner-logo-img"></a>';
        } else {
            $logo_link = home_url('/');
            $logo_html = '<a href="' . $logo_link . '" class="dedicateddesigner-logo-text">' . esc_html( get_bloginfo( 'name' ) ) . '</a>';
        }

        // 2. Menu HTML
        $desktop_menu = '';
        $mobile_menu = '';
        if ( ! empty( $settings['menu'] ) && '0' !== $settings['menu'] ) {
            $desktop_menu = wp_nav_menu([
                'menu'            => $settings['menu'],
                'container'       => 'nav',
                'container_class' => 'dedicateddesigner-desktop-menu-container',
                'menu_class'      => 'dedicateddesigner-desktop-menu',
                'fallback_cb'     => false,
                'echo'            => false,
            ]);

            $mobile_menu = wp_nav_menu([
                'menu'            => $settings['menu'],
                'container'       => 'nav',
                'container_class' => 'dedicateddesigner-mobile-menu-container',
                'menu_class'      => 'dedicateddesigner-mobile-menu',
                'fallback_cb'     => false,
                'echo'            => false,
            ]);
        } else {
            $desktop_menu = '<div class="dedicateddesigner-menu-placeholder">' . esc_html__( 'Please select a menu in settings', 'dedicateddesigner-navigation' ) . '</div>';
            $mobile_menu = '<div class="dedicateddesigner-menu-placeholder">' . esc_html__( 'Please select a menu', 'dedicateddesigner-navigation' ) . '</div>';
        }

        // 3. Register Button HTML
        $btn_html = '';
        if ( ! empty( $settings['button_text'] ) ) {
            $btn_url = ! empty( $settings['button_url']['url'] ) ? esc_url( $settings['button_url']['url'] ) : '#';
            $target = ! empty( $settings['button_url']['is_external'] ) ? ' target="_blank"' : '';
            $nofollow = ! empty( $settings['button_url']['nofollow'] ) ? ' rel="nofollow"' : '';
            
            $btn_html = '<a href="' . $btn_url . '" class="dedicateddesigner-register-btn"' . $target . $nofollow . '>' . esc_html( $settings['button_text'] ) . '</a>';
        }

        // 4. Wrapper settings and custom CSS variables
        $this->add_render_attribute( 'wrapper', [
            'class' => 'dedicateddesigner-navigation-wrapper',
        ] );

        $scrolled_bg = !empty($settings['nav_scrolled_bg_color']) ? $settings['nav_scrolled_bg_color'] : '#0b2c5c';
        $normal_bg = !empty($settings['nav_bg_color']) ? $settings['nav_bg_color'] : 'transparent';
        
        $inline_style = 'style="--dedicateddesigner-scrolled-bg: ' . esc_attr($scrolled_bg) . '; --dedicateddesigner-normal-bg: ' . esc_attr($normal_bg) . ';"';
        ?>
        <header <?php $this->print_render_attribute_string( 'wrapper' ); ?> <?php echo $inline_style; ?>>
            <div class="dedicateddesigner-header-container">
                <!-- Logo -->
                <div class="dedicateddesigner-logo-col">
                    <?php echo $logo_html; ?>
                </div>

                <!-- Desktop Navigation Menu -->
                <div class="dedicateddesigner-menu-col">
                    <?php echo $desktop_menu; ?>
                </div>

                <!-- Desktop Action Button -->
                <div class="dedicateddesigner-btn-col">
                    <?php echo $btn_html; ?>
                </div>

                <!-- Mobile Hamburger Toggle -->
                <button type="button" class="dedicateddesigner-mobile-toggle" aria-label="Toggle Navigation">
                    <span class="dedicateddesigner-hamburger-bar"></span>
                    <span class="dedicateddesigner-hamburger-bar"></span>
                    <span class="dedicateddesigner-hamburger-bar"></span>
                </button>
            </div>

            <!-- Slide-out Drawer Mobile Menu -->
            <div class="dedicateddesigner-mobile-drawer">
                <div class="dedicateddesigner-drawer-header">
                    <div class="dedicateddesigner-drawer-logo">
                        <?php echo $logo_html; ?>
                    </div>
                    <button type="button" class="dedicateddesigner-drawer-close" aria-label="Close Menu">
                        <span class="dedicateddesigner-close-bar"></span>
                        <span class="dedicateddesigner-close-bar"></span>
                    </button>
                </div>
                <div class="dedicateddesigner-drawer-content">
                    <?php echo $mobile_menu; ?>
                    <?php if ( !empty($btn_html) ) : ?>
                        <div class="dedicateddesigner-drawer-btn-wrap">
                            <?php echo $btn_html; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Overlay Backdrop -->
            <div class="dedicateddesigner-drawer-overlay"></div>
        </header>
        <?php
    }
}
}