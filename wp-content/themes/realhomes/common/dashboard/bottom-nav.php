<?php
global $dashboard_posts_query;
if ( ! empty( $dashboard_posts_query ) && $dashboard_posts_query->have_posts() ) : ?>
    <div class="dashboard-posts-list-bottomnav"><?php inspiry_theme_pagination( $dashboard_posts_query->max_num_pages ); ?></div>
<?php
endif;