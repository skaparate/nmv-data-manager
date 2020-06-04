<?php
/**
 * Template for the back end/adminitration side of the plugin.
 *
 * @package Nicomv/Data_Manager/Templates
 */

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
	<div class="grid-item">
		<table class="data-results table">
			<thead>
				<tr>
					<th>ID</th>
					<th><?php esc_html_e( 'First Name', 'nmv-data-manager' ); ?></th>
					<th><?php esc_html_e( 'Last Name', 'nmv-data-manager' ); ?></th>
					<th><?php esc_html_e( 'Email', 'nmv-data-manager' ); ?></th>
					<th><?php esc_html_e( 'Date', 'nmv-data-manager' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td></td>
					<td><?php esc_html_e( 'No results', 'nmv-data-manager' ); ?></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th>ID</th>
					<th><?php esc_html_e( 'First Name', 'nmv-data-manager' ); ?></th>
					<th><?php esc_html_e( 'Last Name', 'nmv-data-manager' ); ?></th>
					<th><?php esc_html_e( 'Email', 'nmv-data-manager' ); ?></th>
					<th><?php esc_html_e( 'Date', 'nmv-data-manager' ); ?></th>
				</tr>
			</tfoot>
		</table>
	</div>
	<div class="grid-item"></div>
	<div class="grid-item"></div>
</div>
