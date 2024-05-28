<?php
/**
 * @var array  $settings
 * @var array  $item
 * @var string $field_prefix
 */

defined( 'ABSPATH' ) || exit;

if ( ! $settings[ $field_prefix . 'title_hide' ] ) {
	echo owce_get_text_with_tag( $this, $settings[ $field_prefix . 'title_tag' ], $item['item_title'], [
		'class'        => 'owl-title',
		'data-setting' => 'item_title'
	] );
}
