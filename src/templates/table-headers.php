<?php
	/**
	 * Common headers for the back and front end tables.
	 *
	 * @package Nicomv/Data_Manager/Templates
	 */

$_title     = isset( $context['data'] ) ? $context['data']->title : '';
$_is_footer = isset( $context['is_footer'] ) && true === $context['is_footer'];

?>

<?php if ( ! empty( $_title ) && ! $_is_footer ) : ?>
<tr>
	<th class="table-title" colspan="5"><?php echo esc_html( $context['data']->title ); ?></th>
</tr>
<?php endif; ?>
<tr>
	<?php foreach ( $context['header_urls'] as $key => $val ) : ?>
	<th class="table-header-<?php echo esc_attr( $key ); ?>">
		<?php if ( $val['url'] ) : ?>
		<a class="sorter with-icon"
		href="<?php echo esc_url( $val['url'] ); ?>"
		title="<?php echo esc_html( $val['sort_title'] ); ?>">
			<?php
			if ( $key === $context['sortable']->sort_by && $context['sortable']->is_ascending ) :
				?>
			<i class="icon-down-dir"></i>
			<?php else : ?>
			<i class="icon-up-dir"></i><?php endif; ?></a>
		<?php endif; // End url check. ?>
		<?php echo esc_html( trim( $val['name'] ) ); ?>
	</th>
	<?php endforeach; ?>
</tr>
