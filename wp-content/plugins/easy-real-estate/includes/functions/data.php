<?php
/**
 * A helper class to centralize data to gain better performance on server side.
 */

class ERE_Data {

	/**
	 * Locations (property cities) Variables
	 */
	// Locations array containing key(slug) => value(name) pair
	private static $locations_slug_name = array();

	// Locations array containing key(term_id) => value(name) pair
	private static $locations_id_name = array();

	// Hierarchical array of property cities
	private static $hierarchical_locations;

	// Hierarchical array of non-empty property cities
	private static $hierarchical_none_empty_locations;


	/**
	 * Statuses Variables
	 */
	// Statuses array containing key(slug) => value(name) pair
	private static $statuses_slug_name = array();

	// Statuses array containing key(term_id) => value(name) pair
	private static $statuses_id_name = array();

	// Hierarchical array of property statuses
	private static $hierarchical_property_statuses;


	/**
	 * Types Variables
	 */
	// Types array containing key(slug) => value(name) pair
	private static $types_slug_name = array();

	// Types array containing key(term_id) => value(name) pair
	private static $types_id_name = array();

	// Hierarchical array of property types
	private static $hierarchical_property_types;

	// Hierarchical array of non-empty property types
	private static $hierarchical_none_empty_property_types;


	/**
	 * Features Variables
	 */
	// Features array containing key(slug) => value(name) pair
	private static $features_slug_name = array();

	// Features array containing key(term_id) => value(name) pair
	private static $features_id_name = array();

	// Hierarchical array of property features
	private static $hierarchical_property_features;


	/**
	 * Others
	 */
	// Array of agents with agent id as index and title as value
	private static $agents_id_name;


	/**
	 * Returns array of property cities (locations) containing key(slug) => value(name) pair
	 *
	 * @param bool $hide_empty
	 *
	 * @return array
	 */
	public static function get_locations_slug_name( bool $hide_empty = false ): array {
		if ( empty( self::$locations_slug_name ) ) {
			self::assemble_slug_name_array( self::get_hierarchical_locations(),  self::$locations_slug_name, $hide_empty );
		}
		return self::$locations_slug_name;
	}

	/**
	 * Returns array of property cities (locations) containing key(term_id) => value(name) pair
	 *
	 * @param bool $hide_empty
	 *
	 * @return array
	 */
	public static function get_locations_id_name( bool $hide_empty = false ): array {
		if ( empty( self::$locations_id_name ) ) {
			self::assemble_id_name_array( self::get_hierarchical_locations(), self::$locations_id_name, $hide_empty );
		}
		return self::$locations_id_name;
	}

	/**
	 * Returns hierarchical array of locations (property cities)
	 *
	 * @param bool $hide_empty
	 *
	 * @return array
	 */
	public static function get_hierarchical_locations( bool $hide_empty = false ): array {
		if ( empty( self::$hierarchical_locations ) && ! $hide_empty ) {
			self::$hierarchical_locations = self::get_hierarchical_terms( 'property-city' );
		} else if ( empty( self::$hierarchical_none_empty_locations ) && $hide_empty ) {
			self::$hierarchical_none_empty_locations = self::get_hierarchical_terms( 'property-city', true );
		}

		if ( $hide_empty ) {
			return self::$hierarchical_none_empty_locations;
		} else {
			return self::$hierarchical_locations;
		}
	}


	/**
	 * Returns array of property statuses containing key(slug) => value(name) pair
	 *
	 * @param bool $hide_empty
	 *
	 * @return array
	 */
	public static function get_statuses_slug_name( bool $hide_empty = false ): array {
		if ( empty( self::$statuses_slug_name ) ) {
			self::assemble_slug_name_array( self::get_hierarchical_property_statuses(), self::$statuses_slug_name, $hide_empty );
		}
		return self::$statuses_slug_name;
	}

	/**
	 * Returns array of property statuses containing key(term_id) => value(name) pair
	 *
	 * @param bool $hide_empty
	 *
	 * @return array
	 */
	public static function get_statuses_id_name( bool $hide_empty = false ): array {
		if ( empty( self::$statuses_id_name ) ) {
			self::assemble_id_name_array( self::get_hierarchical_property_statuses(), self::$statuses_id_name, $hide_empty );
		}
		return self::$statuses_id_name;
	}

	/**
	 * Returns hierarchical array of property statuses
	 *
	 * @return array
	 */
	public static function get_hierarchical_property_statuses(): array {
		if ( empty( self::$hierarchical_property_statuses ) ) {
			self::$hierarchical_property_statuses = self::get_hierarchical_terms( 'property-status' );
		}

		return self::$hierarchical_property_statuses;
	}


	/**
	 * Returns array of property types containing key(slug) => value(name) pair
	 *
	 * @param bool $hide_empty
	 *
	 * @return array
	 */
	public static function get_types_slug_name( bool $hide_empty = false ): array {
		if ( empty( self::$types_slug_name ) ) {
			self::assemble_slug_name_array( self::get_hierarchical_property_types(), self::$types_slug_name, $hide_empty );
		}
		return self::$types_slug_name;
	}

	/**
	 * Returns array of property types containing key(term_id) => value(name) pair
	 *
	 * @param bool $hide_empty
	 *
	 * @return array
	 */
	public static function get_types_id_name( bool $hide_empty = false ): array {
		if ( empty( self::$types_id_name ) ) {
			self::assemble_id_name_array( self::get_hierarchical_property_types(), self::$types_id_name, $hide_empty );
		}
		return self::$types_id_name;
	}

	/**
	 * Returns hierarchical array of property types
	 *
	 * @param bool $hide_empty
	 *
	 * @return array
	 */
	public static function get_hierarchical_property_types( bool $hide_empty = false ): array {
		if ( empty( self::$hierarchical_property_types ) && ! $hide_empty ) {
			self::$hierarchical_property_types = self::get_hierarchical_terms( 'property-type' );
		} else if ( empty( self::$hierarchical_none_empty_property_types ) && $hide_empty ) {
			self::$hierarchical_none_empty_property_types = self::get_hierarchical_terms( 'property-type', true );
		}

		if ( $hide_empty ) {
			return self::$hierarchical_none_empty_property_types;
		} else {
			return self::$hierarchical_property_types;
		}

	}


	/**
	 * Returns array of property features containing key(slug) => value(name) pair
	 *
	 * @param bool $hide_empty
	 *
	 * @return array
	 */
	public static function get_features_slug_name( bool $hide_empty = false ): array {
		if ( empty( self::$features_slug_name ) ) {
			self::assemble_slug_name_array( self::get_hierarchical_property_features(), self::$features_slug_name, $hide_empty );
		}
		return self::$features_slug_name;
	}

	/**
	 * Returns array of property features containing key(term_id) => value(name) pair
	 *
	 * @param bool $hide_empty
	 *
	 * @return array
	 */
	public static function get_features_id_name( bool $hide_empty = false ): array {
		if ( empty( self::$features_id_name ) ) {
			self::assemble_id_name_array( self::get_hierarchical_property_features(), self::$features_id_name, $hide_empty );
		}
		return self::$features_id_name;
	}

	/**
	 * Returns hierarchical array of property features
	 *
	 * @return array
	 */
	public static function get_hierarchical_property_features(): array {
		if ( empty( self::$hierarchical_property_features ) ) {
			self::$hierarchical_property_features = self::get_hierarchical_terms( 'property-feature' );
		}

		return self::$hierarchical_property_features;
	}


	/**
	 * Returns an array of agents with agent id as index and title as value
	 *
	 * @return array|null
	 */
	public static function get_agents_id_name(): array {
		if ( empty( self::$agents_id_name ) ) {

			$agents_query = new WP_Query( array(
				'post_type'        => 'agent',
				'posts_per_page'   => - 1,
				'suppress_filters' => false, //So WPML can filter the posts according to current language
			) );

			$agents_array = array();
			if ( ! empty( $agents_query->posts ) ) {
				foreach ( $agents_query->posts as $single_agent ) {
					$agents_array[ $single_agent->ID ] = $single_agent->post_title;
				}
				self::$agents_id_name = $agents_array;
			} else {
				self::$agents_id_name = $agents_array;
			}
		}

		return self::$agents_id_name;
	}

	/**
	 * Returns a hierarchical array of terms where children terms are in children array.
	 *
	 * @param string $taxonomy_name
	 * @param false $hide_empty
	 *
	 * @return array
	 */
	private static function get_hierarchical_terms( string $taxonomy_name, bool $hide_empty = false ): array {
		$hierarchical_terms_array = array();

		$taxonomy_terms = get_terms( array(
			'taxonomy'   => $taxonomy_name,
			'hide_empty' => $hide_empty,
			'suppress_filters' => false,
		) );

		if ( ! empty( $taxonomy_terms ) && ! is_wp_error( $taxonomy_terms ) ) {
			$parents_index = 0;   // we have to use array index as we will be converting this array to JavaScript array for search form
			foreach ( $taxonomy_terms as $index => $term ) {
				if ( $term->parent == 0 ) {
					$hierarchical_terms_array[ $parents_index ] = self::get_term_data( $term );
					unset( $taxonomy_terms[ $index ] );    // to optimise performance
					self::add_term_children(
						$hierarchical_terms_array[ $parents_index ], // parent term
						$taxonomy_terms, // all terms from database
						$hierarchical_terms_array[ $parents_index ]['children'] // children array
					);
					$parents_index++;
				}
			}
		}

		return $hierarchical_terms_array;
	}

	/**
	 * Navigate through taxonomy terms array and organise children terms in children array.
	 *
	 * @param array $parent_term_data
	 * @param array $taxonomy_terms
	 * @param array $children
	 */
	private static function add_term_children( array $parent_term_data, array &$taxonomy_terms, array &$children ) {
		if ( ! empty( $taxonomy_terms ) ) {
			$children_index = 0;
			foreach ( $taxonomy_terms as $index => $term ) {
				if ( $term->parent == $parent_term_data['term_id'] ) {
					$children[ $children_index ] = self::get_term_data( $term );
					unset( $taxonomy_terms[ $index ] );   // to optimise performance
					self::add_term_children(
						$children[ $children_index ],
						$taxonomy_terms,
						$children[ $children_index ]['children']    //children array
					);
					$children_index++;
				}
			}
		}
	}

	/**
	 * Returns an associative array containing necessary fields from WP_Term object.
	 *
	 * @param WP_Term $term
	 *
	 * @return array
	 */
	private static function get_term_data( WP_Term $term ): array {
		$term_data             = array();
		$term_data['term_id']  = $term->term_id;
		$term_data['name']     = $term->name;
		$term_data['slug']     = $term->slug;
		$term_data['parent']   = $term->parent;
		$term_data['count']    = $term->count;
		$term_data['children'] = array();

		return $term_data;
	}

	/**
	 * Generate array containing key(slug) => value(name) pair from a hierarchical terms array.
	 *
	 * @param array $hierarchical_terms_array
	 * @param array $terms_array
	 * @param bool $hide_empty
	 * @param string $prefix
	 */
	private static function assemble_slug_name_array( Array $hierarchical_terms_array, array &$terms_array, bool $hide_empty = false, string $prefix = '' ) {
		if ( ! empty( $hierarchical_terms_array ) ) {
			foreach ( $hierarchical_terms_array as $term ) {
				if ( $hide_empty && empty( $term['count'] ) ) {
					continue;   // skip the iteration if hide empty is true and current term's count is 0
				}
				$terms_array[ $term['slug'] ] = $prefix . $term['name'];
				If ( ! empty( $term['children'] ) ){
					self::assemble_slug_name_array( $term['children'], $terms_array, $hide_empty, '- ' . $prefix );
				}
			}
		}
	}

	/**
	 * Generate array containing key(slug) => value(name) pair from a hierarchical terms array.
	 *
	 * @param array $hierarchical_terms_array
	 * @param array $terms_array
	 * @param bool $hide_empty
	 * @param string $prefix
	 */
	private static function assemble_id_name_array( Array $hierarchical_terms_array, array &$terms_array, bool $hide_empty = false, string $prefix = '' ) {
		if ( ! empty( $hierarchical_terms_array ) ) {
			foreach ( $hierarchical_terms_array as $term ) {
				if ( $hide_empty && empty( $term['count'] ) ) {
					continue;   // skip the iteration if hide empty is true and current term's count is 0
				}
				$terms_array[ $term['term_id'] ] = $prefix . $term['name'];
				If ( ! empty( $term['children'] ) ){
					self::assemble_id_name_array( $term['children'], $terms_array, $hide_empty, '- ' . $prefix );
				}
			}
		}
	}

}
