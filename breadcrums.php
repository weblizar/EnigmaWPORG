<?php
$breadcrumb = get_theme_mod('breadcrumb', 1);
if ( $breadcrumb == 1) {
    $class = 'no-breadcrumb';
} else {
    $class = '';
}
?>
<div class="enigma_header_breadcrum_title <?php echo esc_attr($class); ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                if ($breadcrumb == 1) {
                    ?>
                    <h1><?php if (is_home()) {
                            echo "";
                        } else {
                            the_title();
                        } ?>
                    </h1>
                <?php } ?>
                <!-- BreadCrumb -->
                <?php if (function_exists('enigma_breadcrumbs')) enigma_breadcrumbs(); ?>
                <!-- BreadCrumb -->
            </div>
        </div>
    </div>
</div>