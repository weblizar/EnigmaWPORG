<?php // Template Name: Home Template
get_header();

if ( wl_theme_is_companion_active() ) {

    get_template_part('sections/home', 'slideshow');

    if ($sections = json_decode(get_theme_mod('home_reorder'), true)) {
        foreach ($sections as $section) {
            $data = $section . "_home";
            if (get_theme_mod($data, 1) == "1") {
                get_template_part('home', $section);
            }
        }
    } else {

        get_template_part('sections/home', 'services');
        get_template_part('sections/home', 'portfolio');
        
        if (get_theme_mod('editor_home', 1) == 1) {
            get_template_part('sections/home', 'editor');
        }
        if (get_theme_mod('blog_home', 1) == 1) {
            get_template_part('sections/home', 'blog');
        }
    }

    if (get_theme_mod('fc_home', 1) == 1) {
        get_template_part('sections/footer', 'callout');
    }
} else { 
    get_template_part( 'template-parts/no', 'content' );
}
get_footer();