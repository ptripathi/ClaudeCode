<?php get_header(); ?>

<main class="main-content" id="main">
  <div class="container content-sidebar-wrap">

    <div class="content-area">

      <div class="archive-header reveal">
        <h1 class="archive-title">
          <?php
          if ( is_category() )      single_cat_title();
          elseif ( is_tag() )       single_tag_title();
          elseif ( is_author() )    the_author();
          elseif ( is_date() )      echo get_the_date('F Y');
          elseif ( is_search() )    printf( __('Search: %s','village-connect'), '<em>' . get_search_query() . '</em>' );
          else                      _e('News & Notices','village-connect');
          ?>
        </h1>
      </div>

      <?php if ( have_posts() ) : ?>

        <div class="cards-grid">
          <?php while ( have_posts() ) : the_post(); ?>
            <article <?php post_class('card reveal'); ?>>
              <?php if ( has_post_thumbnail() ) : ?>
                <a href="<?php the_permalink(); ?>" class="card-img-wrap">
                  <?php the_post_thumbnail('village-card', ['class'=>'card-img','loading'=>'lazy']); ?>
                </a>
              <?php endif; ?>
              <div class="card-body">
                <div class="card-meta">
                  <?php
                  $cats = get_the_category();
                  if ($cats) echo '<span class="badge">' . esc_html($cats[0]->name) . '</span>';
                  ?>
                  <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                </div>
                <h2 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <p class="card-excerpt"><?php the_excerpt(); ?></p>
                <a href="<?php the_permalink(); ?>" class="card-link"><?php _e('Read More','village-connect'); ?> &rarr;</a>
              </div>
            </article>
          <?php endwhile; ?>
        </div>

        <nav class="pagination reveal" aria-label="<?php esc_attr_e('Posts navigation','village-connect'); ?>">
          <?php village_pagination(); ?>
        </nav>

      <?php else : ?>
        <p class="no-posts reveal"><?php _e('No posts found.','village-connect'); ?></p>
      <?php endif; ?>

    </div><!-- .content-area -->

    <?php if ( is_active_sidebar('sidebar-1') ) : ?>
      <aside class="sidebar" aria-label="<?php esc_attr_e('Sidebar','village-connect'); ?>">
        <?php dynamic_sidebar('sidebar-1'); ?>
      </aside>
    <?php endif; ?>

  </div>
</main>

<?php get_footer(); ?>
