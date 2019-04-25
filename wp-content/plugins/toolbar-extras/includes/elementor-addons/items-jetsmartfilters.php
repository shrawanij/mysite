<?php

// includes/elementor-addons/items-jetsmartfilters

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbex_aoitems_jetsmartfilters', 100 );
/**
 * Items for Add-On: JetSmartFilters (Premium, by Zemez Jet/ CrocoBlock)
 *
 * @since 1.4.0
 *
 * @uses ddw_tbex_resource_item()
 *
 * @global mixed $GLOBALS[ 'wp_admin_bar' ]
 */
function ddw_tbex_aoitems_jetsmartfilters() {

	$post_type = 'jet-smart-filters';

	/** Plugin's settings */
	$GLOBALS[ 'wp_admin_bar' ]->add_node(
		array(
			'id'     => 'ao-jetsmartfilters',
			'parent' => 'group-creative-content',
			'title'  => esc_attr__( 'JetSmartFilters', 'toolbar-extras' ),
			'href'   => esc_url( admin_url( 'edit.php?post_type=' . $post_type ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_premium_addon_title_attr( __( 'JetSmartFilters', 'toolbar-extras' ) )
			)
		)
	);

		$GLOBALS[ 'wp_admin_bar' ]->add_node(
			array(
				'id'     => 'ao-jetsmartfilters-all',
				'parent' => 'ao-jetsmartfilters',
				'title'  => esc_attr__( 'All Filters', 'toolbar-extras' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $post_type ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'All Filters', 'toolbar-extras' )
				)
			)
		);

		$GLOBALS[ 'wp_admin_bar' ]->add_node(
			array(
				'id'     => 'ao-jetsmartfilters-new',
				'parent' => 'ao-jetsmartfilters',
				'title'  => esc_attr__( 'New Filter', 'toolbar-extras' ),
				'href'   => esc_url( admin_url( 'post-new.php?post_type=' . $post_type ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'New Filter', 'toolbar-extras' )
				)
			)
		);

		/** Filter categories, via BTC plugin */
		if ( ddw_tbex_is_btcplugin_active() ) {

			$GLOBALS[ 'wp_admin_bar' ]->add_node(
				array(
					'id'     => 'ao-jetsmartfilters-categories',
					'parent' => 'ao-jetsmartfilters',
					'title'  => ddw_btc_string_template( 'filter' ),
					'href'   => esc_url( admin_url( 'edit-tags.php?taxonomy=builder-template-category&post_type=' . $post_type ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_html( ddw_btc_string_template( 'filter' ) )
					)
				)
			);

		}  // end if

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$GLOBALS[ 'wp_admin_bar' ]->add_group(
				array(
					'id'     => 'group-jetsmartfilters-resources',
					'parent' => 'ao-jetsmartfilters',
					'meta'   => array( 'class' => 'ab-sub-secondary' )
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'jetsmartfilters-docs',
				'group-jetsmartfilters-resources',
				'https://documentation.zemez.io/wordpress/index.php?project=jetsmartfilters'
			);

			ddw_tbex_resource_item(
				'facebook-group',
				'jetsmartfilters-facebook',
				'group-jetsmartfilters-resources',
				'https://www.facebook.com/groups/CrocoblockCommunity/'
			);

			ddw_tbex_resource_item(
				'official-site',
				'jetsmartfilters-site',
				'group-jetsmartfilters-resources',
				'https://jetsmartfilters.zemez.io/'
			);

		}  // end if

}  // end function
