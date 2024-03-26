<?php

class Brooks_Walker_Nav_Menu extends Walker_Nav_Menu {
	private $center_item_id = 0;
	// add classes to ul sub-menus
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul role=\"menu\" class=\" dropdown__content depth-$depth \" ".($args->parent_dropdown_id?(' id="'.$args->parent_dropdown_id.'"'):''). ">\n";
	}

	// add main/sub classes to li's and links
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} else if ( strcasecmp( $item->title, 'divider') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} else if ( strcasecmp( $item->attr_title, 'dropdown-header') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );
		} else if ( strcasecmp($item->attr_title, 'disabled' ) == 0 ) {
			$output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';
		} else {

			$class_names = $value = '';

			$classes = empty($item->classes) ? array() : (array)$item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));

			if ($args->has_children)
				$class_names .= ' dropdown';

			if (in_array('current-menu-item', $classes) )
				$class_names .= ' active';


			$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
			$id = $id ? ' id="' . esc_attr($id) . '"' : '';

			//menu type class
			$childrens = '';
			$menu_type = '';
			if ($depth == 0) {
				if ($item->type_menu == "wide") {
					if ($args->has_children) {
						$childrens = ' brooks__count__childrens_' . count($args->childrens);

					}
					$menu_type = " brooks__wide";
				} else {
					$menu_type = " brooks__narrow";
				}
			}

			$anchor = '';
			if ($item->anchor != "") {
				$anchor = '#' . esc_attr($item->anchor);
			}
			$no_link_class = '';
			if ($item->nolink != '') {
				$no_link_class = ' no_link';
			}
			$hide = '';
			if ($item->hide != "") {
				$hide = " hide_elem";
			}
			$badge = '';
			if($item->featured_badge) {
				$badge = '<span class="menu__badge">' . $item->featured_badge . '</span>';
			}
			$iconhtml = '';
			if ($item->icon_pack) {
				$icon = $item->icon;
				brooks_icon_collections()->enqueueStyles();
				if ($item->icon_pack == 'font_awesome') {
					$icon .= ' fa';
				}
				$iconhtml = '<i class=" ' . $icon . '" aria-hidden="true"></i>';
			}

			$sidebar_content = '';
			if ($item->sidebar != "" && $depth > 0) {
				ob_start();
				dynamic_sidebar($item->sidebar);
				$sidebar_content = ob_get_contents();
				ob_end_clean();

			}
			$output .= $indent . '<li' . $id . $value . 'class="' . $class_names . $menu_type . $hide . $childrens . '"">';

				$atts = array();
				$atts['title'] = !empty($item->title) ? $item->title : '';
				$atts['target'] = !empty($item->target) ? $item->target : '';
				$atts['rel'] = !empty($item->xfn) ? $item->xfn : '';

				// If item has_children add atts to a.
				$parent_dropdown_id = '';
				if ($args->has_children) {
					$parent_dropdown_id = 'dropdown-' . brooks_get_unique_id();
					$atts['href'] = (!empty($item->url)) ? (trim(esc_url($item->url),'/') . '/' . $anchor) : (($item->nolink != '') ? '' : $anchor );
					$atts['data-activates'] = $parent_dropdown_id;
					$atts['class'] = 'dropdown__menu' . $no_link_class;
				} else {
					$atts['href'] = (!empty($item->url)) ? (trim(esc_url($item->url),'/') .'/'.  $anchor) : (($item->nolink != '') ? '' : $anchor );
				}

				$args->parent_dropdown_id = $parent_dropdown_id;


				$atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

				$attributes = '';
				foreach ($atts as $attr => $value) {
					if (!empty($value)) {
						$value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
						$attributes .= ' ' . $attr . '="' . $value . '"';
					}
				}
				if ($item->sidebar != "" && $depth > 0) {

					$item_output = $sidebar_content;

				}else{

				$item_output = $args->before;


				if (!(empty($item->attr_title)))
					$item_output .= '<a' . $attributes . '>' . $iconhtml . '<span class="glyphicon ' . esc_attr($item->attr_title) . '"></span>&nbsp;';
				else
					$item_output .= '<a' . $attributes . '>' . $iconhtml;


					$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
					$item_output .= ($args->has_children)
						? ' <i class="bicon bi-carret-down" aria-hidden="true"></i>' . $badge . $sidebar_content . '</a>'
						: $badge . $sidebar_content . '</a>';
					$item_output .= $args->after;
				}

			$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);

		}
	}


	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output )
	{
		if (!$element)
			return;

		$id_field = $this->db_fields['id'];

		// Display this element.
		if (is_object($args[0])) {

		$args[0]->has_children = !empty($children_elements[$element->$id_field]);
			if($args[0]->has_children) {
				$args[0]->childrens = $children_elements[$element->$id_field];
			}
		}
		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	public static function fallback( $args ) {
		if ( current_user_can( 'manage_options' ) ) {
			$container = $container_id = $container_class = $menu_id = $menu_class = '';

			extract( $args );

			$fb_output = null;

			if ( $container ) {
				$fb_output = '<' . $container;

				if ( $container_id )
					$fb_output .= ' id="' . $container_id . '"';

				if ( $container_class )
					$fb_output .= ' class="' . $container_class . '"';

				$fb_output .= '>';
			}

			$fb_output .= '<ul';

			if ( $menu_id )
				$fb_output .= ' id="' . $menu_id . '"';

			if ( $menu_class )
				$fb_output .= ' class="' . $menu_class . '"';

			$fb_output .= '>';
			$fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">Add a menu</a></li>';
			$fb_output .= '</ul>';

			if ( $container )
				$fb_output .= '</' . $container . '>';

			echo $fb_output;
		}
	}

	private function get_center_item_id($items) {
		$cnt = $this->get_number_of_root_elements($items);
		$mid = ceil($cnt/2);
		$i = 0;

		foreach($items as $item) {
			if($item->menu_item_parent == 0) {
				$i++;
				if($i == $mid) {
					$this->center_item_id = $item->ID;
					break;
				}
			}
		}
	}

    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
        $output .= "</li>\n";


        if(isset($args->center_logo) && $args->center_logo == true ) {
            if (!$this->center_item_id)
                $this->get_center_item_id(wp_get_nav_menu_items($args->menu));

            if ($item->ID == $this->center_item_id) {
                $logo_src = (Brooks_Theme_Options::getData('logo') != '') ? wp_get_attachment_image_url(Brooks_Theme_Options::getData('logo', true), 'thumbnail') : BROOKS_IMAGES . '/logo.png';

                $output .= '<li class="main-logo"><a class="navbar-main-logo" href="' . esc_url(home_url('/')) . '">';
                $output .= '    <img src="' . $logo_src . '" alt="' . get_bloginfo('name') . '">';

                if (Brooks_Theme_Options::getData('alt_logo'))
                    $logo_src = wp_get_attachment_image_url(Brooks_Theme_Options::getData('alt_logo', true), 'full');

                $output .= '    <img class="alt__logo" src="' . $logo_src . '" alt="' . get_bloginfo('name') . '">';
                $output .= '    </a>';
                $output .= '</li>';
            }
        }
    }
}