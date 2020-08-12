<?php get_header();
$breadcrumb = get_theme_mod('breadcrumb', 1);
$class = '';
if ($breadcrumb == 1) {
    get_template_part('breadcrums');
} else {
    $class = 'no-breadcrumb';
} ?>
    <div class="container">
        <div class="row enigma_blog_wrapper <?php echo esc_attr($class); ?>">
            <div class="col-md-8">
                <?php if (have_posts()):
                    while (have_posts()): the_post(); ?>
                        <?php get_template_part('template-parts/post', 'content'); ?>
                    <?php endwhile;
                endif; ?>
                <div class="text-center wl-theme-pagination">
                    <?php echo esc_html(the_posts_pagination(array('mid_size' => 2))); ?>
                    <div class="clearfix"></div>
                </div>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
<?php get_footer(); ?>