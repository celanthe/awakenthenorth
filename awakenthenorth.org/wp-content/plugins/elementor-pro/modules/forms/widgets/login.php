<?php
namespace ElementorPro\Modules\Forms\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use ElementorPro\Base\Base_Widget;
use ElementorPro\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Login extends Base_Widget {

	public function get_name() {
		return 'login';
	}

	public function get_title() {
		return esc_html__( 'Login', 'elementor-pro' );
	}

	public function get_icon() {
		return 'eicon-lock-user';
	}

	public function get_keywords() {
		return [ 'login', 'user', 'form' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_fields_content',
			[
				'label' => esc_html__( 'Form Fields', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'show_labels',
			[
				'label' => esc_html__( 'Label', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_off' => esc_html__( 'Hide', 'elementor-pro' ),
				'label_on' => esc_html__( 'Show', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'input_size',
			[
				'label' => esc_html__( 'Input Size', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'xs' => esc_html__( 'Extra Small', 'elementor-pro' ),
					'sm' => esc_html__( 'Small', 'elementor-pro' ),
					'md' => esc_html__( 'Medium', 'elementor-pro' ),
					'lg' => esc_html__( 'Large', 'elementor-pro' ),
					'xl' => esc_html__( 'Extra Large', 'elementor-pro' ),
				],
				'default' => 'sm',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_content',
			[
				'label' => esc_html__( 'Button', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => esc_html__( 'Text', 'elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Log In', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'button_size',
			[
				'label' => esc_html__( 'Size', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'xs' => esc_html__( 'Extra Small', 'elementor-pro' ),
					'sm' => esc_html__( 'Small', 'elementor-pro' ),
					'md' => esc_html__( 'Medium', 'elementor-pro' ),
					'lg' => esc_html__( 'Large', 'elementor-pro' ),
					'xl' => esc_html__( 'Extra Large', 'elementor-pro' ),
				],
				'default' => 'sm',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', 'elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__( 'Left', 'elementor-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'elementor-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'end' => [
						'title' => esc_html__( 'Right', 'elementor-pro' ),
						'icon' => 'eicon-text-align-right',
					],
					'stretch' => [
						'title' => esc_html__( 'Justified', 'elementor-pro' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-button-align-',
				'default' => '',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_login_content',
			[
				'label' => esc_html__( 'Additional Options', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'redirect_after_login',
			[
				'label' => esc_html__( 'Redirect After Login', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_off' => esc_html__( 'Off', 'elementor-pro' ),
				'label_on' => esc_html__( 'On', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'redirect_url',
			[
				'type' => Controls_Manager::URL,
				'show_label' => false,
				'options' => false,
				'separator' => false,
				'placeholder' => esc_html__( 'https://your-link.com', 'elementor-pro' ),
				'description' => esc_html__( 'Note: Because of security reasons, you can ONLY use your current domain here.', 'elementor-pro' ),
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'redirect_after_login' => 'yes',
				],
			]
		);

		$this->add_control(
			'redirect_after_logout',
			[
				'label' => esc_html__( 'Redirect After Logout', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_off' => esc_html__( 'Off', 'elementor-pro' ),
				'label_on' => esc_html__( 'On', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'redirect_logout_url',
			[
				'type' => Controls_Manager::URL,
				'show_label' => false,
				'options' => false,
				'separator' => false,
				'placeholder' => esc_html__( 'https://your-link.com', 'elementor-pro' ),
				'description' => esc_html__( 'Note: Because of security reasons, you can ONLY use your current domain here.', 'elementor-pro' ),
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'redirect_after_logout' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_lost_password',
			[
				'label' => esc_html__( 'Lost your password?', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_off' => esc_html__( 'Hide', 'elementor-pro' ),
				'label_on' => esc_html__( 'Show', 'elementor-pro' ),
			]
		);

		if ( get_option( 'users_can_register' ) ) {
			$this->add_control(
				'show_register',
				[
					'label' => esc_html__( 'Register', 'elementor-pro' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'label_off' => esc_html__( 'Hide', 'elementor-pro' ),
					'label_on' => esc_html__( 'Show', 'elementor-pro' ),
				]
			);
		}

		$this->add_control(
			'show_remember_me',
			[
				'label' => esc_html__( 'Remember Me', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_off' => esc_html__( 'Hide', 'elementor-pro' ),
				'label_on' => esc_html__( 'Show', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'show_logged_in_message',
			[
				'label' => esc_html__( 'Logged in Message', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_off' => esc_html__( 'Hide', 'elementor-pro' ),
				'label_on' => esc_html__( 'Show', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'custom_labels',
			[
				'label' => esc_html__( 'Custom Label', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'user_label',
			[
				'label' => esc_html__( 'Username Label', 'elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Username or Email Address', 'elementor-pro' ),
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'show_labels',
							'operator' => '===',
							'value' => 'yes',
						],
						[
							'name' => 'custom_labels',
							'operator' => '===',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'user_placeholder',
			[
				'label' => esc_html__( 'Username Placeholder', 'elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Username or Email Address', 'elementor-pro' ),
				'condition' => [
					'custom_labels' => 'yes',
				],
			]
		);

		$this->add_control(
			'password_label',
			[
				'label' => esc_html__( 'Password Label', 'elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Password', 'elementor-pro' ),
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'show_labels',
							'operator' => '===',
							'value' => 'yes',
						],
						[
							'name' => 'custom_labels',
							'operator' => '===',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'password_placeholder',
			[
				'label' => esc_html__( 'Password Placeholder', 'elementor-pro' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Password', 'elementor-pro' ),
				'condition' => [
					'custom_labels' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Form', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'row_gap',
			[
				'label' => esc_html__( 'Rows Gap', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '10',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-field-group' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-form-fields-wrapper' => 'margin-bottom: -{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'links_color',
			[
				'label' => esc_html__( 'Links Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-field-group > a' => 'color: {{VALUE}};',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
			]
		);

		$this->add_control(
			'links_hover_color',
			[
				'label' => esc_html__( 'Links Hover Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-field-group > a:hover' => 'color: {{VALUE}};',
				],
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_labels',
			[
				'label' => esc_html__( 'Label', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_labels!' => '',
				],
			]
		);

		$this->add_control(
			'label_spacing',
			[
				'label' => esc_html__( 'Spacing', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '0',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'selectors' => [
					'body {{WRAPPER}} .elementor-field-group > label' => 'padding-bottom: {{SIZE}}{{UNIT}};',
					// for the label position = above option
				],
			]
		);

		$this->add_control(
			'label_color',
			[
				'label' => esc_html__( 'Text Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-form-fields-wrapper label' => 'color: {{VALUE}};',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'selector' => '{{WRAPPER}} .elementor-form-fields-wrapper label',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_field_style',
			[
				'label' => esc_html__( 'Fields', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'field_text_color',
			[
				'label' => esc_html__( 'Text Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-field-group .elementor-field' => 'color: {{VALUE}};',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'field_typography',
				'selector' => '{{WRAPPER}} .elementor-field-group .elementor-field, {{WRAPPER}} .elementor-field-subgroup label',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_control(
			'field_background_color',
			[
				'label' => esc_html__( 'Background Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .elementor-field-group .elementor-field:not(.elementor-select-wrapper)' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .elementor-field-group .elementor-select-wrapper select' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'field_border_color',
			[
				'label' => esc_html__( 'Border Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-field-group .elementor-field:not(.elementor-select-wrapper)' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .elementor-field-group .elementor-select-wrapper select' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .elementor-field-group .elementor-select-wrapper::before' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'field_border_width',
			[
				'label' => esc_html__( 'Border Width', 'elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'placeholder' => '1',
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-field-group .elementor-field:not(.elementor-select-wrapper)' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .elementor-field-group .elementor-select-wrapper select' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'field_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-field-group .elementor-field:not(.elementor-select-wrapper)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .elementor-field-group .elementor-select-wrapper select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Button', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'button_background',
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .elementor-button',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
					'color' => [
						'global' => [
							'default' => Global_Colors::COLOR_ACCENT,
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name' => 'button_border',
				'selector' => '{{WRAPPER}} .elementor-button',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_text_padding',
			[
				'label' => esc_html__( 'Text Padding', 'elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'button_background_hover',
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .elementor-button:hover',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_border_border!' => '',
				],
			]
		);

		$this->add_control(
			'button_hover_animation',
			[
				'label' => esc_html__( 'Animation', 'elementor-pro' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_message',
			[
				'label' => esc_html__( 'Logged in Message', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'message_color',
			[
				'label' => esc_html__( 'Text Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container .elementor-login__logged-in-message' => 'color: {{VALUE}};',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'message_typography',
				'selector' => '{{WRAPPER}} .elementor-widget-container .elementor-login__logged-in-message',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();

	}

	private function form_fields_render_attributes() {
		$settings = $this->get_settings();

		if ( ! empty( $settings['button_size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['button_size'] );
		}

		if ( $settings['button_hover_animation'] ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['button_hover_animation'] );
		}

		$this->add_render_attribute(
			[
				'wrapper' => [
					'class' => [
						'elementor-form-fields-wrapper',
					],
				],
				'field-group' => [
					'class' => [
						'elementor-field-type-text',
						'elementor-field-group',
						'elementor-column',
						'elementor-col-100',
					],
				],
				'submit-group' => [
					'class' => [
						'elementor-field-group',
						'elementor-column',
						'elementor-field-type-submit',
						'elementor-col-100',
					],
				],

				'button' => [
					'class' => [
						'elementor-button',
					],
					'name' => 'wp-submit',
				],
				'user_label' => [
					'for' => 'user',
				],
				'user_input' => [
					'type' => 'text',
					'name' => 'log',
					'id' => 'user',
					'placeholder' => $settings['user_placeholder'],
					'class' => [
						'elementor-field',
						'elementor-field-textual',
						'elementor-size-' . $settings['input_size'],
					],
				],
				'password_label' => [
					'for' => 'password',
				],
				'password_input' => [
					'type' => 'password',
					'name' => 'pwd',
					'id' => 'password',
					'placeholder' => $settings['password_placeholder'],
					'class' => [
						'elementor-field',
						'elementor-field-textual',
						'elementor-size-' . $settings['input_size'],
					],
				],
				//TODO: add unique ID
				'label_user' => [
					'for' => 'user',
					'class' => 'elementor-field-label',
				],

				'label_password' => [
					'for' => 'password',
					'class' => 'elementor-field-label',
				],
			]
		);

		if ( ! $settings['show_labels'] ) {
			$this->add_render_attribute( 'label', 'class', 'elementor-screen-only' );
		}

		$this->add_render_attribute( 'field-group', 'class', 'elementor-field-required' )
			 ->add_render_attribute( 'input', 'required', true )
			 ->add_render_attribute( 'input', 'aria-required', 'true' );

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$current_url = remove_query_arg( 'fake_arg' );
		$logout_redirect = $current_url;

		if ( 'yes' === $settings['redirect_after_login'] && ! empty( $settings['redirect_url']['url'] ) ) {
			$redirect_url = $settings['redirect_url']['url'];
		} else {
			$redirect_url = $current_url;
		}

		if ( 'yes' === $settings['redirect_after_logout'] && ! empty( $settings['redirect_logout_url']['url'] ) ) {
			$logout_redirect = $settings['redirect_logout_url']['url'];
		}

		if ( is_user_logged_in() && ! Plugin::elementor()->editor->is_edit_mode() ) {
			if ( 'yes' === $settings['show_logged_in_message'] ) {
				$current_user = wp_get_current_user();

				// PHPCS - `sprintf` is safe.
				echo '<div class="elementor-login elementor-login__logged-in-message">' .
					sprintf(
						/* translators: 1: User display name, 2: Link open tag, 3: Link closing tag. */
						esc_html__( 'You are Logged in as %1$s (%2$sLogout%3$s)', 'elementor-pro' ),
						wp_kses_post( $current_user->display_name ),
						sprintf( '<a href="%s" target="_blank">', esc_url( wp_logout_url( $logout_redirect ) ) ),
						'</a>'
					) .
					'</div>';
			}

			return;
		}

		$this->form_fields_render_attributes();
		?>
		<form class="elementor-login elementor-form" method="post" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>">
			<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_url ); ?>">
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<div <?php $this->print_render_attribute_string( 'field-group' ); ?>>
					<?php

					if ( $settings['show_labels'] ) {
						echo '<label ';
						$this->print_render_attribute_string( 'user_label' );
						echo '>';

						$this->print_unescaped_setting( 'user_label' );
						echo '</label>';
					}
					?>
					<input size="1" <?php $this->print_render_attribute_string( 'user_input' ); ?>>
				</div>
				<div <?php $this->print_render_attribute_string( 'field-group' ); ?>>
					<?php
					if ( $settings['show_labels'] ) :
						echo '<label ';
						$this->print_render_attribute_string( 'password_label' );
						echo '>';

						$this->print_unescaped_setting( 'password_label' );
						echo '</label>';
					endif;
					?>
					<input size="1" <?php $this->print_render_attribute_string( 'password_input' ); ?>>
				</div>

				<?php if ( 'yes' === $settings['show_remember_me'] ) : ?>
					<div class="elementor-field-type-checkbox elementor-field-group elementor-column elementor-col-100 elementor-remember-me">
						<label for="elementor-login-remember-me">
							<input type="checkbox" id="elementor-login-remember-me" name="rememberme" value="forever">
							<?php echo esc_html__( 'Remember Me', 'elementor-pro' ); ?>
						</label>
					</div>
				<?php endif; ?>

				<div <?php $this->print_render_attribute_string( 'submit-group' ); ?>>
					<button type="submit" <?php $this->print_render_attribute_string( 'button' ); ?>>
							<?php if ( ! empty( $settings['button_text'] ) ) : ?>
								<span class="elementor-button-text"><?php $this->print_unescaped_setting( 'button_text' ); ?></span>
							<?php endif; ?>
					</button>
				</div>

				<?php
				$show_lost_password = 'yes' === $settings['show_lost_password'];
				$show_register = get_option( 'users_can_register' ) && 'yes' === $settings['show_register'];

				if ( $show_lost_password || $show_register ) : ?>
					<div class="elementor-field-group elementor-column elementor-col-100">
						<?php if ( $show_lost_password ) : ?>
							<?php // PHPCS - `wp_lostpassword_url` is safe. ?>
							<a class="elementor-lost-password" href="<?php echo wp_lostpassword_url( $redirect_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>">
								<?php echo esc_html__( 'Lost your password?', 'elementor-pro' ); ?>
							</a>
						<?php endif; ?>

						<?php if ( $show_register ) : ?>
							<?php if ( $show_lost_password ) : ?>
								<span class="elementor-login-separator"> | </span>
							<?php endif; ?>
							<?php // PHPCS - `wp_registration_url` is safe. ?>
							<a class="elementor-register" href="<?php echo wp_registration_url(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>">
								<?php echo esc_html__( 'Register', 'elementor-pro' ); ?>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</form>
		<?php
	}

	/**
	 * Render Login Form output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<div class="elementor-login elementor-form">
			<div class="elementor-form-fields-wrapper">
				<#
					fieldGroupClasses = 'elementor-field-group elementor-column elementor-col-100 elementor-field-type-text';
				#>
				<div class="{{ fieldGroupClasses }}">
					<# if ( settings.show_labels ) { #>
						<label class="elementor-field-label" for="user" >{{{ settings.user_label }}}</label>
						<# } #>
							<input size="1" type="text" id="user" placeholder="{{ settings.user_placeholder }}" class="elementor-field elementor-field-textual elementor-size-{{ settings.input_size }}" />
				</div>
				<div class="{{ fieldGroupClasses }}">
					<# if ( settings.show_labels ) { #>
						<label class="elementor-field-label" for="password" >{{{ settings.password_label }}}</label>
						<# } #>
							<input size="1" type="password" id="password" placeholder="{{ settings.password_placeholder }}" class="elementor-field elementor-field-textual elementor-size-{{ settings.input_size }}" />
				</div>

				<# if ( settings.show_remember_me ) { #>
					<div class="elementor-field-type-checkbox elementor-field-group elementor-column elementor-col-100 elementor-remember-me">
						<label for="elementor-login-remember-me">
							<input type="checkbox" id="elementor-login-remember-me" name="rememberme" value="forever">
							<?php // PHPCS - `esc_html__` is safe. ?>
							<?php echo esc_html__( 'Remember Me', 'elementor-pro' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</label>
					</div>
				<# } #>

				<div class="elementor-field-group elementor-column elementor-field-type-submit elementor-col-100">
					<button type="submit" class="elementor-button elementor-size-{{ settings.button_size }}">
						<# if ( settings.button_text ) { #>
							<span class="elementor-button-text">{{ settings.button_text }}</span>
						<# } #>
					</button>
				</div>

				<# if ( settings.show_lost_password || settings.show_register ) { #>
					<div class="elementor-field-group elementor-column elementor-col-100">
						<# if ( settings.show_lost_password ) { #>
						<?php // PHPCS - `wp_lostpassword_url` is safe. ?>
						<a class="elementor-lost-password" href="<?php echo wp_lostpassword_url(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>">
								<?php echo esc_html__( 'Lost your password?', 'elementor-pro' ); ?>
							</a>
						<# } #>

						<?php if ( get_option( 'users_can_register' ) ) { ?>
							<# if ( settings.show_register ) { #>
								<# if ( settings.show_lost_password ) { #>
									<span class="elementor-login-separator"> | </span>
								<# } #>
							<?php // PHPCS - `wp_registration_url` is safe. ?>
							<a class="elementor-register" href="<?php echo wp_registration_url(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>">
									<?php echo esc_html__( 'Register', 'elementor-pro' ); ?>
								</a>
							<# } #>
						<?php } ?>
					</div>
				<# } #>
			</div>
		</div>
		<?php
	}

	public function render_plain_content() {}

	public function get_group_name() {
		return 'forms';
	}
}
