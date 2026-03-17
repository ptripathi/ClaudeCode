<?php get_header(); ?>

<main class="main-content" id="main">
  <?php while ( have_posts() ) : the_post(); ?>

    <article <?php post_class('single-post'); ?>>

      <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-hero">
          <?php the_post_thumbnail('village-hero', ['class' => 'post-hero-img']); ?>
          <div class="post-hero-overlay"></div>
          <div class="container post-hero-content">
            <div class="post-meta">
              <?php
              $cats = get_the_category();
              if ($cats) echo '<span class="badge">' . esc_html($cats[0]->name) . '</span>';
              ?>
              <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
            </div>
            <h1 class="post-title"><?php the_title(); ?></h1>
          </div>
        </div>
      <?php else : ?>
        <div class="container">
          <div class="post-meta">
            <?php
            $cats = get_the_category();
            if ($cats) echo '<span class="badge">' . esc_html($cats[0]->name) . '</span>';
            ?>
            <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
          </div>
          <h1 class="post-title"><?php the_title(); ?></h1>
        </div>
      <?php endif; ?>

      <div class="container post-body">
        <div class="prose">
          <?php the_content(); ?>
        </div>
        <footer class="post-footer">
          <?php the_tags('<div class="post-tags">', ' ', '</div>'); ?>
          <?php
          $prev = get_previous_post();
          $next = get_next_post();
          if ($prev || $next) : ?>
            <nav class="post-nav" aria-label="<?php esc_attr_e('Post navigation','village-connect'); ?>">
              <?php if ($prev) : ?>
                <a href="<?php echo esc_url(get_permalink($prev)); ?>" class="post-nav-link post-nav-prev">
                  <span>&larr; <?php _e('Previous','village-connect'); ?></span>
                  <strong><?php echo esc_html($prev->post_title); ?></strong>
                </a>
              <?php endif; ?>
              <?php if ($next) : ?>
                <a href="<?php echo esc_url(get_permalink($next)); ?>" class="post-nav-link post-nav-next">
                  <span><?php _e('Next','village-connect'); ?> &rarr;</span>
                  <strong><?php echo esc_html($next->post_title); ?></strong>
                </a>
              <?php endif; ?>
            </nav>
          <?php endif; ?>
        </footer>
      </div>

    </article>

    <?php if ( comments_open() || get_comments_number() ) : ?>
      <div class="container"><?php comments_template(); ?></div>
    <?php endif; ?>

  <?php endwhile; ?>
</main>

<?php get_footer(); ?>
