<?php
/**
 *
 * Adds custom Block Styles to the editor.
 *
 */

/**
 * Array of block styles.
 */
if ( ! function_exists( 'ktwc_block_styles' ) ) {
	function ktwc_block_styles() {
		return array(
			'links-plain' => array(
				'label' => __( 'Links - plain', 'ktwc' ),
				'blocks' => 'paragraph,heading,site-title,site-tagline,post-title,query-title,post-author,post-terms,query-pagination-previous,query-pagination-next,query-pagination-numbers',
				'style' => '.is-style-links-plain a, a.is-style-links-plain{text-decoration: none;}'
			),
			'links-underline-on-hover' => array(
				'label' => __( 'Links - underline on hover', 'ktwc' ),
				'blocks' => 'paragraph,heading,site-title,site-tagline,post-title,query-title,post-author,post-terms,query-pagination-previous,query-pagination-next,query-pagination-numbers',
				'style' => '.is-style-links-underline-on-hover a:not(:hover), a.is-style-links-underline-on-hover:not(:hover){text-decoration: none;}'
			),
			'script' => array(
				'label' => __( 'Script', 'ktwc' ),
				'blocks' => 'paragraph',
				'style' => '.is-style-script{font-family: var(--wp--preset--font-family--script);}'
			),
			'no-block-gap' => array(
				'label' => __( 'No Block Gap (zero top margin)', 'ktwc' ),
				'blocks' => 'paragraph,heading,site-tagline,site-title,post-title,query-title,group,image,media-text,cover',
				'style' => '.is-style-no-block-gap{margin-top: 0 !important;}'
			),
			'no-block-gap-row' => array(
				'label' => __( 'No Block Gap (horizontal gap in Row/Flex variation)', 'ktwc' ),
				'blocks' => 'group',
				'style' => '.is-style-no-block-gap-row{gap: 0 !important;}'
			),
			'zero-gap' => array(
				'label' => __( 'No Gaps', 'ktwc' ),
				'blocks' => 'columns',
				'style' => '.wp-block-columns.is-style-zero-gap{margin-bottom: 0} .wp-block-columns.is-style-zero-gap > .wp-block-column{margin-left: 0 !important;}'
			),
			'no-bottom-margin' => array(
				'label' => __( 'No Bottom Margin', 'ktwc' ),
				'blocks' => 'image',
				'style' => '.wp-block-image.is-style-no-bottom-margin{margin-bottom: 0;}'
			),
			'circle' => array(
				'label' => __( 'Circle', 'ktwc' ),
				'blocks' => 'list',
				'style' => '.is-style-circle{list-style: circle;}'
			),
			'disc' => array(
				'label' => __( 'Disc', 'ktwc' ),
				'blocks' => 'list',
				'style' => '.is-style-disc{list-style: disc;}'
			),
			'square' => array(
				'label' => __( 'Square', 'ktwc' ),
				'blocks' => 'list',
				'style' => '.is-style-square{list-style: square;}'
			),
			'line' => array(
				'label' => __( 'Line', 'ktwc' ),
				'blocks' => 'list',
				'style' => '.is-style-line{list-style: "- ";}'
			),
			'check' => array(
				'label' => __( 'Check', 'ktwc' ),
				'blocks' => 'list',
				'style' => '.is-style-check{list-style: "✓ ";}'
			),
			'cross' => array(
				'label' => __( 'Cross', 'ktwc' ),
				'blocks' => 'list',
				'style' => '.is-style-cross{list-style: "✗ ";}'
			),
			'star' => array(
				'label' => __( 'Star', 'ktwc' ),
				'blocks' => 'list',
				'style' => '.is-style-star{list-style: "★ ";}'
			),
			'arrow' => array(
				'label' => __( 'Arrow', 'ktwc' ),
				'blocks' => 'list',
				'style' => '.is-style-arrow{list-style: "→ ";}'
			),
			'chevron' => array(
				'label' => __( 'Chevron', 'ktwc' ),
				'blocks' => 'list',
				'style' => '.is-style-chevron{list-style: "› ";}'
			),
			'none' => array(
				'label' => __( 'No Style', 'ktwc' ),
				'blocks' => 'list',
				'style' => '.is-style-none{list-style: none;}'
			),
			'hide-nocomments' => array(
				'label' => __( 'Hide if comments closed', 'ktwc' ),
				'blocks' => 'post-comments',
				'style' => '.is-style-hide-nocomments .nocomments{display: none;}'
			),
			'reading-width' => array(
				'label' => __( 'Reading Width', 'ktwc' ),
				'blocks' => 'post-content,group',
				'style' => '.is-style-reading-width > *:not(.alignfull){max-width: min( calc(100vw - 2rem), 40rem) !important;margin-left:auto;margin-right:auto}.is-style-reading-width > .alignwide{max-width: min( calc(100vw - 2rem), 90rem) !important;}'
			),
		);
	}
}

/**
 * Register the block styles.
 */
function ktwc_register_block_styles() {
	$block_styles = ktwc_block_styles();
	foreach ( $block_styles as $block_style => $attrs ) {
		if ( isset($attrs['label']) && $attrs['label'] !== '' ) {
			$label = $attrs['label'];
		} else {
			$label = $block_style;
		}
		if ( isset($attrs['handle']) && $attrs['handle'] !== '' ) {
			$handle = $attrs['handle'];
		} else {
			$handle = 'ktwc-style';
		}
		if ( isset($attrs['style']) && $attrs['style'] !== '' ) {
			$style = $attrs['style'];
		} else {
			$style = '';
		}
		$blocks = explode( ',', $attrs['blocks'] );
		$block_count = 0;
		foreach ( $blocks as $block ) {
			$block_count++;
			if ( strpos( $block, '/' ) !== false ) {
				$block = $block;
			} else {
				$block = 'core/' . $block;
			}
			if ( $block_count > 1 ) {
				$style = '';
			}
			register_block_style(
				$block,
				array(
					'name' => $block_style,
					'label'	=> $label,
					'style_handle' => $handle,
					'inline_style' => $style
				)
			);
		}
	}
}

add_action( 'init', 'ktwc_register_block_styles' );
