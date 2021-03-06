<?php

/**
 * A class of methods using hooks in the theme.
 *
 * @package TCB_Landing
 * @author Slushman <chris@slushman.com>
 */
class tcb_landing_Themehooks {

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->loader();

	} // __construct()

	/**
	 * Loads all filter and action calls
	 */
	private function loader() {

		add_action( 'tha_header_top', 					array( $this, 'header_wrap_start' ), 10 );
		add_action( 'tha_header_top', 					array( $this, 'site_branding_start' ), 15 );

		add_action( 'tcb_landing_header_content', 	array( $this, 'title_site' ), 10 );
		add_action( 'tcb_landing_header_content', 	array( $this, 'site_description' ), 15 );

		add_action( 'tha_header_bottom', 				array( $this, 'site_branding_end' ), 85 );
		add_action( 'tha_header_bottom', 				array( $this, 'header_wrap_end' ), 90 );
		add_action( 'tha_header_bottom', 				array( $this, 'menu_primary' ), 95 );

		add_action( 'tha_body_top', 					array( $this, 'analytics_code' ), 10 );
		add_action( 'tha_body_top', 					array( $this, 'add_hidden_search' ), 15 );
		add_action( 'tha_body_top', 					array( $this, 'skip_link' ), 20 );

		add_action( 'tha_content_while_before', 		array( $this, 'title_archive' ) );
		add_action( 'tha_content_while_before', 		array( $this, 'title_single_post' ) );

		add_action( 'tha_content_while_after', 			array( $this, 'posts_nav' ) );

		add_action( 'tcb_landing_footer_content', 	array( $this, 'footer_content' ) );

		add_action( 'tha_content_top', 					array( $this, 'breadcrumbs' ) );

		add_action( 'tha_entry_after', 					array( $this, 'comments' ), 10 );

		add_action( 'tcb_landing_404_before', 		array( $this, 'title_404' ), 10 );

		add_action( 'tcb_landing_404_content', 		array( $this, 'add_search' ), 10 );
		add_action( 'tcb_landing_404_content', 		array( $this, 'four_04_posts_widget' ), 15 );
		add_action( 'tcb_landing_404_content', 		array( $this, 'four_04_categories' ), 20 );
		add_action( 'tcb_landing_404_content', 		array( $this, 'four_04_archives' ), 25 );
		add_action( 'tcb_landing_404_content', 		array( $this, 'four_04_tag_cloud' ), 30 );

		add_action( 'entry_header_content', 			array( $this, 'title_entry' ), 10 );
		add_action( 'entry_header_content', 			array( $this, 'title_page' ), 10 );
		add_action( 'entry_header_content', 			array( $this, 'title_none' ), 10 );
		add_action( 'entry_header_content', 			array( $this, 'title_search' ), 10 );
		add_action( 'entry_header_content', 			array( $this, 'posted_on' ), 20 );

		add_action( 'tha_footer_top', 					array( $this, 'footer_wrap_begin' ) );
		add_action( 'westcpa_footer_content', 			array( $this, 'footer_locations' ), 10 );
		add_action( 'westcpa_footer_content', 			array( $this, 'footer_content' ), 20 );
		add_action( 'tha_footer_bottom', 				array( $this, 'footer_wrap_end' ) );

	} // loader()

	/**
	 * Adds a hidden search field
	 *
	 * @hooked 		tha_body_top 		15
	 *
	 * @return 		mixed 				The HTML markup for a search field
	 */
	public function add_hidden_search() {

		?><div aria-hidden="true" class="hidden-search-top" id="hidden-search-top">
			<div class="wrap"><?php

			get_search_form();

			?></div>
		</div><?php

	} // add_hidden_search()

	/**
	 * Adds a search form
	 *
	 * @hooked 		tcb_landing_404_content 		15
	 *
	 * @return 		mixed 		Search form markup
	 */
	public function add_search() {

		get_search_form();

	} // add_search()

	/**
	 * Inserts Google Tag manager code after body tag
	 *
	 * @hooked 		tha_body_top 		10
	 *
	 * @return 		mixed 				The inserted Google Tag Manager code
	 */
	public function analytics_code() {

		$tag = get_theme_mod( 'tag_manager' );

		if ( ! empty( $tag ) ) {

			echo '<!-- Google Tag Manager -->';
			echo $tag;
			echo '<!-- Google Tag Manager -->';

		}

	} // analytics_code()

	/**
	 * Returns the appropriate breadcrumbs.
	 *
	 * @hooked		tcb_landing_wrap_content
	 *
	 * @return 		mixed 				WooCommerce breadcrumbs, then Yoast breadcrumbs
	 */
	public function breadcrumbs() {

		if ( is_front_page() ) { return; }

		?><div class="breadcrumbs">
			<div class="wrap-crumbs"><?php

				if ( function_exists( 'woocommerce_breadcrumb' ) ) {

					$args['after'] 			= '</span>';
					$args['before'] 		= '<span rel="v:child" typeof="v:Breadcrumb">';
					$args['delimiter'] 		= '&nbsp;>&nbsp;';
					$args['home'] 			= esc_html_x( 'Home', 'breadcrumb', 'tcb-landing' );
					$args['wrap_after'] 	= '</span></span></nav>';
					$args['wrap_before'] 	= '<nav class="woocommerce-breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '><span xmlns:v="http://rdf.data-vocabulary.org/#"><span typeof="v:Breadcrumb">';

					woocommerce_breadcrumb( $args );

				} elseif ( function_exists( 'yoast_breadcrumb' ) ) {

					yoast_breadcrumb();

				}

			?></div><!-- .wrap-crumbs -->
		</div><!-- .breadcrumbs --><?php

	} // breadcrumbs()

	/**
	 * The comments markup
	 *
	 * If comments are open or we have at least one comment, load up the comment template.
	 *
	 * @hooked 		tha_entry_after 		10
	 *
	 * @return 		mixed 					The comments markup
	 */
	public function comments() {

		if ( ! comments_open() || get_comments_number() <= 0 ) { return; }

		comments_template();

	} // comments()

	/**
	 * Adds the copyright and credits to the footer content.
	 *
	 * @hooked 		tcb_landing_footer_content
	 *
	 * @return 		mixed 									The footer markup
	 */
	public function footer_content() {

		?><div class="site-info">
			<div class="copyright">&copy <?php echo date( 'Y' ); ?> <a href="<?php echo esc_url( get_admin_url(), 'tcb-landing' ); ?>"><?php echo get_bloginfo( 'name' ); ?></a></div>
			<div class="credits"><?php printf( esc_html__( 'Site created by %1$s', 'tcb-landing' ), '<a href="https://dccmarketing.com/" rel="nofollow" target="_blank">DCC Marketing</a>' ); ?></div>
		</div><!-- .site-info --><?php

	} // footer_content()

	/**
	 * Adds the opening wrapper tag.
	 *
	 * @return 		mixed 		The opening wrapper tag
	 */
	public function footer_wrap_begin() {

		?><div class="wrap wrap-footer"><?php

	} // footer_wrap_begin()

	/**
	 * Adds the closing wrapper tag.
	 *
	 * @return 		mixed 		The closing wrapper tag
	 */
	public function footer_wrap_end() {

		?></div><!-- wrap-footer --><?php

	} // footer_wrap_end()

	/**
	 * Adds the  to the 404 page content.
	 *
	 * @hooked 		tcb_landing_404_content		25
	 *
	 * @return 		mixed 							Markup for the archives
	 */
	public function four_04_archives() {

		if ( ! is_404() ) { return; }

		/* translators: %1$s: smiley */
		$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'tcb-landing' ), convert_smilies( ':)' ) ) . '</p>';

		the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );

	} // four_04_archives()

	/**
	 * Adds the  to the 404 page content.
	 *
	 * @hooked 		tcb_landing_404_content		20
	 *
	 * @return 		mixed 							The categories widget
	 */
	public function four_04_categories() {

		if ( ! is_404() ) { return; }
		if ( ! tcb_landing_categorized_blog() ) { return; }

		?><div class="widget widget_categories">
			<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'tcb-landing' ); ?></h2>
			<ul><?php

				wp_list_categories( array(
					'orderby'    => 'count',
					'order'      => 'DESC',
					'show_count' => 1,
					'title_li'   => '',
					'number'     => 10,
				) );

			?></ul>
		</div><!-- .widget --><?php

	} // four_04_categories()

	/**
	 * Adds the Recent Posts widget to the 404 page.
	 *
	 * @hooked 		tcb_landing_404_content 		15
	 *
	 * @return 		mixed 							The Recent Posts widget
	 */
	public function four_04_posts_widget() {

		if ( ! is_404() ) { return; }

		the_widget( 'WP_Widget_Recent_Posts' );

	} // four_04_posts_widget()

	/**
	 * Adds the  to the 404 page content.
	 *
	 * @hooked 		tcb_landing_404_content		30
	 *
	 * @return 		mixed 							The tag cloud widget
	 */
	public function four_04_tag_cloud() {

		if ( ! is_404() ) { return; }

		the_widget( 'WP_Widget_Tag_Cloud' );

	} // four_04_tag_cloud()

	/**
	 * The header wrap markup
	 *
	 * @hooked  	tha_header_bottom 		90
	 *
	 * @return 		mixed 					The header wrap markup
	 */
	public function header_wrap_end() {

		?></div><!-- .wrap-header --><?php

	} // header_wrap_end()

	/**
	 * The header wrap markup
	 *
	 * @hooked 		tha_header_top 		10
	 *
	 * @return 		mixed 				The header wrap markup
	 */
	public function header_wrap_start() {

		?><div class="wrap wrap-header"><?php

	} // header_wrap_start()

	/**
	 * Adds the primary menu
	 *
	 * @hooked 		tha_header_bottom 		95
	 *
	 * @return 		mixed 					The primary menu markup
	 */
	public function menu_primary() {

		?><nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'tcb-landing' ); ?></button><?php

				$menu_args['menu_id'] 			= 'primary-menu';
				$menu_args['theme_location'] 	= 'primary';
				$menu_args['walker']  			= new Main_Menu_Walker();

				wp_nav_menu( $menu_args );

		?></nav><!-- #site-navigation --><?php

	} // menu_primary()

	/**
	 * Adds the primary menu
	 *
	 * @hooked 		tha_header_bottom 		65
	 *
	 * @return 		mixed 					The social links menu markup
	 */
	public function menu_social() {

		//if (  ) { return; }

		if ( ! has_nav_menu( 'social' ) ) { return; }

		$menu_args['theme_location']	= 'social';
		$menu_args['container'] 		= 'div';
		$menu_args['container_id']    	= 'menu-social-media';
		$menu_args['container_class'] 	= 'menu nav-social';
		$menu_args['menu_id']         	= 'menu-social-media-items';
		$menu_args['menu_class']      	= 'menu-items';
		$menu_args['depth']           	= 1;
		$menu_args['fallback_cb']     	= '';

		wp_nav_menu( $menu_args );

	} // menu_social()

	/**
	 * Adds the posted_on post meta.
	 *
	 * @return 		mixed 			The posted_on post meta.
	 */
	public function posted_on() {

		if ( 'post' != get_post_type() ) { return; }
		if ( ! is_search() ) { return; }

		?><div class="entry-meta"><?php

			tcb_landing_posted_on();

		?></div><!-- .entry-meta --><?php

	} // posted_on()

	/**
	 * Adds the post navigation to the archive pages
	 *
	 * @hooked 		tha_content_while_after
	 *
	 * @return 		mixed 							The posts navigation
	 */
	public function posts_nav() {

		if (
			! is_home()
			|| ! is_archive()
		) { return; }

		the_posts_navigation();

	} // posts_nav()

	/**
	 * Adds the starting site branding markup
	 *
	 * @hooked 		tha_header_bottom			85
	 *
	 * @return 		mixed 						HTML markup
	 */
	public function site_branding_end() {

		?></div><!-- .site-branding --><?php

	} // site_branding_end()

	/**
	 * Adds the starting site branding markup
	 *
	 * @hooked 		tha_header_top				15
	 *
	 * @return 		mixed 						HTML markup
	 */
	public function site_branding_start() {

		?><div class="site-branding"><?php

	} // site_branding_start()

	/**
	 * Adds the site description markup
	 *
	 * @hooked 		tcb_landing_header_content 		15
	 *
	 * @return 		mixed 								The site description markup
	 */
	public function site_description() {

		$description = get_bloginfo( 'description', 'display' );

		if ( $description || is_customize_preview() ) {

			?><p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p><?php

		}

	} // site_description()

	/**
	 * Adds the a11y skip link markup
	 *
	 * @hooked 		tha_body_top 		20
	 *
	 * @return 		mixed 				Skip link markup
	 */
	public function skip_link() {

		?><a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'tcb-landing' ); ?></a><?php

	} // skip_link()

	/**
	 * The 404 page title markup
	 *
	 * @hooked 		tcb_landing_404_content 		10
	 *
	 * @return 		mixed 							The 440 page title
	 */
	public function title_404() {

		if ( ! is_404() ) { return; }

		?><header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'tcb-landing' ); ?></h1>
		</header><!-- .page-header -->
		<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'tcb-landing' ); ?></p><?php

	} // title_404()

	/**
	 * Adds the page title to an archive page
	 *
	 * @hooked 		tha_content_while_before
	 *
	 * @return 		mixed 							The archive page title
	 */
	public function title_archive() {

		if ( ! is_archive() ) { return; }

		?><header class="page-header"><?php

			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="taxonomy-description">', '</div>' );

		?></header><!-- .page-header --><?php

	} // title_archive()

	/**
	 * Returns the entry title
	 *
	 * @hooked 		entry_header_content 			10
	 *
	 * @return 		mixed 							The entry title
	 */
	public function title_entry() {

		if ( is_front_page() ) { return; }
		if ( is_page() ) { return; }

		if ( is_single() ) {

			the_title( '<h1 class="entry-title">', '</h1>' );

		} else {

			the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );

		}

	} // title_entry()

	/**
	 * Returns the page title
	 *
	 * @hooked 		entry_header_content 		10
	 *
	 * @return 		mixed 							The entry title
	 */
	public function title_none() {

		if ( ! is_home() ) { return; }

		?><h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'tcb-landing' ); ?></h1><?php

	} // title_none()

	/**
	 * Returns the page title
	 *
	 * @hooked 		tha_content_while_before 		10
	 *
	 * @return 		mixed 							The entry title
	 */
	public function title_page() {

		if ( is_front_page() || is_home() ) { return; }
		if ( ! is_page() ) { return; }

		the_title( '<h1 class="page-title">', '</h1>' );

	} // title_page()

	/**
	 * The search title markup
	 *
	 * @hooked 		tha_content_while_before
	 *
	 * @return 		mixed 							Search title markup
	 */
	public function title_search() {

		if ( ! is_search() ) { return; }

		?><header class="page-header">
			<h1 class="page-title"><?php

				printf( esc_html__( 'Search Results for: %s', 'tcb-landing' ), '<span>' . get_search_query() . '</span>' );

			?></h1>
		</header><!-- .page-header --><?php

	} // title_search()

	/**
	 * Adds the single post title to the index
	 *
	 * @hooked 		tha_content_while_before
	 *
	 * @return 		mixed 							The single post title
	 */
	public function title_single_post() {

		if ( ! is_home() && is_front_page() ) { return; }

		?><header>
			<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
		</header><?php

	} // title_single_post()

	/**
	 * Adds the site title markup
	 *
	 * @hooked 		tcb_landing_header_content 		10
	 *
	 * @return 		mixed 								The site title markup
	 */
	public function title_site() {

		if ( is_front_page() && is_home() ) {

			?><h1 class="site-title"><?php the_custom_logo(); ?></h1><?php

		} else {

			?><p class="site-title"><?php the_custom_logo(); ?></p><?php

		}

	} // title_site()

} // class

$tcb_landing_Themehooks = new tcb_landing_Themehooks();


