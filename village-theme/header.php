<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="site-header">
  <div class="container header-inner">

    <a class="site-brand" href="<?php echo esc_url( home_url('/') ); ?>">
      <?php if ( has_custom_logo() ) : ?>
        <?php the_custom_logo(); ?>
      <?php else : ?>
        <span class="brand-name"><?php echo village_mod('village_name', get_bloginfo('name')); ?></span>
        <?php
        $loc = implode(', ', array_filter([
            get_theme_mod('village_district',''),
            get_theme_mod('village_state',''),
        ]));
        if ($loc) : ?>
          <span class="brand-loc"><?php echo esc_html($loc); ?></span>
        <?php endif; ?>
      <?php endif; ?>
    </a>

    <nav class="primary-nav" id="primary-nav" aria-label="<?php esc_attr_e('Primary', 'village-connect'); ?>">
      <?php wp_nav_menu([
        'theme_location' => 'primary',
        'menu_class'     => 'nav-list',
        'container'      => false,
        'fallback_cb'    => function() {
          echo '<ul class="nav-list">';
          wp_list_pages(['title_li' => '', 'depth' => 1]);
          echo '</ul>';
        },
      ]); ?>
    </nav>

    <button class="menu-toggle" id="menu-toggle"
            aria-label="<?php esc_attr_e('Toggle menu', 'village-connect'); ?>"
            aria-expanded="false"
            aria-controls="primary-nav">
      <span class="bar"></span>
      <span class="bar"></span>
      <span class="bar"></span>
    </button>

    <div class="header-lang">
      <?php village_language_switcher(); ?>
    </div>

  </div>
</header>
<div class="nav-backdrop" id="nav-backdrop" aria-hidden="true"></div>
