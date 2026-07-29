<?php
/**
 * Core orchestrator. Singleton on purpose — exactly one instance ever
 * runs, so re-declaring `Novixa_Addons_Plugin` anywhere would trigger a
 * fatal instead of silently overriding another plugin's widgets.
 *
 * @package Novixa_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Novixa_Addons_Plugin' ) ) {

	/**
	 * Class Novixa_Addons_Plugin
	 */
	final class Novixa_Addons_Plugin {

		/**
		 * Singleton instance.
		 *
		 * @var Novixa_Addons_Plugin|null
		 */
		private static $instance = null;

		/**
		 * Hook loader.
		 *
		 * @var Novixa_Addons_Loader
		 */
		public $loader;

		/**
		 * Assets manager.
		 *
		 * @var Novixa_Addons_Assets
		 */
		public $assets;

		/**
		 * Admin screens manager.
		 *
		 * @var Novixa_Addons_Admin
		 */
		public $admin;

		/**
		 * Get (and lazily create) the singleton.
		 *
		 * @return Novixa_Addons_Plugin
		 */
		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Constructor — private, use ::instance().
		 */
		private function __construct() {
			if ( ! $this->environment_ok() ) {
				return;
			}

			$this->loader = new Novixa_Addons_Loader();
			$this->assets = new Novixa_Addons_Assets();
			$this->admin  = new Novixa_Addons_Admin();

			$this->define_admin_hooks();
			$this->define_common_hooks();
			$this->define_elementor_hooks();

			$this->loader->run();
		}

		/**
		 * Bail (with an admin notice) if PHP requirements are not met,
		 * instead of fataling the whole site.
		 *
		 * @return bool
		 */
		private function environment_ok() {
			$ok = true;

			if ( ! Novixa_Addons_Helper::version_ok( PHP_VERSION, NOVIXA_ADDONS_MIN_PHP_VERSION ) ) {
				add_action( 'admin_notices', array( $this, 'notice_min_php' ) );
				$ok = false;
			}

			add_action( 'admin_init', array( $this, 'check_elementor_dependency' ) );

			return $ok;
		}

		/**
		 * Runs on admin_init so `elementor/loaded` has already fired.
		 */
		public function check_elementor_dependency() {
			if ( ! Novixa_Addons_Helper::is_elementor_active() ) {
				add_action( 'admin_notices', array( $this, 'notice_missing_elementor' ) );
				return;
			}

			if ( defined( 'ELEMENTOR_VERSION' ) && ! Novixa_Addons_Helper::version_ok( ELEMENTOR_VERSION, NOVIXA_ADDONS_MIN_ELEMENTOR_VERSION ) ) {
				add_action( 'admin_notices', array( $this, 'notice_min_elementor' ) );
			}
		}

		/**
		 * Admin-side hooks: menu, assets, ajax, plugin row links.
		 */
		private function define_admin_hooks() {
			$this->loader->add_action( 'admin_menu', $this->admin, 'register_menu' );
			$this->loader->add_action( 'admin_enqueue_scripts', $this->assets, 'admin_assets' );
			$this->loader->add_action( 'admin_init', $this->admin, 'maybe_activation_redirect' );
			$this->loader->add_action( 'wp_ajax_novixa_addons_toggle_widget', $this->admin, 'ajax_toggle_widget' );
			$this->loader->add_action( 'wp_ajax_novixa_addons_save_settings', $this->admin, 'ajax_save_settings' );
			$this->loader->add_filter( 'plugin_action_links_' . NOVIXA_ADDONS_BASENAME, $this->admin, 'plugin_action_links' );
		}

		/**
		 * Hooks that apply regardless of admin/front-end.
		 */
		private function define_common_hooks() {
			// Intentionally empty: WordPress.org automatically loads this
			// plugin's translations since WP 4.6 — no load_plugin_textdomain()
			// call is needed (and one would trigger a Plugin Check warning).
		}

		/**
		 * Elementor-specific hooks — widgets, categories, editor assets.
		 */
		private function define_elementor_hooks() {
			$this->loader->add_action( 'elementor/widgets/register', $this, 'register_widgets' );
			$this->loader->add_action( 'elementor/elements/categories_registered', $this, 'register_widget_category' );
			$this->loader->add_action( 'elementor/frontend/after_enqueue_style', $this->assets, 'frontend_assets' );
			$this->loader->add_action( 'elementor/editor/after_enqueue_scripts', $this->assets, 'editor_assets' );
		}

		/**
		 * Translations are auto-loaded by WordPress.org for hosted plugins
		 * (since WP 4.6). This method is intentionally left blank/removed
		 * to avoid a discouraged-function warning from Plugin Check.
		 */

		/**
		 * Register our own Elementor widget category so all Novixa
		 * widgets group together instead of mixing into "General".
		 *
		 * @param \Elementor\Elements_Manager $elements_manager Elementor elements manager.
		 */
		public function register_widget_category( $elements_manager ) {
			$elements_manager->add_category(
				'novixa-addons',
				array(
					'title' => __( 'Novixa Addons', 'novixa-addons' ),
					'icon'  => 'eicon-nerd',
				)
			);
		}

		/**
		 * Loop the widget registry, include + instantiate every widget
		 * that is currently enabled in the dashboard.
		 *
		 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
		 */
		public function register_widgets( $widgets_manager ) {
			// Shared base class + traits every module can use.
			require_once NOVIXA_ADDONS_PATH . 'includes/class-widget-base.php';
			require_once NOVIXA_ADDONS_PATH . 'traits/trait-global-controls.php';

			foreach ( novixa_addons_widgets_registry() as $slug => $module ) {
				if ( ! novixa_addons_is_widget_enabled( $slug ) ) {
					continue;
				}

				$file = NOVIXA_ADDONS_MODULES_PATH . $slug . '/' . $module['class_file'];

				if ( ! file_exists( $file ) ) {
					continue;
				}

				require_once $file;

				if ( class_exists( $module['class_name'] ) ) {
					$widgets_manager->register( new $module['class_name']() );
				}
			}
		}

		/**
		 * Notice: PHP version too old.
		 */
		public function notice_min_php() {
			$message = sprintf(
				/* translators: 1: Required PHP version 2: Current PHP version */
				esc_html__( 'Novixa Addons requires PHP %1$s or higher. Your server is running %2$s.', 'novixa-addons' ),
				NOVIXA_ADDONS_MIN_PHP_VERSION,
				PHP_VERSION
			);
			printf( '<div class="notice notice-error"><p>%s</p></div>', wp_kses_post( $message ) );
		}

		/**
		 * Notice: Elementor not installed/active.
		 */
		public function notice_missing_elementor() {
			$message = esc_html__( 'Novixa Addons requires Elementor to be installed and active.', 'novixa-addons' );
			printf( '<div class="notice notice-warning"><p>%s</p></div>', wp_kses_post( $message ) );
		}

		/**
		 * Notice: Elementor is active but too old.
		 */
		public function notice_min_elementor() {
			$message = sprintf(
				/* translators: %s: Required Elementor version */
				esc_html__( 'Novixa Addons requires Elementor version %s or higher.', 'novixa-addons' ),
				NOVIXA_ADDONS_MIN_ELEMENTOR_VERSION
			);
			printf( '<div class="notice notice-warning"><p>%s</p></div>', wp_kses_post( $message ) );
		}

		/**
		 * Prevent cloning of the singleton.
		 */
		private function __clone() {}

		/**
		 * Prevent unserializing of the singleton.
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cannot unserialize singleton.', 'novixa-addons' ), '1.0.0' );
		}
	}
}
