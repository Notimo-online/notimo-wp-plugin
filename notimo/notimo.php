<?php
/**
 * Plugin Name: Notimo
 * Plugin URI: https://notimo.online/
 * Description: Notimo v1.0.0 - loads Notimo on every front-end page using a licence code configured in the WordPress admin.
 * Version: 1.1.0
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * Author: Notimo
 * Author URI: https://notimo.online/
 * licence: GPL-2.0-or-later
 * licence URI: https://www.gnu.org/licences/gpl-2.0.html
 * Update URI: https://github.com/notimo-online/notimo-wp-plugin
 * Text Domain: notimo
 */

defined( 'ABSPATH' ) || exit;

define( 'NOTIMO_VERSION', '1.1.0' );

final class Notimo_Head_Injector {

	const OPTION_NAME = 'notimo_head_injector_licence_code';
	const SETTINGS_GROUP = 'notimo_head_injector_settings';
	const SETTINGS_PAGE = 'notimo';
	const UPDATE_URI = 'https://raw.githubusercontent.com/notimo-online/notimo-wp-plugin/main/update.json';

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_head', array( $this, 'admin_icon_styles' ) );
		add_action( 'template_redirect', array( $this, 'start_output_buffer' ), 0 );
		add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'check_for_updates' ) );
		add_filter( 'plugins_api', array( $this, 'plugin_information' ), 10, 3 );
	}

	public function add_settings_page() {
		add_menu_page(
			__( 'Notimo', 'notimo' ),
			__( 'Notimo', 'notimo' ),
			'manage_options',
			self::SETTINGS_PAGE,
			array( $this, 'render_settings_page' ),
			'none',
			81
		);
	}

	public function admin_icon_styles() {
		$icon_url = esc_url( plugins_url( 'notimo.png', __FILE__ ) );
		?>
		<style>
			#adminmenu #toplevel_page_notimo .wp-menu-image,
			#adminmenu #toplevel_page_notimo:hover .wp-menu-image,
			#adminmenu #toplevel_page_notimo.wp-has-current-submenu .wp-menu-image {
				width: 36px !important;
				height: 34px !important;
				padding: 0 !important;
				background: url('<?php echo $icon_url; ?>') center center / 28px 34px no-repeat !important;
			}
			#adminmenu #toplevel_page_notimo .wp-menu-image::before,
			#adminmenu #toplevel_page_notimo .wp-menu-image::after,
			#adminmenu #toplevel_page_notimo .wp-menu-image img {
				display: none !important;
				content: none !important;
			}
		</style>
		<?php
	}

	public function check_for_updates( $transient ) {
		if ( ! is_object( $transient ) || empty( $transient->checked ) ) {
			return $transient;
		}
		$plugin_file = plugin_basename( __FILE__ );
		$manifest = $this->get_update_manifest();
		if ( is_wp_error( $manifest ) || empty( $manifest->version ) || empty( $manifest->download_url ) ) {
			return $transient;
		}
		if ( version_compare( NOTIMO_VERSION, $manifest->version, '<' ) ) {
			$transient->response[ $plugin_file ] = (object) array(
				'slug' => dirname( $plugin_file ), 'plugin' => $plugin_file,
				'new_version' => sanitize_text_field( $manifest->version ),
				'url' => ! empty( $manifest->homepage ) ? esc_url_raw( $manifest->homepage ) : 'https://notimo.online/',
				'package' => esc_url_raw( $manifest->download_url ),
			);
		}
		return $transient;
	}

	public function plugin_information( $result, $action, $args ) {
		if ( 'plugin_information' !== $action || empty( $args->slug ) || dirname( plugin_basename( __FILE__ ) ) !== $args->slug ) {
			return $result;
		}
		$manifest = $this->get_update_manifest();
		if ( is_wp_error( $manifest ) ) { return $result; }
		return (object) array(
			'name' => 'Notimo', 'slug' => dirname( plugin_basename( __FILE__ ) ),
			'version' => ! empty( $manifest->version ) ? $manifest->version : NOTIMO_VERSION,
			'author' => '<a href="https://notimo.online/">Notimo</a>',
			'homepage' => ! empty( $manifest->homepage ) ? $manifest->homepage : 'https://notimo.online/',
			'download_link' => ! empty( $manifest->download_url ) ? esc_url_raw( $manifest->download_url ) : '',
			'requires' => ! empty( $manifest->requires ) ? sanitize_text_field( $manifest->requires ) : '5.8',
			'requires_php' => ! empty( $manifest->requires_php ) ? sanitize_text_field( $manifest->requires_php ) : '7.4',
			'sections' => ! empty( $manifest->sections ) ? (array) $manifest->sections : array(),
		);
	}

	private function get_update_manifest() {
		$cache_key = 'notimo_update_manifest';
		$cached = get_site_transient( $cache_key );
		if ( false !== $cached ) { return $cached; }
		$response = wp_remote_get( self::UPDATE_URI, array( 'timeout' => 8, 'redirection' => 2, 'sslverify' => true, 'headers' => array( 'Accept' => 'application/json' ) ) );
		if ( is_wp_error( $response ) ) { return $response; }
		$manifest = json_decode( wp_remote_retrieve_body( $response ) );
		if ( ! is_object( $manifest ) ) { return new WP_Error( 'notimo_invalid_manifest', 'Invalid Notimo update manifest.' ); }
		set_site_transient( $cache_key, $manifest, 6 * HOUR_IN_SECONDS );
		return $manifest;
	}

	public function register_settings() {
		register_setting(
			self::SETTINGS_GROUP,
			self::OPTION_NAME,
			array(
				'type'              => 'string',
				'sanitize_callback' => array( $this, 'sanitize_licence_code' ),
				'default'           => '',
			)
		);

		add_settings_section(
			'notimo_head_injector_main',
			__( 'Notimo Configuration', 'notimo' ),
			array( $this, 'render_section_description' ),
			self::SETTINGS_PAGE
		);

		add_settings_field(
			self::OPTION_NAME,
			__( 'licence code', 'notimo' ),
			array( $this, 'render_licence_field' ),
			self::SETTINGS_PAGE,
			'notimo_head_injector_main'
		);
	}

	public function sanitize_licence_code( $value ) {
		$value = is_string( $value ) ? trim( $value ) : '';
		// licence codes are URL query-string values; keep only safe characters.
		return preg_replace( '/[^A-Za-z0-9._-]/', '', $value );
	}

	public function render_section_description() {
		echo '<p>' . esc_html__( 'Enter your Notimo licence code. Notimo will be loaded in the document head on every public-facing page.', 'notimo' ) . '</p>';
	}

	public function render_licence_field() {
		$value = get_option( self::OPTION_NAME, '' );
		printf(
			'<input type="text" class="regular-text" id="%1$s" name="%1$s" value="%2$s" autocomplete="off" placeholder="ntmstrg_nnnnn" />',
			esc_attr( self::OPTION_NAME ),
			esc_attr( $value )
		);
		echo '<p class="description">' . esc_html__( 'Leave blank to disable the SDK.', 'notimo' ) . '</p>';
	}

	public function render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
		<div class="wrap notimo-admin-page">
			<style>
				.notimo-admin-page .notimo-success { background: rgb(88 135 255); color: #fff; border-radius: 8px; padding: 12px 16px; margin: 12px 0 20px; font-size: 14px; font-weight: 600; }
				.notimo-admin-page .notimo-hero { max-width: 900px; margin: 20px 0 28px; text-align: center; }
				.notimo-admin-page .notimo-hero h1 { font-size: clamp(2.25rem, 5vw, 3rem); font-weight: 600; letter-spacing: -0.025em; line-height: 1.15; margin: 0; }
				.notimo-admin-page .notimo-hero p { font-size: 1.125rem; font-weight: 400; opacity: .8; margin: 22px auto 0; max-width: 700px; }
			</style>
			<div style="display:flex;align-items:center;gap:10px;margin:12px 0 18px;"><img src="<?php echo esc_url( plugins_url( 'notimo.png', __FILE__ ) ); ?>" alt="" width="40" height="40" style="border-radius:8px;"><h1 style="margin:0;"><?php echo esc_html( get_admin_page_title() ); ?></h1></div>
			<?php if ( isset( $_GET['settings-updated'] ) && 'true' === $_GET['settings-updated'] ) : ?>
				<div class="notimo-success" role="status"><?php echo esc_html__( 'The licence code was updated successfully.', 'notimo' ); ?></div>
			<?php endif; ?>
			<div class="notimo-hero">
				<h1><span>Show the right message</span><br><span>at the right moment, on your website</span><p>Notimo helps teams manage on-site messages like banners or notifications without writing code.</p></h1>
			</div>
			<form action="options.php" method="post">
				<?php
				settings_fields( self::SETTINGS_GROUP );
				do_settings_sections( self::SETTINGS_PAGE );
				submit_button( __( 'Save licence code', 'notimo' ) );
				?>
			</form>
		</div>
		<?php
	}

	public function start_output_buffer() {
		if ( is_admin() || is_feed() || is_robots() || wp_doing_ajax() ) {
			return;
		}
		ob_start( array( $this, 'inject_before_closing_head' ) );
	}

	public function inject_before_closing_head( $html ) {
		$licence_code = get_option( self::OPTION_NAME, '' );
		if ( '' === $licence_code || false === stripos( $html, '</head>' ) ) {
			return $html;
		}

		$licence_code = esc_js( $licence_code );
		$sdk_url      = esc_url( 'https://client.notimo.online/sdk.js?licence_code=' . rawurlencode( $licence_code ) );
		$notimo       = "\n<!-- Start Notimo -->\n<script>\n(function () {\n    const licence_code = '{$licence_code}';\n    const script = document.createElement('script');\n    script.src = '{$sdk_url}';\n    script.async = true;\n    document.head.appendChild(script);\n}());\n</script>\n<!-- End Notimo -->\n";
		return preg_replace( '/<\/head>/i', $notimo . '</head>', $html, 1 );
	}
}

new Notimo_Head_Injector();

