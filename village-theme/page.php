<?php get_header(); ?>

<main class="main-content" id="main">
  <?php while ( have_posts() ) : the_post(); ?>

    <?php if ( has_post_thumbnail() ) : ?>
      <div class="page-hero">
        <?php the_post_thumbnail('village-hero', ['class' => 'page-hero-img']); ?>
        <div class="page-hero-overlay"></div>
        <div class="container">
          <h1 class="page-title"><?php the_title(); ?></h1>
        </div>
      </div>
    <?php endif; ?>

    <div class="container content-sidebar-wrap">
      <article class="content-area page-content">
        <?php if ( ! has_post_thumbnail() ) : ?>
          <h1 class="page-title"><?php the_title(); ?></h1>
        <?php endif; ?>
        <div class="prose">
          <?php the_content(); ?>
        </div>
        <?php
        wp_link_pages( [
          'before' => '<nav class="page-links">',
          'after'  => '</nav>',
        ] );
        ?>
      </article>

      <?php if ( is_active_sidebar('sidebar-1') ) : ?>
        <aside class="sidebar" aria-label="<?php esc_attr_e('Sidebar','village-connect'); ?>">
          <?php dynamic_sidebar('sidebar-1'); ?>
        </aside>
      <?php endif; ?>
    </div>

  <?php endwhile; ?>
</main>

<?php get_footer(); ?>
