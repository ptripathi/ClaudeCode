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
    add_theme_support( 'starter-content' );
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
        'village_distance'   => [ 'Distance from Prayagraj Railway Station', '' ],
        'village_state'      => [ 'State',                 '' ],
        'panchayat_phone'    => [ 'Panchayat Phone',       '' ],
        'panchayat_email'    => [ 'Panchayat Email',       '' ],
        'panchayat_address'  => [ 'Panchayat Address',     '' ],
        'vidhan_sabha'       => [ 'Vidhan Sabha Chhetra',  '' ],
        'lok_sabha'          => [ 'Lok Sabha Chhetra',     '' ],
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

/* ------------------------------------------------------------------
   Village Data — Auto-populate on theme activation
   Sets all customizer mods and registers starter content so that
   when the theme is first activated the site is ready to go.
------------------------------------------------------------------ */
function village_set_defaults() {
    $defaults = [
        'village_name'       => 'Unchdih',
        'village_tagline'    => 'एक गाँव, अनेक कहानियाँ — A Village of Heritage & Community',
        'village_population' => '3,500',
        'village_area'       => '8.4',
        'village_district'   => 'Prayagraj',
        'village_state'      => 'Uttar Pradesh',
        'village_distance'   => '40 km',
        'panchayat_phone'    => '0532-XXXXXXX',
        'panchayat_email'    => 'panchayat.unchdih@up.gov.in',
        'panchayat_address'  => 'Gram Panchayat Bhavan, Unchdih, Ramnagar, Prayagraj, Uttar Pradesh',
        'vidhan_sabha'       => 'Karchhana (252)',
        'lok_sabha'          => 'Allahabad (52)',
        'hero_btn_primary'   => 'Explore Village',
        'hero_btn_secondary' => 'Latest News',
        'hero_btn_primary_url'   => '#about',
        'hero_btn_secondary_url' => '#news',
    ];

    foreach ( $defaults as $key => $value ) {
        if ( ! get_theme_mod( $key ) ) {
            set_theme_mod( $key, $value );
        }
    }
}
add_action( 'after_switch_theme', 'village_set_defaults' );

function village_starter_content( $content ) {
    $about_content = '
<p>Unchdih is a village located near Ramnagar in Prayagraj district, Uttar Pradesh. Nestled in the fertile plains of the Ganga–Yamuna Doab, the village has a rich agricultural heritage and a close-knit community that has preserved its traditions across generations.</p>

<p>The village falls under Ramnagar block and is well connected to the historic city of Prayagraj — one of India\'s oldest cities, home to the sacred Triveni Sangam where the Ganga, Yamuna, and the mythical Saraswati rivers meet. Unchdih sits approximately 15–20 km from the city centre, making it accessible while retaining its rural character.</p>

<h2>Agriculture</h2>
<p>The primary occupation of Unchdih\'s residents is farming. The fertile alluvial soil of the Doab supports cultivation of wheat, rice, pulses, mustard, and seasonal vegetables. Many families also rear cattle and engage in dairy farming, which forms a significant part of the local economy.</p>

<h2>Education</h2>
<p>The village has a Primary Vidyalaya and children attend secondary schools in nearby Ramnagar. Community members have historically placed high value on education, and an increasing number of young people from Unchdih are pursuing higher education and professional careers in Prayagraj and beyond.</p>

<h2>Infrastructure</h2>
<p>Unchdih is connected by pucca roads to Ramnagar and to the main Prayagraj road network. The village has electricity supply, hand-pump and piped water access, and a Panchayat Bhavan that serves as the centre for local governance and community gatherings.</p>
';

    $culture_content = '
<p>Unchdih, like most villages in Prayagraj district, celebrates a rich calendar of festivals that reflect the culture and traditions of Uttar Pradesh.</p>

<h2>Ram Leela</h2>
<p>Being close to Ramnagar, the village is deeply connected to the Ramnagar Ram Leela — one of the most celebrated month-long performances of the Ramayana in India, held every year during the Navratri and Dussehra season. Many villagers participate in and attend the Ram Leela as a cherished annual tradition.</p>

<h2>Kumbh Mela Connection</h2>
<p>Prayagraj hosts the Kumbh Mela — the world\'s largest religious gathering — every 12 years and the Ardh Kumbh every 6 years. Residents of Unchdih have a long tradition of taking part in the holy dip at Triveni Sangam during these sacred occasions.</p>

<h2>Holi</h2>
<p>Holi is celebrated with great enthusiasm. The village comes alive with colours, folk music, and community feasting. Traditional gujiya sweets are made in every home and shared with neighbours.</p>

<h2>Diwali & Chhath Puja</h2>
<p>Diwali is marked by lighting of diyas, firecrackers, and the worship of Lakshmi. Chhath Puja — a festival dedicated to the Sun God — is observed with deep reverence at the nearest water body, with women observing a strict fast over four days.</p>

<h2>Makar Sankranti</h2>
<p>Celebrated in January as the harvest festival, Makar Sankranti is observed with kite flying, distribution of til-gur (sesame and jaggery), and a holy dip in the Ganga.</p>
';

    $news_content = '
<p>This page lists the latest news, official notices, and announcements from Gram Panchayat Unchdih.</p>
<p>Check back regularly for updates on government schemes, local events, infrastructure works, and community decisions.</p>
';

    $gallery_content = '
<p>A collection of photographs capturing the beauty, culture, and everyday life of Unchdih. Upload images directly from the WordPress editor to add to this gallery.</p>
';

    $contact_content = '
<h2>Gram Panchayat Unchdih</h2>
<p><strong>Address:</strong><br>Gram Panchayat Bhavan, Unchdih,<br>Ramnagar, Prayagraj,<br>Uttar Pradesh</p>

<p><strong>Block:</strong> Ramnagar<br>
<strong>District:</strong> Prayagraj<br>
<strong>State:</strong> Uttar Pradesh</p>

<p>To reach us, visit the Panchayat Bhavan during office hours, or use the contact form below. For urgent matters contact the Gram Pradhan directly.</p>
';

    $content['posts']['home'] = [
        'post_type'    => 'page',
        'post_title'   => 'Home',
        'post_name'    => 'home',
        'post_content' => '',
    ];

    $ganga_content = '
<p>उंचडीह गाँव प्रयागराज जिले में स्थित है, जहाँ से पवित्र गंगा नदी बहती है। यहाँ के लोगों के लिए गंगा केवल एक नदी नहीं — वह जीवन का स्रोत, एक जीवित देवी और इस समुदाय की आत्मा है।</p>
<p><em>Unchdih lies in Prayagraj district, through which the sacred River Ganges flows. For the people here, the Ganga is not merely a river — she is a living goddess, the source of life, and the spiritual heart of the community.</em></p>

<h2>प्रयागराज — त्रिवेणी संगम / The Triveni Sangam</h2>
<p>उंचडीह, प्रयागराज के निकट है — जहाँ गंगा, यमुना और पौराणिक सरस्वती नदियों का पवित्र त्रिवेणी संगम है। यह स्थान प्रतिवर्ष लाखों तीर्थयात्रियों को आकर्षित करता है और प्रत्येक 12 वर्ष में महाकुंभ मेले का आयोजन यहीं होता है — जो विश्व का सबसे बड़ा मानव समागम है।</p>
<p><em>Unchdih is within reach of Prayagraj, home to the Triveni Sangam — the confluence of the Ganga, Yamuna, and the mythical Saraswati. This site attracts millions of pilgrims each year and hosts the Kumbh Mela every 12 years, the world\'s largest human gathering.</em></p>

<h2>गंगा और कृषि / Ganga and Agriculture</h2>
<p>गंगा की बाढ़ के मैदानों की उपजाऊ जलोढ़ मिट्टी सहस्राब्दियों से उंचडीह जैसे गाँवों की कृषि का आधार रही है। गेहूं, चावल, दलहन और सब्जियाँ यहाँ प्रचुरता से उगाई जाती हैं। किसान नदी के मौसमी चक्र पर निर्भर हैं और नहरों व कुओं से सिंचाई करते हैं।</p>
<p><em>The Ganga\'s fertile alluvial flood plains have sustained farming in villages like Unchdih for millennia. Wheat, rice, pulses, and vegetables thrive here. Farmers depend on the river\'s seasonal rhythms and irrigate through canals and wells fed by the Ganga.</em></p>

<h2>छठ पूजा / Chhath Puja</h2>
<p>गाँव का सबसे भव्य पर्व है छठ पूजा। भक्तगण — विशेषकर महिलाएं — 36 घंटे का कठोर व्रत रखती हैं और गंगा के घाट पर उगते व अस्त होते सूर्य को अर्घ्य देती हैं। घाट का किनारा दीपों की रोशनी और श्रद्धा के सागर में डूब जाता है।</p>
<p><em>Chhath Puja is the village\'s grandest festival. Devotees — mostly women — observe a 36-hour fast and offer prayers to the rising and setting sun at the Ganga\'s ghat. The riverbank transforms into a sea of lamps and devotion.</em></p>

<h2>मकर संक्रांति — पवित्र स्नान / Makar Sankranti</h2>
<p>14 जनवरी को मकर संक्रांति पर गाँव के लोग प्रयागराज में संगम पर पवित्र डुबकी लगाने जाते हैं। मान्यता है कि इस दिन त्रिवेणी संगम में स्नान करने से पापों का नाश होता है और पुण्य की प्राप्ति होती है।</p>
<p><em>On Makar Sankranti (January 14th), villagers join thousands travelling to the Sangam for a holy dip. It is believed that bathing at Triveni on this day washes away sins and brings divine blessings.</em></p>

<h2>गंगा दशहरा / Ganga Dussehra</h2>
<p>गंगा दशहरा पर गंगा के स्वर्ग से पृथ्वी पर अवतरण का उत्सव मनाया जाता है। नदी को फूल, दीपक और प्रार्थनाओं से पूजा जाता है।</p>
<p><em>Ganga Dussehra celebrates the descent of the Ganga from the heavens to earth. The river is worshipped with flowers, lamps, and prayers.</em></p>

<h2>नमामि गंगे / Namami Gange</h2>
<p>उंचडीह का समुदाय गंगा की स्वच्छता और पुनर्जीवन के लिए सरकार के नमामि गंगे अभियान का समर्थन करता है। गंगा को स्वच्छ रखना हमारी सामूहिक जिम्मेदारी है।</p>
<p><em>The community of Unchdih supports the Namami Gange programme — the government\'s initiative to clean and rejuvenate the sacred river. Keeping the Ganga pure is our collective responsibility.</em></p>
';

    $pages = [
        'about'   => [ 'About Unchdih',       $about_content   ],
        'ganga'   => [ 'पवित्र गंगा — The Sacred Ganga', $ganga_content ],
        'culture' => [ 'Culture & Festivals',  $culture_content ],
        'news'    => [ 'News & Notices',        $news_content    ],
        'gallery' => [ 'Photo Gallery',         $gallery_content ],
        'contact' => [ 'Contact Panchayat',     $contact_content ],
    ];

    foreach ( $pages as $slug => [ $title, $body ] ) {
        $content['posts'][ $slug ] = [
            'post_type'    => 'page',
            'post_title'   => $title,
            'post_name'    => $slug,
            'post_content' => $body,
        ];
    }

    $content['options'] = [
        'show_on_front'  => 'page',
        'page_on_front'  => '{{home}}',
        'blogname'       => 'Unchdih Village',
        'blogdescription'=> 'Ramnagar, Prayagraj, Uttar Pradesh',
    ];

    $content['nav_menus']['primary'] = [
        'name'  => 'Primary Navigation',
        'items' => [
            [ 'object' => 'page', 'object_id' => '{{home}}' ],
            [ 'object' => 'page', 'object_id' => '{{about}}' ],
            [ 'object' => 'page', 'object_id' => '{{ganga}}' ],
            [ 'object' => 'page', 'object_id' => '{{news}}' ],
            [ 'object' => 'page', 'object_id' => '{{gallery}}' ],
            [ 'object' => 'page', 'object_id' => '{{culture}}' ],
            [ 'object' => 'page', 'object_id' => '{{contact}}' ],
        ],
    ];

    $content['theme_mods'] = [
        'village_name'       => 'Unchdih',
        'village_tagline'    => 'एक गाँव, अनेक कहानियाँ — A Village of Heritage & Community',
        'village_population' => '3,500',
        'village_area'       => '8.4',
        'village_district'   => 'Prayagraj',
        'village_state'      => 'Uttar Pradesh',
        'village_distance'   => '40 km',
        'panchayat_address'  => 'Gram Panchayat Bhavan, Unchdih, Ramnagar, Prayagraj, Uttar Pradesh',
        'vidhan_sabha'       => 'Karchhana (252)',
        'lok_sabha'          => 'Allahabad (52)',
    ];

    return $content;
}
add_filter( 'get_theme_starter_content', 'village_starter_content' );

function village_pagination() {
    echo paginate_links( [
        'prev_text' => '&larr;',
        'next_text' => '&rarr;',
        'type'      => 'plain',
        'before_page_number' => '<span class="sr-only">' . __( 'Page', 'village-connect' ) . ' </span>',
    ] );
}

/* ------------------------------------------------------------------
   Multilingual — Polylang integration
   Install the free "Polylang" plugin to enable Hindi ↔ English.
   The language switcher in the header uses pll_the_languages()
   when Polylang is active, and falls back to a URL-param switcher.
------------------------------------------------------------------ */
function village_language_switcher() {
    if ( function_exists( 'pll_the_languages' ) ) {
        echo '<ul class="lang-switcher">';
        pll_the_languages( [
            'show_flags'    => 0,
            'show_names'    => 1,
            'display_names_as' => 'name',
            'hide_current'  => 0,
            'echo'          => 1,
        ] );
        echo '</ul>';
        return;
    }

    // Fallback: simple hi / en toggle via ?lang= query param
    $current = isset( $_GET['lang'] ) ? sanitize_key( $_GET['lang'] ) : 'hi';
    $base    = strtok( ( isset( $_SERVER['HTTPS'] ) ? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], '?' );
    echo '<div class="lang-switcher lang-switcher--simple">';
    echo '<a href="' . esc_url( $base . '?lang=hi' ) . '" class="lang-btn' . ( $current === 'hi' ? ' active' : '' ) . '" hreflang="hi">हिं</a>';
    echo '<span class="lang-sep">|</span>';
    echo '<a href="' . esc_url( $base . '?lang=en' ) . '" class="lang-btn' . ( $current === 'en' ? ' active' : '' ) . '" hreflang="en">EN</a>';
    echo '</div>';
}

// Register dynamic customizer strings with Polylang so they can be translated
function village_pll_register_strings() {
    if ( ! function_exists( 'pll_register_string' ) ) return;
    $keys = [
        'village_name', 'village_tagline', 'village_district', 'village_state',
        'panchayat_address', 'panchayat_phone', 'panchayat_email',
        'hero_btn_primary', 'hero_btn_secondary',
    ];
    foreach ( $keys as $key ) {
        $val = get_theme_mod( $key, '' );
        if ( $val ) pll_register_string( $key, $val, 'Village Connect Theme' );
    }
}
add_action( 'init', 'village_pll_register_strings' );
