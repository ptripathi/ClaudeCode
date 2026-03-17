<?php
/**
 * Village Connect — functions.php
 */
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'VILLAGE_VER', '1.0.0' );
define( 'VILLAGE_URI', get_template_directory_uri() );

/* ------------------------------------------------------------------
   Theme Setup
------------------------------------------------------------------ */
function village_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );

    add_theme_support( 'custom-logo', [
        'height'      => 80,
        'width'       => 220,
        'flex-height' => true,
        'flex-width'  => true,
    ] );

    add_theme_support( 'custom-header', [
        'default-image'      => '',
        'width'              => 1920,
        'height'             => 1080,
        'flex-height'        => true,
        'flex-width'         => true,
        'default-text-color' => 'ffffff',
    ] );

    add_image_size( 'village-hero',    1920, 1080, true );
    add_image_size( 'village-card',     600,  400, true );
    add_image_size( 'village-thumb',    400,  300, true );
    add_image_size( 'village-gallery',  800,  600, false );

    register_nav_menus( [
        'primary' => __( 'Primary Navigation', 'village-connect' ),
        'footer'  => __( 'Footer Navigation',  'village-connect' ),
    ] );

    load_theme_textdomain( 'village-connect', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'village_setup' );

function village_content_width() { $GLOBALS['content_width'] = 1200; }
add_action( 'after_setup_theme', 'village_content_width', 0 );

/* ------------------------------------------------------------------
   Enqueue
------------------------------------------------------------------ */
function village_scripts() {
    wp_enqueue_style( 'village-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap',
        [], null
    );
    wp_enqueue_style( 'village-main',  VILLAGE_URI . '/assets/css/main.css', [ 'village-fonts' ], VILLAGE_VER );
    wp_enqueue_style( 'village-style', get_stylesheet_uri(), [ 'village-main' ], VILLAGE_VER );
    wp_enqueue_script( 'village-js',   VILLAGE_URI . '/assets/js/main.js', [], VILLAGE_VER, true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    wp_localize_script( 'village-js', 'villageData', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'siteUrl' => esc_url( home_url() ),
    ] );
}
add_action( 'wp_enqueue_scripts', 'village_scripts' );

/* ------------------------------------------------------------------
   Widget Areas
------------------------------------------------------------------ */
function village_widgets_init() {
    $areas = [
        [ 'name' => 'Footer — Village Info',   'id' => 'footer-1' ],
        [ 'name' => 'Footer — Quick Links',    'id' => 'footer-2' ],
        [ 'name' => 'Footer — Contact',        'id' => 'footer-3' ],
        [ 'name' => 'Page Sidebar',            'id' => 'sidebar-1' ],
    ];
    foreach ( $areas as $a ) {
        register_sidebar( array_merge( $a, [
            'description'   => '',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ] ) );
    }
}
add_action( 'widgets_init', 'village_widgets_init' );

/* ------------------------------------------------------------------
   Customizer — Village Settings
------------------------------------------------------------------ */
function village_customizer( $wp_customize ) {

    /* Village Info section */
    $wp_customize->add_section( 'village_info', [
        'title'    => __( 'Village Information', 'village-connect' ),
        'priority' => 30,
    ] );

    $fields = [
        'village_name'       => [ 'Village Name',          '' ],
        'village_tagline'    => [ 'Hero Tagline',          'Heritage · Culture · Community' ],
        'village_population' => [ 'Population',            '' ],
        'village_area'       => [ 'Area (sq km)',          '' ],
        'village_district'   => [ 'District',              '' ],
        'village_state'      => [ 'State',                 '' ],
        'panchayat_phone'    => [ 'Panchayat Phone',       '' ],
        'panchayat_email'    => [ 'Panchayat Email',       '' ],
        'panchayat_address'  => [ 'Panchayat Address',     '' ],
        'social_facebook'    => [ 'Facebook URL',          '' ],
        'social_youtube'     => [ 'YouTube Channel URL',   '' ],
        'social_whatsapp'    => [ 'WhatsApp Number',       '' ],
    ];

    foreach ( $fields as $key => [ $label, $default ] ) {
        $wp_customize->add_setting( $key, [
            'default'           => $default,
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        ] );
        $wp_customize->add_control( $key, [
            'label'   => __( $label, 'village-connect' ),
            'section' => 'village_info',
            'type'    => 'text',
        ] );
    }

    /* Hero section */
    $wp_customize->add_section( 'village_hero', [
        'title'    => __( 'Hero / Banner', 'village-connect' ),
        'priority' => 31,
    ] );

    foreach ( [
        'hero_btn_primary'   => [ 'Primary Button Text',   'Explore Village' ],
        'hero_btn_secondary' => [ 'Secondary Button Text', 'Latest News' ],
        'hero_btn_primary_url'   => [ 'Primary Button Link',  '#about' ],
        'hero_btn_secondary_url' => [ 'Secondary Button Link', '#news' ],
    ] as $key => [ $label, $default ] ) {
        $wp_customize->add_setting( $key, [ 'default' => $default, 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( $key, [ 'label' => __( $label, 'village-connect' ), 'section' => 'village_hero', 'type' => 'text' ] );
    }
}
add_action( 'customize_register', 'village_customizer' );

/* ------------------------------------------------------------------
   Helpers
------------------------------------------------------------------ */
function village_mod( $key, $fallback = '' ) {
    return esc_html( get_theme_mod( $key, $fallback ) );
}

function village_excerpt_length( $length ) { return 20; }
add_filter( 'excerpt_length', 'village_excerpt_length' );

function village_excerpt_more( $more ) { return '…'; }
add_filter( 'excerpt_more', 'village_excerpt_more' );

// Ensure native lazy-loading on all attachment images
function village_lazy_attr( $attr ) {
    $attr['loading'] = 'lazy';
    return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'village_lazy_attr' );

function village_pagination() {
    echo paginate_links( [
        'prev_text' => '&larr;',
        'next_text' => '&rarr;',
        'type'      => 'plain',
        'before_page_number' => '<span class="sr-only">' . __( 'Page', 'village-connect' ) . ' </span>',
    ] );
}
