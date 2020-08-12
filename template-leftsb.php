<?php
//Template Name:Page With Left Sidebar
get_header();
$breadcrumb = get_theme_mod('breadcrumb', 1);

$class = '';
if ($breadcrumb == 1) {
    get_template_part('breadcrums');
} else {
    $class = 'no-breadcrumb';
} ?>
    <div class="container">
        <div class="row enigma_blog_wrapper <?php echo esc_attr($class); ?>">
            <?php get_sidebar(); ?>
            <div class="col-md-8">
                <?php get_template_part('template-parts/post', 'page'); ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>