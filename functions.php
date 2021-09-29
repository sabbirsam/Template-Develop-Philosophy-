<?php
/**
 * Require once
 */
require_once(get_theme_file_path( "/Inc/tgm.php" ));
require_once(get_theme_file_path( "/Inc/attachments.php" ));

if( site_url() == "http://localhost/sam/Theme_1/"){
    define( "VERSION" , time());
}else{
    define( "VERSION" , wp_get_theme()->get( "VERSION" ));
}

/**
 * =--------------------------------------After setup Theme
 */
function philosophy_theme_setup(){
    load_theme_textdomain( "philosophy" );
    
    add_theme_support( "post-thumbnails" );
    
    add_theme_support( "title-tag" );

    add_theme_support( 'html5', array( 'search-form','comment-list','comment-form','gallery', 'caption' ) );

    add_theme_support( "post-formats", array('aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat') );

    add_editor_style( "/assets/css/editor-style.css" );  

    register_nav_menu( "topmenu", __("Top Menu", "philosophy") );

    add_image_size( "philosophy-home-square", 400, 400, true );

}
add_action( "after_setup_theme", "philosophy_theme_setup");

/**
 * =----------------------------------------------------Enquiue Scripts 
 */

function philosophy_assets(){
    // css which is included on base.css:
    wp_enqueue_style( "fontawesome-css",get_theme_file_uri( '/assets/css/font-awesome/css/font-awesome.css' ),null,1.0); //handle | location | dependency | version | footer load 
    wp_enqueue_style( "fonts-css",get_theme_file_uri( '/assets/css/fonts.css' ),null,1.0); 
    
    //all css 
    wp_enqueue_style( "base-css",get_theme_file_uri( '/assets/css/base.css' ),null,1.0); 
    wp_enqueue_style( "vendor-css",get_theme_file_uri( '/assets/css/vendor.css' ),null,1.0); 
    wp_enqueue_style( "main-css",get_theme_file_uri( '/assets/css/main.css' ),null,1.0); 

    // Philosophy Theme css 
    wp_enqueue_style( "philosophy-css",get_stylesheet_uri(), null, VERSION ); // add main css

    //all header js
    wp_enqueue_script( "modernizr-js",get_theme_file_uri( "/assets/js/modernizr.js" ), null, 1.0 ); //handle | location | depedency | Version | header js so no footer
    wp_enqueue_script( "pace-min-js",get_theme_file_uri( "/assets/js/pace.min.js" ), null, 1.0 ); 


     //all Footer js and its dependent on jquery from the template
     wp_enqueue_script( "plugins-js",get_theme_file_uri( "/assets/js/plugins.js" ), array("jquery"), 1.0, true ); //handle | location | depedency | Version | header js so no footer
     wp_enqueue_script( "main-js",get_theme_file_uri( "/assets/js/main.js" ), array("jquery"), 1.0, true ); 
     wp_enqueue_script( "philosophy-main-js",get_theme_file_uri( "/assets/js/custom.js" ), array("jquery"), 1.0, true ); 
 

}
 add_action( "wp_enqueue_scripts", "philosophy_assets" );



 /**
  * add class on menu li if i have     'add_li_class'  => 'has-children'
 
 function philosophy_additional_class_on_li($classes, $item, $args) {
    if(isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'philosophy_additional_class_on_li', 1, 3);

or follow navwalker
 */


/**
 * Pagination
 * 
 <ul>
    <li><a class="pgn__prev" href="#0">Prev</a></li>
     <li><a class="pgn__num" href="#0">1</a></li>
 
     <li><a class="pgn__num" href="#0">8</a></li>
     <li><a class="pgn__next" href="#0">Next</a></li>
 </ul>
 */

 function philosophy_pagination(){
     global $wp_query;
     $links=  paginate_links( array(
        'current' => max(1,get_query_var( 'paged' )),
        'total' => $wp_query->max_num_pages,
        'type' => 'list',
        'mid_size'=>3
     ) );

     $links = str_replace("page-numbers","pgn__num" ,$links);
     $links = str_replace("<ul class='pgn__num'>","<ul>" ,$links);

     $links = str_replace("next pgn__num","pgn__next" ,$links);
     $links = str_replace("prev pgn__num","pgn__prev" ,$links);
     echo $links;
 }
 

/**
 * comment form modification 
*/

function mytheme_comment($comment, $args, $depth) {

    if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }?>

    <<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID() ?>"><?php 
    if ( 'div' != $args['style'] ) { ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body"><?php
    } ?>
    

            <div class="comment__avatar">
                <?php 
                    if ( $args['avatar_size'] != 0 ) {
                        echo get_avatar( $comment, $args['avatar_size'] ); 
                    } 
                    ?>
             </div>
             <div class="comment__content">
                <div class="comment__info">
                    <?php
                        printf( __( '<cite class="fn">%s</cite> <span class="says"> </span>' ), get_comment_author_link() ); 
                    ?>
                </div>
            </div>
        <?php 
        if ( $comment->comment_approved == '0' ) { ?>
            <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em><br/><?php 
        } ?>
        <div class="comment-meta commentmetadata">
            <time class="comment__time">
            
                <?php
                    /* translators: 1: date, 2: time */
                    printf( 
                        // __('%1$s at %2$s'), 
                        get_comment_date(),  
                        get_comment_time() 
                    ); 
                ?>
           </time><?php 
            edit_comment_link( __( '(Edit)' ), '  ', '' ); ?>
            <a class="reply"> 
            
            <?php 
                comment_reply_link( 
                    array_merge( 
                        $args, 
                        array( 
                            'add_below' => $add_below, 
                            'depth'     => $depth, 
                            'max_depth' => $args['max_depth'] 
                        ) 
                    ) 
                ); ?></a>
        </div>

        <div class="comment__text">
        <?php comment_text(); ?>            
        </div>
 
        
        <?php 
        if ( 'div' != $args['style'] ) : ?>
            </div>
        <?php 
        endif;
}
// end  


/**
 * category extra p tag remove 
*/
remove_filter('term_description','wpautop'); 


/** 
 * About us page widget 
*/

function philosophy_about_widget() {

    register_sidebar( array(
        'name'          => __( 'About Page','philosophy' ),
        'id'            => 'about_page',
        'description'   => 'Sidebar displaying in About Page.',
        'before_widget' => '<div id="%1$s" class="col-block %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="quarter-top-margin">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Contact Page','philosophy' ),
        'id'            => 'contact_page',
        'description'   => 'Sidebar displaying in Contact Page.',
        'before_widget' => '<div id="%1$s" class="col-block %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="quarter-top-margin">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Contact Page Maps','philosophy' ),
        'id'            => 'contact_maps',
        'description'   => 'Sidebar displaying in Contact Page as a map.',
        'before_widget' => '<div id="map-wrap %1$s" class="%2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer About section','philosophy' ),
        'id'            => 'footer_about_section',
        'description'   => 'Sidebar displaying in Footer.',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ) );
    

}

add_action( 'widgets_init', 'philosophy_about_widget' );