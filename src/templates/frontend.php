<?php
/**
 * Front end template to display data.
 *
 * @package Nicomv/Data_Manager/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}
?>

<div class="nmv-data-manager">
	<h2>Query Results</h2>
	<table class="nmv-data-manager--results table">
		<thead>
			<tr>
				<th>ID</th>
				<th><?php esc_html_e( 'First Name', 'nmv-data-manager' ); ?></th>
				<th><?php esc_html_e( 'Last Name', 'nmv-data-manager' ); ?></th>
				<th><?php esc_html_e( 'Email', 'nmv-data-manager' ); ?></th>
				<th><?php esc_html_e( 'Date', 'nmv-data-manager' ); ?></th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>
