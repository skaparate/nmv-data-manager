<?php
/**
 * Template for the tabular data.
 *
 * The templtate expects a $context variable with the following properties:
 *
 * data: a Data_Result instance.
 * exclude_footer: optional, used to exclude the footer.
 *
 * @package Nicomv/Data_Manager/Templates
 */

use Nicomv\Data_Manager\Includes\Utils\Template_Utils;

?>

<table class="nmv-data-manager--results table">
	<thead>
		<?php Template_Utils::get_template( 'table-headers', $context ); ?>
	</thead>
	<tbody>
		<?php if ( ! $context['data']->content ) : ?>
		<tr>
			<td colspan="5"><?php esc_html_e( 'No results', 'nmv-data-manager' ); ?></td>
		</tr>
		<?php else : ?>
			<?php foreach ( $context['data']->content as $key => $val ) : ?>
		<tr>
			<td><?php echo esc_html( $val['id'] ); ?></td>
			<td><?php echo esc_html( $val['fname'] ); ?></td>
			<td><?php echo esc_html( $val['lname'] ); ?></td>
			<td><?php echo esc_html( $val['email'] ); ?></td>
			<td>
				<?php $dt = new DateTime( $val['date'] ); ?>
				<time datetime="<?php echo esc_attr( $val['date'] ); ?>">
					<abbr title="<?php echo esc_attr( $val['date'] ); ?>">
					<?php echo esc_html( $dt->format( 'd/m/Y' ) ); ?>
					</abbr>
				</time>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
	<?php if ( ! isset( $context['exclude_footer'] ) ) : ?>
	<tfoot>
		<?php
		$context['is_footer'] = true;
		Template_Utils::get_template( 'table-headers', $context );
		?>
	</tfoot>
	<?php endif; // Check exclude_footer. ?>
</table>
