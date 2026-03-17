<footer class="site-footer">
  <div class="container footer-grid">

    <?php if ( is_active_sidebar('footer-1') ) : ?>
      <div class="footer-col"><?php dynamic_sidebar('footer-1'); ?></div>
    <?php else : ?>
      <div class="footer-col">
        <h4 class="widget-title"><?php echo village_mod('village_name', get_bloginfo('name')); ?></h4>
        <?php $tagline = get_theme_mod('village_tagline',''); if ($tagline) echo '<p>' . esc_html($tagline) . '</p>'; ?>
        <?php
        $fb  = get_theme_mod('social_facebook','');
        $yt  = get_theme_mod('social_youtube','');
        $wa  = get_theme_mod('social_whatsapp','');
        if ( $fb || $yt || $wa ) : ?>
          <div class="social-links">
            <?php if ($fb) echo '<a href="' . esc_url($fb) . '" target="_blank" rel="noopener" aria-label="Facebook">&#xFB;</a>'; ?>
            <?php if ($yt) echo '<a href="' . esc_url($yt) . '" target="_blank" rel="noopener" aria-label="YouTube">&#x25B6;</a>'; ?>
            <?php if ($wa) echo '<a href="https://wa.me/' . esc_attr(preg_replace('/\D/','',$wa)) . '" target="_blank" rel="noopener" aria-label="WhatsApp">&#x2709;</a>'; ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if ( is_active_sidebar('footer-2') ) : ?>
      <div class="footer-col"><?php dynamic_sidebar('footer-2'); ?></div>
    <?php else : ?>
      <div class="footer-col">
        <h4 class="widget-title"><?php _e('Quick Links', 'village-connect'); ?></h4>
        <?php wp_nav_menu([
          'theme_location' => 'footer',
          'menu_class'     => 'footer-nav',
          'container'      => false,
          'depth'          => 1,
          'fallback_cb'    => function() {
            echo '<ul class="footer-nav">';
            wp_list_pages(['title_li' => '', 'depth' => 1]);
            echo '</ul>';
          },
        ]); ?>
      </div>
    <?php endif; ?>

    <?php if ( is_active_sidebar('footer-3') ) : ?>
      <div class="footer-col"><?php dynamic_sidebar('footer-3'); ?></div>
    <?php else : ?>
      <div class="footer-col">
        <h4 class="widget-title"><?php _e('Contact', 'village-connect'); ?></h4>
        <?php
        $addr  = get_theme_mod('panchayat_address','');
        $phone = get_theme_mod('panchayat_phone','');
        $email = get_theme_mod('panchayat_email','');
        if ($addr)  echo '<p>&#x1F4CD; ' . nl2br(esc_html($addr)) . '</p>';
        if ($phone) echo '<p>&#x260E; <a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a></p>';
        if ($email) echo '<p>&#x2709; <a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a></p>';
        ?>
      </div>
    <?php endif; ?>

  </div>

  <div class="footer-bottom">
    <div class="container">
      <p>
        &copy; <?php echo date('Y'); ?>
        <?php echo village_mod('village_name', get_bloginfo('name')); ?>.
        <?php _e('All rights reserved.', 'village-connect'); ?>
        <?php
        $district = get_theme_mod('village_district','');
        $state    = get_theme_mod('village_state','');
        $loc = implode(', ', array_filter([$district, $state]));
        if ($loc) echo ' | ' . esc_html($loc);
        ?>
      </p>
    </div>
  </div>

</footer>
<?php wp_footer(); ?>
</body>
</html>
