<?php
/**
 * Jigoshop Form Class for displaying various input types in forms
 *
 * DISCLAIMER
 *
 * Do not edit or add directly to this file if you wish to upgrade Jigoshop to newer
 * versions in the future. If you wish to customise Jigoshop core for your needs,
 * please use our GitHub repository to publish essential changes for consideration.
 *
 * @package             Jigoshop
 * @category            Admin
 * @author              Jigowatt
 * @copyright           Copyright © 2011-2012 Jigowatt Ltd.
 * @license             http://jigoshop.com/license/commercial-edition
 */

class Jigoshop_Forms extends Jigoshop_Base {

	public static function input( $field ) {
		global $post;

		$args = array(
			'id'            => null,
			'type'          => 'text',
			'label'         => null,
			'after_label'   => null,
			'class'         => 'short',
			'desc'          => false,
			'tip'           => false,
			'value'         => null,
			'placeholder'   => null,
		);
		extract( wp_parse_args( $field, $args ) );

		$value = ($value) ? esc_attr( $value ) : get_post_meta( $post->ID, $id, true) ;

		$html  = '';

		$html .= "<p class='form-field {$id}_field'>";
		$html .= "<label for='{$id}'>$label{$after_label}</label>";
		$html .= "<input type='{$type}' class='{$class}' name='{$id}' id='{$id}' value='{$value}' placeholder='{$placeholder}' />";

		if ( $tip ) {
			$html .= '<a href="#" tip="'.$tip.'" class="tips" tabindex="99"></a>';
		}
		
		if ( $desc ) {
			$html .= '<span class="description">'.$desc.'</span>';
		}

		$html .= "</p>";
		return $html;
	}

	public static function select( $field ) {
		global $post;

		$args = array(
			'id'            => null,
			'label'         => null,
			'after_label'   => null,
			'class'         => 'select short',
			'desc'          => false,
			'tip'           => false,
			'multiple'      => false,
			'placeholder'   => '',
			'options'       => array(),
			'selected'      => false
		);
		extract( wp_parse_args( $field, $args ) );

		$selected = ($selected) ? (array)$selected : (array)get_post_meta($post->ID, $id, true);
		$name = ($multiple) ? $id.'[]' : $id;
		$multiple = ($multiple) ? 'multiple="multiple"' : '';
		$desc = ($desc) ? esc_html( $desc ) : false;

		$html = '';

		$html .= "<p class='form-field {$id}_field'>";
		$html .= "<label for='{$id}'>$label{$after_label}</label>";
		$html .= "<select {$multiple} id='{$id}' name='{$name}' class='{$class}' data-placeholder='{$placeholder}'>";
		
		foreach ( $options as $value => $label ) {
			$mark = '';
			if ( in_array( $value, $selected ) ) {
				$mark = 'selected="selected"';
			}
			$html .= "<option value='{$value}' {$mark}>{$label}</option>";
		}
		$html .= "</select>";

		if ( $tip ) {
			$html .= '<a href="#" tip="'.$tip.'" class="tips" tabindex="99"></a>';
		}
		
		if ( $desc ) {
			$html .= '<span class="description">'.$desc.'</span>';
		}

		$html .= "</p>";
		$html .=    '<script type="text/javascript">
						jQuery(function() {
							jQuery("#'.$id.'").select2();
						});
					</script>';

		return $html;
	}

	public static function checkbox( $field ) {
		global $post;

		$args = array(
			'id'            => null,
			'label'         => null,
			'after_label'   => null,
			'class'         => 'checkbox',
			'desc'          => false,
			'tip'           => false,
			'value'         => false
		);
		extract( wp_parse_args( $field, $args ) );

		$value = ($value) ? $value : get_post_meta($post->ID, $id, true);
		$desc  = ($desc)  ? esc_html($desc) : false;

		$html = '';

		$mark = '';
		if ( $value ) {
			$mark = 'checked="checked"';
		}

		$html .= "<p class='form-field {$id}_field'>";
		$html .= "<label for='{$id}'>$label{$after_label}</label>";
		$html .= "<input type='checkbox' name='{$id}' value='1' class='{$class}' id='{$id}' {$mark} />";

		if ( $desc ) {
			$html .= "<label for='{$id}' class='description'>$desc</label>";
		}

		if ( $tip ) {
			$html .= '<a href="#" tip="'.$tip.'" class="tips" tabindex="99"></a>';
		}
		
		$html .= "</p>";
		return $html;
	}
}
