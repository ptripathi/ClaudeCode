<?php get_header(); ?>

<!-- ═══════════════════════════════════════
     HERO
═══════════════════════════════════════ -->
<section class="hero" id="hero">
  <?php if ( get_header_image() ) : ?>
    <div class="hero-bg" style="background-image:url('<?php header_image(); ?>')"></div>
  <?php else : ?>
    <div class="hero-bg hero-bg--default"></div>
  <?php endif; ?>
  <div class="hero-overlay"></div>
  <div class="container hero-content">
    <p class="hero-eyebrow reveal"><?php echo village_mod('village_district',''); ?><?php $s = get_theme_mod('village_state',''); if($s) echo ', ' . esc_html($s); ?></p>
    <h1 class="hero-title reveal"><?php echo village_mod('village_name', get_bloginfo('name')); ?></h1>
    <p class="hero-tagline reveal"><?php echo village_mod('village_tagline','Heritage · Culture · Community'); ?></p>
    <div class="hero-cta reveal">
      <a href="<?php echo esc_url(get_theme_mod('hero_btn_primary_url','#about')); ?>" class="btn btn-primary">
        <?php echo village_mod('hero_btn_primary','Explore Village'); ?>
      </a>
      <a href="<?php echo esc_url(get_theme_mod('hero_btn_secondary_url','#news')); ?>" class="btn btn-outline">
        <?php echo village_mod('hero_btn_secondary','Latest News'); ?>
      </a>
    </div>
  </div>
  <a href="#about" class="scroll-hint" aria-label="<?php esc_attr_e('Scroll down','village-connect'); ?>">
    <span class="scroll-arrow"></span>
  </a>
</section>

<!-- ═══════════════════════════════════════
     STATS BAR
═══════════════════════════════════════ -->
<?php
$pop  = get_theme_mod('village_population','');
$area = get_theme_mod('village_area','');
$dist = get_theme_mod('village_district','');
if ( $pop || $area || $dist ) : ?>
<section class="stats-bar reveal-section" id="stats">
  <div class="container stats-grid">
    <?php if ($pop) : ?>
      <div class="stat-item reveal">
        <span class="stat-number" data-target="<?php echo esc_attr(preg_replace('/\D/','',$pop)); ?>">0</span>
        <span class="stat-label"><?php _e('Population','village-connect'); ?></span>
      </div>
    <?php endif; ?>
    <?php if ($area) : ?>
      <div class="stat-item reveal">
        <span class="stat-number" data-target="<?php echo esc_attr(preg_replace('/[^0-9.]/','',str_replace(',','',$area))); ?>"
              data-suffix=" km²">0</span>
        <span class="stat-label"><?php _e('Total Area','village-connect'); ?></span>
      </div>
    <?php endif; ?>
    <?php if ($dist) : ?>
      <div class="stat-item reveal">
        <span class="stat-text"><?php echo esc_html($dist); ?></span>
        <span class="stat-label"><?php _e('District','village-connect'); ?></span>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════
     ABOUT
═══════════════════════════════════════ -->
<section class="section section--about reveal-section" id="about">
  <div class="container about-grid">
    <div class="about-image reveal">
      <?php
      $about_page = get_page_by_path('about');
      if ( $about_page && has_post_thumbnail($about_page->ID) ) {
        echo get_the_post_thumbnail($about_page->ID, 'village-card', ['class'=>'img-fluid']);
      } else {
        echo '<div class="img-placeholder">' . village_mod('village_name',get_bloginfo('name')) . '</div>';
      }
      ?>
    </div>
    <div class="about-text reveal">
      <span class="section-tag"><?php _e('About Us','village-connect'); ?></span>
      <h2 class="section-title"><?php _e('Our Village','village-connect'); ?></h2>
      <?php
      if ( $about_page ) {
        echo '<div class="prose">' . wp_trim_words($about_page->post_content, 80, '…') . '</div>';
        echo '<a href="' . esc_url(get_permalink($about_page->ID)) . '" class="btn btn-primary">'
           . __('Read More','village-connect') . '</a>';
      } else {
        echo '<p class="prose">' . get_bloginfo('description') . '</p>';
      }
      ?>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════
     LATEST NEWS
═══════════════════════════════════════ -->
<section class="section section--news section--alt reveal-section" id="news">
  <div class="container">
    <div class="section-header reveal">
      <span class="section-tag"><?php _e('Updates','village-connect'); ?></span>
      <h2 class="section-title"><?php _e('Latest News & Notices','village-connect'); ?></h2>
    </div>
    <div class="cards-grid">
      <?php
      $news = new WP_Query(['posts_per_page' => 3, 'post_status' => 'publish']);
      while ($news->have_posts()) : $news->the_post(); ?>
        <article class="card reveal">
          <?php if (has_post_thumbnail()) : ?>
            <a href="<?php the_permalink(); ?>" class="card-img-wrap">
              <?php the_post_thumbnail('village-card', ['class' => 'card-img', 'loading' => 'lazy']); ?>
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
            <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <p class="card-excerpt"><?php the_excerpt(); ?></p>
            <a href="<?php the_permalink(); ?>" class="card-link"><?php _e('Read More','village-connect'); ?> &rarr;</a>
          </div>
        </article>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <?php
    $news_page = get_page_by_path('news');
    $news_url  = $news_page ? get_permalink($news_page->ID) : get_permalink(get_option('page_for_posts'));
    ?>
    <div class="section-footer reveal">
      <a href="<?php echo esc_url($news_url ?: home_url('/news')); ?>" class="btn btn-outline-dark">
        <?php _e('View All News','village-connect'); ?>
      </a>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════
     GALLERY PREVIEW
═══════════════════════════════════════ -->
<section class="section section--gallery reveal-section" id="gallery">
  <div class="container">
    <div class="section-header reveal">
      <span class="section-tag"><?php _e('Memories','village-connect'); ?></span>
      <h2 class="section-title"><?php _e('Photo Gallery','village-connect'); ?></h2>
    </div>
    <div class="gallery-grid">
      <?php
      $media = new WP_Query([
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'post_status'    => 'inherit',
        'posts_per_page' => 6,
      ]);
      $count = 0;
      while ($media->have_posts() && $count < 6) : $media->the_post(); $count++; ?>
        <a href="<?php echo esc_url(wp_get_attachment_url(get_the_ID())); ?>"
           class="gallery-item reveal"
           data-lightbox="gallery">
          <?php echo wp_get_attachment_image(get_the_ID(), 'village-thumb', false, [
            'class'   => 'gallery-img',
            'loading' => 'lazy',
            'alt'     => esc_attr(get_the_title()),
          ]); ?>
        </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <div class="section-footer reveal">
      <?php
      $gallery_page = get_page_by_path('gallery');
      if ($gallery_page) : ?>
        <a href="<?php echo esc_url(get_permalink($gallery_page->ID)); ?>" class="btn btn-primary">
          <?php _e('View Full Gallery','village-connect'); ?>
        </a>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════
     CULTURE & FESTIVALS
═══════════════════════════════════════ -->
<?php
$culture_page = get_page_by_path('culture');
if ($culture_page) :
  $sub_pages = get_pages(['parent' => $culture_page->ID, 'number' => 4]);
?>
<section class="section section--culture section--alt reveal-section" id="culture">
  <div class="container">
    <div class="section-header reveal">
      <span class="section-tag"><?php _e('Heritage','village-connect'); ?></span>
      <h2 class="section-title"><?php _e('Culture & Festivals','village-connect'); ?></h2>
    </div>
    <?php if ($sub_pages) : ?>
      <div class="culture-grid">
        <?php foreach ($sub_pages as $p) : ?>
          <div class="culture-card reveal">
            <?php if (has_post_thumbnail($p->ID)) : ?>
              <?php echo get_the_post_thumbnail($p->ID, 'village-card', ['class' => 'culture-img', 'loading' => 'lazy']); ?>
            <?php endif; ?>
            <div class="culture-body">
              <h3 class="culture-title"><?php echo esc_html($p->post_title); ?></h3>
              <p><?php echo esc_html(wp_trim_words($p->post_content, 20, '…')); ?></p>
              <a href="<?php echo esc_url(get_permalink($p->ID)); ?>" class="card-link"><?php _e('Learn More','village-connect'); ?> &rarr;</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else : ?>
      <div class="prose reveal">
        <?php echo wp_trim_words($culture_page->post_content, 100, '…'); ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════
     CONTACT / PANCHAYAT
═══════════════════════════════════════ -->
<section class="section section--contact reveal-section" id="contact">
  <div class="container contact-grid">
    <div class="contact-info reveal">
      <span class="section-tag"><?php _e('Reach Us','village-connect'); ?></span>
      <h2 class="section-title"><?php _e('Gram Panchayat','village-connect'); ?></h2>
      <?php
      $addr  = get_theme_mod('panchayat_address','');
      $phone = get_theme_mod('panchayat_phone','');
      $email = get_theme_mod('panchayat_email','');
      $wa    = get_theme_mod('social_whatsapp','');
      if ($addr)  echo '<p class="contact-row"><strong>' . __('Address','village-connect') . ':</strong><br>' . nl2br(esc_html($addr)) . '</p>';
      if ($phone) echo '<p class="contact-row"><strong>' . __('Phone','village-connect') . ':</strong> <a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a></p>';
      if ($email) echo '<p class="contact-row"><strong>' . __('Email','village-connect') . ':</strong> <a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a></p>';
      if ($wa)    echo '<p class="contact-row"><a href="https://wa.me/' . esc_attr(preg_replace('/\D/','',$wa)) . '" class="btn btn-whatsapp" target="_blank" rel="noopener">' . __('Message on WhatsApp','village-connect') . '</a></p>';
      ?>
    </div>
    <div class="contact-form reveal">
      <?php
      $contact_page = get_page_by_path('contact');
      if ($contact_page) {
        // Render any shortcode on the contact page (e.g. WPForms, CF7)
        echo do_shortcode($contact_page->post_content);
      } else {
        echo '<p class="prose">' . __('Create a page with the slug <code>contact</code> and add your contact form shortcode there.','village-connect') . '</p>';
      }
      ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>
