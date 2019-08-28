<?php
// phpcs:disable

//phpcs:disable Generic.ControlStructures.InlineControlStructure.NotAllowed
//phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped



/**
 * Render Address Field
 */
function render_link_field_callback( $field, $value, $object_id, $object_type, $field_type ) {

	// make sure we specify each part of the value we need.
	$value = wp_parse_args(
		$value,
		array(
			'url' => '',
			'title' => '',
			'target' => '',
		)
	);
?>

<section style="padding: 1vw;margin: 1vw;">
	<div>
		<p>
			<label for="<?php echo $field_type->_id( '_url' ); ?>">Link URL</label>
		</p>
			<?php echo $field_type->input( array(
				'name'  => $field_type->_name( '[url]' ),
				'id'    => $field_type->_id( '_url' ),
				'value' => $value['url'],
				'desc'  => 'Link URL',
			) ); ?>

		<p>
			<label for="<?php echo $field_type->_id( '_title' ); ?>">Link Title</label>
		</p>
			<?php echo $field_type->input( array(
				'name'  => $field_type->_name( '[title]' ),
				'id'    => $field_type->_id( '_title' ),
				'value' => $value['title'],
				'desc'  => 'Link Title',
			) ); ?>

<p>
<label for="<?php echo $field_type->_id( '_target' ); ?>">Link Target</label>
</p>
<?php echo $field_type->input( array(
	'name'  => $field_type->_name( '[target]' ),
	'id'    => $field_type->_id( '_target' ),
	'value' => $value['target'],
	'desc'  => 'Link Target',
) ); ?>
	</div>

</section>
	<br class="clear">
<?php
	// echo $field_type->_desc( true );
echo 'refactored version';

} // end def render_address_field_callback( $field, $value, $object_id, $object_type, $field_type )

add_filter( 'cmb2_render_link', 'render_link_field_callback', 10, 5 );
