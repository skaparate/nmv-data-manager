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
	<div class="header-left">
		<header>
			<img
				class="ff-logo"
				src="<?php echo esc_url( NMV_DATA_MANAGER_URL . '/src/assets/img/formidable-forms-logo.png' ); ?>"
				alt="<?php esc_html__( 'Formidable Forms Logo', 'nmv-data-manager' ); ?>" width="150" />
			<h2 class="page-title">
				<?php esc_html_e( 'Data Manager', 'nmv-data-manager' ); ?>
			</h2>
			<button class="refresh-data" title="<?php esc_html_e( 'Reload the data', 'nmv-data-manager' ); ?>">
				<i class="icon-arrows-cw"></i>
				<?php esc_html_e( 'Refresh', 'nmv-data-manager' ); ?>
			</button>
		</header>
	</div>
	<div class="header-right grid-item flex-right">
		<form class="data-search">
			<div class="icon-overlay-right">
				<input
					class="data-search--input"
					type="text"
					name="search"
					placeholder="<?php esc_attr_e( 'I\'m looking for...', 'nmv-data-manager' ); ?>" /><button class="data-search--cancel"><i class="icon-cancel"></i>
					<span class="sr-only"><?php esc_html_e( 'Clear the search', 'nmv-data-manager' ); ?></span>
				</button>
			</div><button class="data-search--submit" title="<?php esc_attr_e( 'Filter the results on the table', 'nmv-data-manager' ); ?>">
					<i class="icon-search"></i>
				<span class="text"><?php esc_html_e( 'Search', 'nmv-data-manager' ); ?></span>
			</button>
		</form>
	</div>
	<div class="row data-results">
		<?php Template_Utils::get_template( 'table-results', $context ); ?>
	</div>
</div>
