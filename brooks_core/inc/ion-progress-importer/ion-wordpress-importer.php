<?php
if ( defined( 'WP_LOAD_IMPORTERS' ) )
	return;

// Load Importer API
require_once ABSPATH . 'wp-admin/includes/import.php';

if ( ! class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	if ( file_exists( $class_wp_importer ) )
		require $class_wp_importer;
}

// include WXR file parsers
require dirname( __FILE__ ) . '/parsers.php';

/**
 * WordPress Importer class for managing the import process of a WXR file
 *
 * @package WordPress
 * @subpackage Importer
 */
if ( class_exists( 'WP_Importer' ) ) {
class ION_WP_Import extends WP_Importer {
	var $max_wxr_version = 1.2; // max. supported WXR version

	var $id; // WXR attachment ID

	// information to import from WXR file
	var $version;
	var $authors = array();
	var $posts = array();
	var $terms = array();
	var $categories = array();
	var $tags = array();
	var $base_url = '';

	// mappings from old information to new
	var $processed_authors = array();
	var $author_mapping = array();
	var $processed_terms = array();
	var $processed_posts = array();
	var $post_orphans = array();
	var $processed_menu_items = array();
	var $menu_item_orphans = array();
	var $missing_menu_items = array();

    var $fetch_attachments = false;
    var $force_update = true;
	var $url_remap = array();
	var $featured_images = array();


	/**
	 * Retrieve authors from parsed WXR data
	 *
	 * Uses the provided author information from WXR 1.1 files
	 * or extracts info from each post for WXR 1.0 files
	 *
	 * @param array $import_data Data returned by a WXR parser
	 */
	function get_authors_from_import( $import_data ) {
		if ( ! empty( $import_data['authors'] ) ) {
			$this->authors = $import_data['authors'];
		// no author information, grab it from the posts
		} else {
			foreach ( $import_data['posts'] as $post ) {
				$login = sanitize_user( $post['post_author'], true );
				if ( empty( $login ) ) {
					printf( __( 'Failed to import author %s. Their posts will be attributed to the current user.', 'wordpress-importer' ), esc_html( $post['post_author'] ) );
					echo '<br />';
					continue;
				}

				if ( ! isset($this->authors[$login]) )
					$this->authors[$login] = array(
						'author_login' => $login,
						'author_display_name' => $post['post_author']
					);
			}
		}
	}


	/**
	 * Map old author logins to local user IDs based on decisions made
	 * in import options form. Can map to an existing user, create a new user
	 * or falls back to the current user in case of error with either of the previous
	 */
	function get_author_mapping() {
		if ( ! isset( $_POST['imported_authors'] ) )
			return;

		$create_users = $this->allow_create_users();

		foreach ( (array) $_POST['imported_authors'] as $i => $old_login ) {
			// Multisite adds strtolower to sanitize_user. Need to sanitize here to stop breakage in process_posts.
			$santized_old_login = sanitize_user( $old_login, true );
			$old_id = isset( $this->authors[$old_login]['author_id'] ) ? intval($this->authors[$old_login]['author_id']) : false;

			if ( ! empty( $_POST['user_map'][$i] ) ) {
				$user = get_userdata( intval($_POST['user_map'][$i]) );
				if ( isset( $user->ID ) ) {
					if ( $old_id )
						$this->processed_authors[$old_id] = $user->ID;
					$this->author_mapping[$santized_old_login] = $user->ID;
				}
			} else if ( $create_users ) {
				if ( ! empty($_POST['user_new'][$i]) ) {
					$user_id = wp_create_user( $_POST['user_new'][$i], wp_generate_password() );
				} else if ( $this->version != '1.0' ) {
					$user_data = array(
						'user_login' => $old_login,
						'user_pass' => wp_generate_password(),
						'user_email' => isset( $this->authors[$old_login]['author_email'] ) ? $this->authors[$old_login]['author_email'] : '',
						'display_name' => $this->authors[$old_login]['author_display_name'],
						'first_name' => isset( $this->authors[$old_login]['author_first_name'] ) ? $this->authors[$old_login]['author_first_name'] : '',
						'last_name' => isset( $this->authors[$old_login]['author_last_name'] ) ? $this->authors[$old_login]['author_last_name'] : '',
					);
					$user_id = wp_insert_user( $user_data );
				}

				if ( ! is_wp_error( $user_id ) ) {
					if ( $old_id )
						$this->processed_authors[$old_id] = $user_id;
					$this->author_mapping[$santized_old_login] = $user_id;
				} else {
					printf( __( 'Failed to create new user for %s. Their posts will be attributed to the current user.', 'wordpress-importer' ), esc_html($this->authors[$old_login]['author_display_name']) );
					if ( defined('IMPORT_DEBUG') && IMPORT_DEBUG )
						echo ' ' . $user_id->get_error_message();
					echo '<br />';
				}
			}

			// failsafe: if the user_id was invalid, default to the current user
			if ( ! isset( $this->author_mapping[$santized_old_login] ) ) {
				if ( $old_id )
					$this->processed_authors[$old_id] = (int) get_current_user_id();
				$this->author_mapping[$santized_old_login] = (int) get_current_user_id();
			}
		}
	}

	/**
	 * Create new categories based on import information
	 *
	 * Doesn't create a new category if its slug already exists
	 */
	function process_categories() {
		$this->categories = apply_filters( 'wp_import_categories', $this->categories );

		if ( empty( $this->categories ) )
			return;

		foreach ( $this->categories as $cat ) {
			// if the category already exists leave it alone
			$term_id = term_exists( $cat['category_nicename'], 'category' );
			if ( $term_id ) {
				if ( is_array($term_id) ) $term_id = $term_id['term_id'];
				if ( isset($cat['term_id']) )
					$this->processed_terms[intval($cat['term_id'])] = (int) $term_id;
				continue;
			}

			$category_parent = empty( $cat['category_parent'] ) ? 0 : category_exists( $cat['category_parent'] );
			$category_description = isset( $cat['category_description'] ) ? $cat['category_description'] : '';
			$catarr = array(
				'category_nicename' => $cat['category_nicename'],
				'category_parent' => $category_parent,
				'cat_name' => $cat['cat_name'],
				'category_description' => $category_description
			);

            if($this->force_update) {
                global $wpdb;
                $catarr['cat_ID'] = $cat['term_id'];
                if(!get_term( $catarr['cat_ID'], 'category' )) {
                    $wpdb->insert( $wpdb->terms, array('term_id' => $catarr['cat_ID'], 'name' => 'ion-temp-term', 'slug' => 'ion-temp-term') );
                    $wpdb->insert( $wpdb->term_taxonomy, array('term_id' => $catarr['cat_ID'], 'term_taxonomy_id' => $catarr['cat_ID'], 'taxonomy' => 'category') );
                }
            }

			$catarr = wp_slash( $catarr );

			$id = wp_insert_category( $catarr );
            $id = isset($id['term_id'])?$id['term_id']:$id;


			if ( ! is_wp_error( $id ) ) {
				if ( isset($cat['term_id']) )
					$this->processed_terms[intval($cat['term_id'])] = $id;
			} else {
				printf( __( 'Failed to import category %s', 'wordpress-importer' ), esc_html($cat['category_nicename']) );
				if ( defined('IMPORT_DEBUG') && IMPORT_DEBUG )
					echo ': ' . $id->get_error_message();
				echo '<br />';
				continue;
			}

			$this->process_termmeta( $cat, $id['term_id'] );
		}

		unset( $this->categories );
	}

	/**
	 * Create new post tags based on import information
	 *
	 * Doesn't create a tag if its slug already exists
	 */
	function process_tags() {
		$this->tags = apply_filters( 'wp_import_tags', $this->tags );

		if ( empty( $this->tags ) )
			return;

		foreach ( $this->tags as $tag ) {
			// if the tag already exists leave it alone
			$term_id = term_exists( $tag['tag_slug'], 'post_tag' );
			if ( $term_id ) {
				if ( is_array($term_id) ) $term_id = $term_id['term_id'];
				if ( isset($tag['term_id']) )
					$this->processed_terms[intval($tag['term_id'])] = (int) $term_id;
				continue;
			}

			$tag = wp_slash( $tag );
			$tag_desc = isset( $tag['tag_description'] ) ? $tag['tag_description'] : '';
			$tagarr = array( 'slug' => $tag['tag_slug'], 'description' => $tag_desc, 'name' => $tag['tag_name'] );

            if($this->force_update) {
                $tagarr['term_id'] = $tag['term_id'];
                if(!get_term( $tagarr['term_id'], 'post_tag' )) {
                    global $wpdb;
                    $wpdb->insert( $wpdb->terms, array('term_id' => $tagarr['term_id'], 'name' => 'ion-temp-term', 'slug' => 'ion-temp-term') );
                    $wpdb->insert( $wpdb->term_taxonomy, array('term_id' => $tagarr['term_id'], 'term_taxonomy_id' => $tagarr['term_id'], 'taxonomy' => 'post_tag') );
                }

                $id = wp_update_term( $tagarr['term_id'], 'post_tag', $tagarr );
            } else
			    $id = wp_insert_term( $tag['tag_name'], 'post_tag', $tagarr );

			if ( ! is_wp_error( $id ) ) {
                $id = isset($id['term_id'])?$id['term_id']:$id;

				if ( isset($tag['term_id']) )
					$this->processed_terms[intval($tag['term_id'])] = $id['term_id'];
			} else {
				printf( __( 'Failed to import post tag %s', 'wordpress-importer' ), esc_html($tag['tag_name']) );
				if ( defined('IMPORT_DEBUG') && IMPORT_DEBUG )
					echo ': ' . $id->get_error_message();
				echo '<br />';
				continue;
			}

			$this->process_termmeta( $tag, $id['term_id'] );
		}

		unset( $this->tags );
	}

	/**
	 * Create new terms based on import information
	 *
	 * Doesn't create a term its slug already exists
	 */
	function process_terms() {
		$this->terms = apply_filters( 'wp_import_terms', $this->terms );

		if ( empty( $this->terms ) )
			return;

		foreach ( $this->terms as $term ) {
			// if the term already exists in the correct taxonomy leave it alone
			$term_id = term_exists( $term['slug'], $term['term_taxonomy'] );
			if ( $term_id ) {
				if ( is_array($term_id) ) $term_id = $term_id['term_id'];
				if ( isset($term['term_id']) )
					$this->processed_terms[intval($term['term_id'])] = (int) $term_id;
				continue;
			}

			if ( empty( $term['term_parent'] ) ) {
				$parent = 0;
			} else {
				$parent = term_exists( $term['term_parent'], $term['term_taxonomy'] );
				if ( is_array( $parent ) ) $parent = $parent['term_id'];
			}
			$term = wp_slash( $term );
			$description = isset( $term['term_description'] ) ? $term['term_description'] : '';
			$termarr = array( 'name' => $term['term_name'], 'slug' => $term['slug'], 'description' => $description, 'parent' => intval($parent) );

            if($this->force_update) {
                $termarr['term_id'] = $term['term_id'];
                if(!get_term( $termarr['term_id'], $term['term_taxonomy'] )) {
                    global $wpdb;
                    $wpdb->insert( $wpdb->terms, array('term_id' => $termarr['term_id'], 'name' => 'ion-temp-term', 'slug' => 'ion-temp-term') );
                    $wpdb->insert( $wpdb->term_taxonomy, array('term_id' => $termarr['term_id'], 'term_taxonomy_id' => $termarr['term_id'], 'taxonomy' => $term['term_taxonomy']) );
                }

                $id = wp_update_term( $term['term_id'], $term['term_taxonomy'], $termarr );
            } else
			    $id = wp_insert_term( $term['term_name'], $term['term_taxonomy'], $termarr );


			if ( ! is_wp_error( $id ) ) {
                $id = isset($id['term_id'])?$id['term_id']:$id;

				if ( isset($term['term_id']) )
					$this->processed_terms[intval($term['term_id'])] = $id['term_id'];
			} else {
				printf( __( 'Failed to import %s %s', 'wordpress-importer' ), esc_html($term['term_taxonomy']), esc_html($term['term_name']) );
				if ( defined('IMPORT_DEBUG') && IMPORT_DEBUG )
					echo ': ' . $id->get_error_message();
				echo '<br />';
				continue;
			}

			$this->process_termmeta( $term, $id['term_id'] );
		}

		unset( $this->terms );
	}

	/**
	 * Add metadata to imported term.
	 *
	 * @since 0.6.2
	 *
	 * @param array $term    Term data from WXR import.
	 * @param int   $term_id ID of the newly created term.
	 */
	protected function process_termmeta( $term, $term_id ) {
		if ( ! isset( $term['termmeta'] ) ) {
			$term['termmeta'] = array();
		}

		/**
		 * Filters the metadata attached to an imported term.
		 *
		 * @since 0.6.2
		 *
		 * @param array $termmeta Array of term meta.
		 * @param int   $term_id  ID of the newly created term.
		 * @param array $term     Term data from the WXR import.
		 */
		$term['termmeta'] = apply_filters( 'wp_import_term_meta', $term['termmeta'], $term_id, $term );

		if ( empty( $term['termmeta'] ) ) {
			return;
		}

		foreach ( $term['termmeta'] as $meta ) {
			/**
			 * Filters the meta key for an imported piece of term meta.
			 *
			 * @since 0.6.2
			 *
			 * @param string $meta_key Meta key.
			 * @param int    $term_id  ID of the newly created term.
			 * @param array  $term     Term data from the WXR import.
			 */
			$key = apply_filters( 'import_term_meta_key', $meta['key'], $term_id, $term );
			if ( ! $key ) {
				continue;
			}

			// Export gets meta straight from the DB so could have a serialized string
			$value = maybe_unserialize( $meta['value'] );

			add_term_meta( $term_id, $key, $value );

			/**
			 * Fires after term meta is imported.
			 *
			 * @since 0.6.2
			 *
			 * @param int    $term_id ID of the newly created term.
			 * @param string $key     Meta key.
			 * @param mixed  $value   Meta value.
			 */
			do_action( 'import_term_meta', $term_id, $key, $value );
		}
	}

	/**
	 * Create new posts based on import information
	 *
	 * Posts marked as having a parent which doesn't exist will become top level items.
	 * Doesn't create a new post if: the post type doesn't exist, the given post ID
	 * is already noted as imported or a post with the same title and date already exists.
	 * Note that new/updated terms, comments and meta are imported for the last of the above.
	 */
	function process_posts() {
		$this->posts = apply_filters( 'wp_import_posts', $this->posts );

		foreach ( $this->posts as $post ) {
			$post = apply_filters( 'wp_import_post_data_raw', $post );

			if ( ! post_type_exists( $post['post_type'] ) ) {
				printf( __( 'Failed to import &#8220;%s&#8221;: Invalid post type %s', 'wordpress-importer' ),
					esc_html($post['post_title']), esc_html($post['post_type']) );
				echo '<br />';
				do_action( 'wp_import_post_exists', $post );
				continue;
			}

			if ( isset( $this->processed_posts[$post['post_id']] ) && ! empty( $post['post_id'] ) )
				continue;

			if ( $post['status'] == 'auto-draft' )
				continue;

			if ( 'nav_menu_item' == $post['post_type'] ) {
				$this->process_menu_item( $post );
				continue;
			}

			$post_type_object = get_post_type_object( $post['post_type'] );

			$post_exists = post_exists( $post['post_title'], '', $post['post_date'] );

			/**
			* Filter ID of the existing post corresponding to post currently importing.
			*
			* Return 0 to force the post to be imported. Filter the ID to be something else
			* to override which existing post is mapped to the imported post.
			*
			* @see post_exists()
			* @since 0.6.2
			*
			* @param int   $post_exists  Post ID, or 0 if post did not exist.
			* @param array $post         The post array to be inserted.
			*/
			$post_exists = apply_filters( 'wp_import_existing_post', $post_exists, $post );

			if ( $post_exists && get_post_type( $post_exists ) == $post['post_type'] ) {
				printf( __('%s &#8220;%s&#8221; already exists.', 'wordpress-importer'), $post_type_object->labels->singular_name, esc_html($post['post_title']) );
				echo '<br />';
				$comment_post_ID = $post_id = $post_exists;
				$this->processed_posts[ intval( $post['post_id'] ) ] = intval( $post_exists );
			} else {
				$post_parent = (int) $post['post_parent'];
				if ( $post_parent ) {
					// if we already know the parent, map it to the new local ID
					if ( isset( $this->processed_posts[$post_parent] ) ) {
						$post_parent = $this->processed_posts[$post_parent];
					// otherwise record the parent for later
					} else {
						$this->post_orphans[intval($post['post_id'])] = $post_parent;
						$post_parent = 0;
					}
				}

				// map the post author
				$author = sanitize_user( $post['post_author'], true );
				if ( isset( $this->author_mapping[$author] ) )
					$author = $this->author_mapping[$author];
				else
					$author = (int) get_current_user_id();

				$postdata = array(
					'import_id' => $post['post_id'], 'post_author' => $author, 'post_date' => $post['post_date'],
					'post_date_gmt' => $post['post_date_gmt'], 'post_content' => $post['post_content'],
					'post_excerpt' => $post['post_excerpt'], 'post_title' => $post['post_title'],
					'post_status' => $post['status'], 'post_name' => $post['post_name'],
					'comment_status' => $post['comment_status'], 'ping_status' => $post['ping_status'],
					'guid' => $post['guid'], 'post_parent' => $post_parent, 'menu_order' => $post['menu_order'],
					'post_type' => $post['post_type'], 'post_password' => $post['post_password']
				);

                if($this->force_update) {
                    $postdata['ID'] = $post['post_id'];
                    if(!get_post( $postdata['ID'] )) {
                        global $wpdb;
                        $wpdb->insert( $wpdb->posts, array('ID' => $postdata['ID'], 'post_type' => $postdata['post_type']) );
                    }
                }

				$original_post_ID = $post['post_id'];
				$postdata = apply_filters( 'wp_import_post_data_processed', $postdata, $post );

				$postdata = wp_slash( $postdata );

				if ( 'attachment' == $postdata['post_type'] ) {
					$remote_url = ! empty($post['attachment_url']) ? $post['attachment_url'] : $post['guid'];

					// try to use _wp_attached file for upload folder placement to ensure the same location as the export site
					// e.g. location is 2003/05/image.jpg but the attachment post_date is 2010/09, see media_handle_upload()
					$postdata['upload_date'] = $post['post_date'];
					if ( isset( $post['postmeta'] ) ) {
						foreach( $post['postmeta'] as $meta ) {
							if ( $meta['key'] == '_wp_attached_file' ) {
								if ( preg_match( '%^[0-9]{4}/[0-9]{2}%', $meta['value'], $matches ) )
									$postdata['upload_date'] = $matches[0];
								break;
							}
						}
					}

					$comment_post_ID = $post_id = $this->process_attachment( $postdata, $remote_url );
				} else {
					$comment_post_ID = $post_id = wp_insert_post( $postdata, true );
					do_action( 'wp_import_insert_post', $post_id, $original_post_ID, $postdata, $post );
				}

				if ( is_wp_error( $post_id ) ) {
					printf( __( 'Failed to import %s &#8220;%s&#8221;', 'wordpress-importer' ),
						$post_type_object->labels->singular_name, esc_html($post['post_title']) );
					if ( defined('IMPORT_DEBUG') && IMPORT_DEBUG )
						echo ': ' . $post_id->get_error_message();
					echo '<br />';
					continue;
				}

				if ( $post['is_sticky'] == 1 )
					stick_post( $post_id );
			}

			// map pre-import ID to local ID
			$this->processed_posts[intval($post['post_id'])] = (int) $post_id;

			if ( ! isset( $post['terms'] ) )
				$post['terms'] = array();

			$post['terms'] = apply_filters( 'wp_import_post_terms', $post['terms'], $post_id, $post );

			// add categories, tags and other terms
			if ( ! empty( $post['terms'] ) ) {
				$terms_to_set = array();
				foreach ( $post['terms'] as $term ) {
					// back compat with WXR 1.0 map 'tag' to 'post_tag'
					$taxonomy = ( 'tag' == $term['domain'] ) ? 'post_tag' : $term['domain'];
					$term_exists = term_exists( $term['slug'], $taxonomy );
					$term_id = is_array( $term_exists ) ? $term_exists['term_id'] : $term_exists;
					if ( ! $term_id ) {
						$t = wp_insert_term( $term['name'], $taxonomy, array( 'slug' => $term['slug'] ) );
						if ( ! is_wp_error( $t ) ) {
							$term_id = $t['term_id'];
							do_action( 'wp_import_insert_term', $t, $term, $post_id, $post );
						} else {
							printf( __( 'Failed to import %s %s', 'wordpress-importer' ), esc_html($taxonomy), esc_html($term['name']) );
							if ( defined('IMPORT_DEBUG') && IMPORT_DEBUG )
								echo ': ' . $t->get_error_message();
							echo '<br />';
							do_action( 'wp_import_insert_term_failed', $t, $term, $post_id, $post );
							continue;
						}
					}
					$terms_to_set[$taxonomy][] = intval( $term_id );
				}

				foreach ( $terms_to_set as $tax => $ids ) {
					$tt_ids = wp_set_post_terms( $post_id, $ids, $tax );
					do_action( 'wp_import_set_post_terms', $tt_ids, $ids, $tax, $post_id, $post );
				}
				unset( $post['terms'], $terms_to_set );
			}

			if ( ! isset( $post['comments'] ) )
				$post['comments'] = array();

			$post['comments'] = apply_filters( 'wp_import_post_comments', $post['comments'], $post_id, $post );

			// add/update comments
			if ( ! empty( $post['comments'] ) ) {
				$num_comments = 0;
				$inserted_comments = array();
				foreach ( $post['comments'] as $comment ) {
					$comment_id	= $comment['comment_id'];
					$newcomments[$comment_id]['comment_post_ID']      = $comment_post_ID;
					$newcomments[$comment_id]['comment_author']       = $comment['comment_author'];
					$newcomments[$comment_id]['comment_author_email'] = $comment['comment_author_email'];
					$newcomments[$comment_id]['comment_author_IP']    = $comment['comment_author_IP'];
					$newcomments[$comment_id]['comment_author_url']   = $comment['comment_author_url'];
					$newcomments[$comment_id]['comment_date']         = $comment['comment_date'];
					$newcomments[$comment_id]['comment_date_gmt']     = $comment['comment_date_gmt'];
					$newcomments[$comment_id]['comment_content']      = $comment['comment_content'];
					$newcomments[$comment_id]['comment_approved']     = $comment['comment_approved'];
					$newcomments[$comment_id]['comment_type']         = $comment['comment_type'];
					$newcomments[$comment_id]['comment_parent'] 	  = $comment['comment_parent'];
					$newcomments[$comment_id]['commentmeta']          = isset( $comment['commentmeta'] ) ? $comment['commentmeta'] : array();
					if ( isset( $this->processed_authors[$comment['comment_user_id']] ) )
						$newcomments[$comment_id]['user_id'] = $this->processed_authors[$comment['comment_user_id']];
				}
				ksort( $newcomments );

				foreach ( $newcomments as $key => $comment ) {
					// if this is a new post we can skip the comment_exists() check
					if ( ! $post_exists || ! comment_exists( $comment['comment_author'], $comment['comment_date'] ) ) {
						if ( isset( $inserted_comments[$comment['comment_parent']] ) )
							$comment['comment_parent'] = $inserted_comments[$comment['comment_parent']];
						$comment = wp_filter_comment( $comment );
						$inserted_comments[$key] = wp_insert_comment( $comment );
						do_action( 'wp_import_insert_comment', $inserted_comments[$key], $comment, $comment_post_ID, $post );

						foreach( $comment['commentmeta'] as $meta ) {
							$value = maybe_unserialize( $meta['value'] );
							add_comment_meta( $inserted_comments[$key], $meta['key'], $value );
						}

						$num_comments++;
					}
				}
				unset( $newcomments, $inserted_comments, $post['comments'] );
			}

			if ( ! isset( $post['postmeta'] ) )
				$post['postmeta'] = array();

			$post['postmeta'] = apply_filters( 'wp_import_post_meta', $post['postmeta'], $post_id, $post );

			// add/update post meta
			if ( ! empty( $post['postmeta'] ) ) {
				foreach ( $post['postmeta'] as $meta ) {
					$key = apply_filters( 'import_post_meta_key', $meta['key'], $post_id, $post );
					$value = false;

					if ( '_edit_last' == $key ) {
						if ( isset( $this->processed_authors[intval($meta['value'])] ) )
							$value = $this->processed_authors[intval($meta['value'])];
						else
							$key = false;
					}

					if ( $key ) {
						// export gets meta straight from the DB so could have a serialized string
						if ( ! $value )
							$value = maybe_unserialize( $meta['value'] );

						add_post_meta( $post_id, $key, $value );
						do_action( 'import_post_meta', $post_id, $key, $value );

						// if the post has a featured image, take note of this in case of remap
						if ( '_thumbnail_id' == $key )
							$this->featured_images[$post_id] = (int) $value;
					}
				}
			}
		}

		unset( $this->posts );
	}

    /**
     * Attempt to create a new menu item from import data
     *
     * Fails for draft, orphaned menu items and those without an associated nav_menu
     * or an invalid nav_menu term. If the post type or term object which the menu item
     * represents doesn't exist then the menu item will not be imported (waits until the
     * end of the import to retry again before discarding).
     *
     * @param array $item Menu item details from WXR file
     * @return bool
     */
	function process_menu_item( $item, $backfill = false ) {
		// skip draft, orphaned menu items
		if ( 'draft' == $item['status'] )
			return true;

		$menu_slug = false;
		if ( isset($item['terms']) ) {
			// loop through terms, assume first nav_menu term is correct menu
			foreach ( $item['terms'] as $term ) {
				if ( 'nav_menu' == $term['domain'] ) {
					$menu_slug = $term['slug'];
					break;
				}
			}
		}

		// no nav_menu term associated with this menu item
		if ( ! $menu_slug ) {
			_e( 'Menu item skipped due to missing menu slug', 'wordpress-importer' );
			echo '<br />';
			return true;
		}

		$menu_id = term_exists( $menu_slug, 'nav_menu' );
		if ( ! $menu_id ) {
			printf( __( 'Menu item skipped due to invalid menu slug: %s', 'wordpress-importer' ), esc_html( $menu_slug ) );
			echo '<br />';
			return true;
		} else {
			$menu_id = is_array( $menu_id ) ? $menu_id['term_id'] : $menu_id;
		}

		foreach ( $item['postmeta'] as $meta )
			$$meta['key'] = $meta['value'];

        if ('taxonomy' == $_menu_item_type && isset($this->processed_terms[intval($_menu_item_object_id)])) {
            $_menu_item_object_id = $this->processed_terms[intval($_menu_item_object_id)];
        } elseif ('post_type' == $_menu_item_type && isset($this->processed_posts[intval($_menu_item_object_id)])) {
            $_menu_item_object_id = $this->processed_posts[intval($_menu_item_object_id)];
        } elseif ('custom' != $_menu_item_type && !$backfill) {
            // associated object is missing or not imported yet, we'll retry later
            $this->missing_menu_items[] = $item;
            return false;
        } elseif($backfill)
            return true;

        if (isset($this->processed_menu_items[intval($_menu_item_menu_item_parent)])) {
            $_menu_item_menu_item_parent = $this->processed_menu_items[intval($_menu_item_menu_item_parent)];
        } else if ($_menu_item_menu_item_parent) {
            $this->menu_item_orphans[intval($item['post_id'])] = (int)$_menu_item_menu_item_parent;
            $_menu_item_menu_item_parent = 0;
        }

		// wp_update_nav_menu_item expects CSS classes as a space separated string
		$_menu_item_classes = maybe_unserialize( $_menu_item_classes );
		if ( is_array( $_menu_item_classes ) )
			$_menu_item_classes = implode( ' ', $_menu_item_classes );

		$args = array(
			'menu-item-object-id' => $_menu_item_object_id,
			'menu-item-object' => $_menu_item_object,
			'menu-item-parent-id' => $_menu_item_menu_item_parent,
			'menu-item-position' => intval( $item['menu_order'] ),
			'menu-item-type' => $_menu_item_type,
			'menu-item-title' => $item['post_title'],
			'menu-item-url' => $_menu_item_url,
			'menu-item-description' => $item['post_content'],
			'menu-item-attr-title' => $item['post_excerpt'],
			'menu-item-target' => $_menu_item_target,
			'menu-item-classes' => $_menu_item_classes,
			'menu-item-xfn' => $_menu_item_xfn,
			'menu-item-status' => $item['status']
		);

		$id = wp_update_nav_menu_item( $menu_id, 0, $args );
		if ( $id && ! is_wp_error( $id ) ) {
            $this->processed_menu_items[intval($item['post_id'])] = (int)$id;
            return true;
        }
	}

	/**
	 * If fetching attachments is enabled then attempt to create a new attachment
	 *
	 * @param array $post Attachment post details from WXR
	 * @param string $url URL to fetch attachment from
	 * @return int|WP_Error Post ID on success, WP_Error otherwise
	 */
	function process_attachment( $post, $url ) {
		if ( ! $this->fetch_attachments )
			return new WP_Error( 'attachment_processing_error',
				__( 'Fetching attachments is not enabled', 'wordpress-importer' ) );

		// if the URL is absolute, but does not contain address, then upload it assuming base_site_url
		if ( preg_match( '|^/[\w\W]+$|', $url ) )
			$url = rtrim( $this->base_url, '/' ) . $url;

		$upload = $this->fetch_remote_file( $url, $post );
		if ( is_wp_error( $upload ) )
			return $upload;

		if ( $info = wp_check_filetype( $upload['file'] ) )
			$post['post_mime_type'] = $info['type'];
		else
			return new WP_Error( 'attachment_processing_error', __('Invalid file type', 'wordpress-importer') );

		$post['guid'] = $upload['url'];

		// as per wp-admin/includes/upload.php
		$post_id = wp_insert_attachment( $post, $upload['file'] );

		wp_update_attachment_metadata( $post_id, wp_generate_attachment_metadata( $post_id, $upload['file'] ) );

		// remap resized image URLs, works by stripping the extension and remapping the URL stub.
		if ( preg_match( '!^image/!', $info['type'] ) ) {
			$parts = pathinfo( $url );
			$name = basename( $parts['basename'], ".{$parts['extension']}" ); // PATHINFO_FILENAME in PHP 5.2

			$parts_new = pathinfo( $upload['url'] );
			$name_new = basename( $parts_new['basename'], ".{$parts_new['extension']}" );

			$this->url_remap[$parts['dirname'] . '/' . $name] = $parts_new['dirname'] . '/' . $name_new;
		}

		return $post_id;
	}

	/**
	 * Attempt to download a remote file attachment
	 *
	 * @param string $url URL of item to fetch
	 * @param array $post Attachment details
	 * @return array|WP_Error Local file location details on success, WP_Error otherwise
	 */
    function fetch_remote_file( $url, $post ) {
        // extract the file name and extension from the url
        $file_name = basename( $url );

        // get placeholder file in the upload dir with a unique, sanitized filename
        $upload = wp_upload_bits( $file_name, 0, '', $post['upload_date'] );
        if ( $upload['error'] )
            return new WP_Error( 'upload_dir_error', $upload['error'] );

        // fetch the remote url and write it to the placeholder file
        $response = wp_remote_get( $url, array(
            'stream' => true,
            'filename' => $upload['file']
        ) );

        // request failed
        if ( is_wp_error( $response ) ) {
            @unlink( $upload['file'] );
            return $response;
        }

        $code = (int) wp_remote_retrieve_response_code( $response );

        // make sure the fetch was successful
        if ( $code !== 200 ) {
            @unlink( $upload['file'] );
            return new WP_Error(
                'import_file_error',
                sprintf(
                    __('Remote server returned %1$d %2$s for %3$s', 'wordpress-importer'),
                    $code,
                    get_status_header_desc( $code ),
                    $url
                )
            );
        }

        $filesize = filesize( $upload['file'] );
        $headers = wp_remote_retrieve_headers( $response );

        if ( isset( $headers['content-length'] ) && $filesize != $headers['content-length'] ) {
            @unlink( $upload['file'] );
            return new WP_Error( 'import_file_error', __('Remote file is incorrect size', 'wordpress-importer') );
        }

        if ( 0 == $filesize ) {
            @unlink( $upload['file'] );
            return new WP_Error( 'import_file_error', __('Zero size file downloaded', 'wordpress-importer') );
        }

        $max_size = (int) $this->max_attachment_size();
        if ( ! empty( $max_size ) && $filesize > $max_size ) {
            @unlink( $upload['file'] );
            return new WP_Error( 'import_file_error', sprintf(__('Remote file is too large, limit is %s', 'wordpress-importer'), size_format($max_size) ) );
        }

        // keep track of the old and new urls so we can substitute them later
        $this->url_remap[$url] = $upload['url'];
        $this->url_remap[$post['guid']] = $upload['url']; // r13735, really needed?
        // keep track of the destination if the remote url is redirected somewhere else
        if ( isset($headers['x-final-location']) && $headers['x-final-location'] != $url ){
            $this->url_remap[$headers['x-final-location']] = $upload['url'];
        }

        return $upload;
    }


	/**
	 * Parse a WXR file
	 *
	 * @param string $file Path to WXR file for parsing
	 * @return array Information gathered from the WXR file
	 */
	function parse( $file ) {
		$parser = new WXR_Parser();
		return $parser->parse( $file );
	}


	/**
	 * Decide if the given meta key maps to information we will want to import
	 *
	 * @param string $key The meta key to check
	 * @return string|bool The key if we do want to import, false if not
	 */
	function is_valid_meta_key( $key ) {
		// skip attachment metadata since we'll regenerate it from scratch
		// skip _edit_lock as not relevant for import
		if ( in_array( $key, array( '_wp_attached_file', '_wp_attachment_metadata', '_edit_lock' ) ) )
			return false;
		return $key;
	}

	/**
	 * Decide whether or not the importer is allowed to create users.
	 * Default is true, can be filtered via import_allow_create_users
	 *
	 * @return bool True if creating users is allowed
	 */
	function allow_create_users() {
		return apply_filters( 'import_allow_create_users', true );
	}


	/**
	 * Decide what the maximum file size for downloaded attachments is.
	 * Default is 0 (unlimited), can be filtered via import_attachment_size_limit
	 *
	 * @return int Maximum attachment file size to import
	 */
	function max_attachment_size() {
		return apply_filters( 'import_attachment_size_limit', 0 );
	}

	/**
	 * Added to http_request_timeout filter to force timeout at 60 seconds during import
	 * @return int 60
	 */
	function bump_request_timeout( $val ) {
		return 60;
	}

	// return the difference in length between two strings
	function cmpr_strlen( $a, $b ) {
		return strlen($b) - strlen($a);
	}
}

} // class_exists( 'WP_Importer' )
