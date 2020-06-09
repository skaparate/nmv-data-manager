<?php
/**
 * Template for the back end/adminitration side of the plugin.
 *
 * @package Nicomv/Data_Manager/Templates
 */

use Nicomv\Data_Manager\Includes\Utils\Template_Utils;

if ( ! defined( 'ABSPATH' ) ) {
	die;
}
?>

<div class="grid-container">
	<div class="grid-item">
		<header>
			<img
				class="ff-logo"
				src="<?php echo esc_url( NMV_DATA_MANAGER_URL . '/src/assets/img/formidable-forms-logo.png' ); ?>"
				alt="<?php esc_html__( 'Formidable Forms Logo', 'nmv-data-manager' ); ?>" width="150" />
			<h2 class="page-title">
				<?php esc_html_e( 'Data Manager', 'nmv-data-manager' ); ?>
			</h2>
			<button class="refresh-data" title="<?php esc_html_e( 'Reload the data', 'nmv-data-manager' ); ?>">
				<?php esc_html_e( 'Refresh', 'nmv-data-manager' ); ?>
			</button>
		</header>
	</div>
</div>
<div class="grid-container">
	<div class="grid-item data-results">
		<?php Template_Utils::get_template( 'table-results', $context ); ?>
	</div>
	<div class="grid-item"></div>
	<div class="grid-item"></div>
</div>
