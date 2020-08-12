<?php
/**
 * The Template for displaying all single posts.
 *
 * @package enigma
 */

get_header();
$breadcrumb = get_theme_mod('breadcrumb', 1);
$class = '';
if ($breadcrumb == 1) {
    get_template_part('breadcrums');
} else {
    $class = 'no-breadcrumb';
}
?>
    <div class="container">
        <div class="row enigma_blog_wrapper <?php echo esc_attr($class); ?>">
            <div class="col-md-8">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/post', 'content');
                endwhile;
                else :
                    get_template_part('template-parts/nocontent');
                endif;
                ?>
                <div class="text-center wl-theme-pagination">
                    <?php echo esc_html(the_posts_pagination(array('mid_size' => 2))); ?>
                    <div class="clearfix"></div>
                </div>
                <?php
                comments_template('', true);
                ?>
            </div>
            <?php get_sidebar(); ?>
        </div> <!-- row div end here -->
    </div><!-- container div end here -->
<?php get_footer(); ?>