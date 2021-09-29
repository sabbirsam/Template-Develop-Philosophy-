===============================================INITIAL WORK==================================================
1. Create Folder
2. create style.css

/*
Theme Name: Philosophy
Theme URI: https://wordpress.org/themes/philosophy/
Author: Sabbir Ahmed
Author URI: https://github/sabbirsam/
Description: Our 2019 default theme is designed to show off the power of the block editor. It features custom styles for all the default blocks, and is built so that what you see in the editor looks like what you'll see on your website. Twenty Nineteen is designed to be adaptable to a wide range of websites, whether youâ€™re running a photo blog, launching a new business, or supporting a non-profit. Featuring ample whitespace and modern sans-serif headlines paired with classic serif body text, it's built to be beautiful on all screen sizes.
Requires at least: 4.9.6
Requires PHP: 5.2.4
Version: 1.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: philosophy
Tags: one-column, flexible-header, accessibility-ready, custom-colors, custom-menu, custom-logo, editor-style, featured-images, footer-widgets, rtl-language-support

*/

3.make a markup folder and paste full markup
4. create index.php
5. create functions.php

==================***********========================******************====================================******************===========================================
==========================================================================
1. Make assets Folder and move all from markup
2. Open theme markup index.php and check all enque list 

==========================================================================    START ==========================================================================(Part-1)

1. functions.php

start:-

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

}
add_action( "after_setup_theme", "philosophy_theme_setup");

/**
 * =----------------------------------------------------Enquiue Scripts 
 */



function philosophy_assets(){
    // css which is included on base.css:
    wp_enqueue_style( "fontawesome-css",get_theme_file_uri( '/assets/css/font-awesome/css/font-awesome.css' ),null,VERSION); //handle | location | dependency | version | footer load 
    wp_enqueue_style( "fonts-css",get_theme_file_uri( '/assets/css/fonts.css' ),null,VERSION); 
    
    //all css 
    wp_enqueue_style( "base-css",get_theme_file_uri( '/assets/css/base.css' ),null,VERSION); 
    wp_enqueue_style( "vendor-css",get_theme_file_uri( '/assets/css/vendor.css' ),null,VERSION); 
    wp_enqueue_style( "main-css",get_theme_file_uri( '/assets/css/main.css' ),null,VERSION); 

    // Philosophy Theme css 
    wp_enqueue_style( "philosophy-css",get_stylesheet_uri(), null, VERSION ); // add main css

    //all header js
    wp_enqueue_script( "modernizr-js",get_theme_file_uri( "/assets/js/modernizr.js" ), null, VERSION ); //handle | location | depedency | Version | header js so no footer
    wp_enqueue_script( "pace-min-js",get_theme_file_uri( "/assets/js/pace.min.js" ), null, VERSION ); 


     //all Footer js and its dependent on jquery from the template
     wp_enqueue_script( "plugins-js",get_theme_file_uri( "/assets/js/plugins.js" ), array("jquery"), VERSION, true ); //handle | location | depedency | Version | header js so no footer
     wp_enqueue_script( "main-js",get_theme_file_uri( "/assets/js/main.js" ), array("jquery"), VERSION, true ); 
 

}
 add_action( "wp_enqueue_scripts", "philosophy_assets" );

End:-
==========================================================================    START ==========================================================================(Part-2)
==================***********========================******************====================================******************===========================================

2.Copy all index html code to index.php
3. remove footer added js and set <?php wp_footer(); ?>
4. remove all header css+js and add <?php wp_head(); ?>

5. all image path set with <?php echo get_template_directory_uri();?>/assets/
example: 
<img src="<?php echo get_template_directory_uri();?>/assets/images/logo.svg" alt="Homepage">

==========================================================================    START ==========================================================================(Part-3)
==================***********========================******************====================================******************===========================================


1. Separate Header and Footer and check all are working or not.
2. header.php   :  <?php get_header()?>
3. footer.php    :  <?php get_footer();?>

4. add body_class();  : <body id="top" <?php body_class(); ?>>


==========================================================================    START ==========================================================================(Part-4)
==================***********========================******************====================================******************===========================================
18.5 header menu video 
1. Remove the header navigation menu and placed on template-parts/common/
<?php get_template_part( "template-parts/common/navigation" );?> <!--No need to add [.]php-->

2. create wp_nav_menu 

3. translate all hard coded text : 
==========================================================================    START ==========================================================================(Part-5)
==================***********========================******************====================================******************===========================================

18.6
1. Used acf to show featuref image on homepage {tag, title, autor name,title}
so use: http://tgmpluginactivation.com/  TGM plugins

create Inc and lib folder and now paste class-tgm-plugin-activation.php to lib and example.php to Inc and rename it tgm.php
2.set require_once on function.php 
require_once(get_theme_file_path( "/Inc/tgm.php" ));

3. tgm.php set require_once
require_once get_theme_file_path("/lib/class-tgm-plugin-activation.php");


4. now install require plugin


5. Make feature post show: 

$philosophy_fp = new WP_Query(
    array(
        'meta_key'=>'featured',
        'meta_value'=>'1',
        'posts_per_page'=>3
    )
    );

$post_data = array();

while($philosophy_fp->have_posts()){
    $philosophy_fp->the_post();

    $categories = get_the_category();

    $post_data[] = array(
        'title'=>get_the_title(),
        'date' =>get_the_date(  ),
        'thumbnail' => get_the_post_thumbnail_url(get_the_ID(),"large"),
        'author' =>get_the_author_meta( "display_name" ),  

        'author_avatar' => get_avatar_url( get_the_author_meta( "ID" ) ),

        'cat' => $categories[0]->name,
    );
}

if($philosophy_fp->post_count>1):

    <?php  for($i = 1; $i<3; $i++): ?>
    <?php endfor; ?>
<?php endif; ?>


==========================================================================    START ==========================================================================(Part-6)
==================***********========================******************====================================******************===========================================

18.7 

Work on Blog post to show by post formats
regenerate thumbnail 

end 

audio and video remain to fix

==========================================================================    START ==========================================================================(Part-7)
==================***********========================******************====================================******************===========================================

18.8 Blog home page pagination 


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
 

 then call the function :  <?php philosophy_pagination(); ?>
==========================================================================    START ==========================================================================(Part-8)
==================***********========================******************====================================******************===========================================

18.9 menu item class fix  same as pagination, just echo and then use str_replace 

==========================================================================    START ==========================================================================(Part-9)
==================***********========================******************====================================******************===========================================

Post Slider , audio and video fix 
1. With attatchment plugin. 
 n tgm add it: 
	array(
			'name'      => 'Attachments',
			'slug'      => 'attachments',
			'required'  => false,
		),
then require it: 
require_once(get_theme_file_path( "/Inc/attachments.php" ));

attatchment code: 


define( 'ATTACHMENTS_SETTINGS_SCREEN', false );
add_filter( 'attachments_default_instance', '__return_false');

function philosophy_attachments($attachments){
    // to show only gallery 
    $post_id = null;
    if( isset($_REQUEST['post']) || isset($_REQUEST['post_ID']) ){
        $post_id = empty($_REQUEST['post_ID']) ? $_REQUEST['post']: $_REQUEST['post_ID'];
    }

    if(! $post_id || get_post_format( $post_id )!= "gallery"){
        return;
    }
    // end 



    $fields= array(
        array(
            'name'=>'title',
            'type'=>'text',
            'label'=>__('Title', 'philosophy'),
        ),
    );

    $args = array(
        'label' =>'Gallery Slider',
        'post_type'=>array("post"),
        'filetype'=>array("image"),
        'note'=> 'Add Gallery Image',
        'button_text'=>__('Attatch Files', 'philosophy'),
        'fields'=> $fields,
    );

    $attachments ->register('gallery', $args);
}

add_action ('attachments_register','philosophy_attachments');



then use it: 


 <?php if(class_exists("Attachments")): 

      $attachments = new Attachments("gallery"); //this  gallery   was set on attatchment.php 
      if($attachments->exist()):
?>
                    <div class="entry__thumb slider">
                        <div class="slider__slides">

                        <?php
                        while($attachment = $attachments->get()):
                        ?>
                            
                            <div class="slider__slide">
                                <?php echo $attachments->image("philosophy-home-square");?>
                            </div>
                        <?php endwhile;?>
                            
                        </div>
                    </div>
    
                    <?php endif;?>
                    <?php endif;?>

==========================================================================    START ==========================================================================(Part-10)
==================***********========================******************====================================******************===========================================

Fix Audio and video with acf
18.11 
create field on acf make post format to video or audio condition 

then 
<?php 
$philosophy_video_file = "";

if(function_exists("the_field")){
    $philosophy_video_file = get_field("source_file");
}

?>
then  for video: 
 <a href="<?php echo esc_url( $philosophy_video_file ); ?>?color=01aef0&title=0&byline=0&portrait=0" data-lity>

 for audio: 
  <?if ($philosophy_audio_file): ?>
                        <div class="audio-wrap">
                             <!-- need to work here to get the audio  link  -->
                            <audio id="player" src="<?php echo esc_url($philosophy_audio_file); ?>" width="100%" height="42" controls="controls"></audio>
                        </div>
                        <?endif; ?>


==========================================================================    START ==========================================================================(Part-11)
==================***********========================******************====================================******************===========================================
18.12 Single Post: 
create single.php and copy all from single standard html



Single page 

<?php 
// as it single so write 
the_post();

get_header();

?>

    <!-- s-content
    ================================================== -->
    <section class="s-content s-content--narrow s-content--no-padding-bottom">

        <article class="row format-standard">

            <div class="s-content__header col-full">
                <h1 class="s-content__header-title">
                    <?php the_title( ); ?>
                </h1>
                <ul class="s-content__header-meta">
                    <li class="date"><?php echo get_the_date(); ?></li>
                    <li class="cat">
                        In
                        <?php echo get_the_category_list(" "); ?>
                    </li>
                </ul>
            </div> <!-- end s-content__header -->
    
            <div class="s-content__media col-full">
                <div class="s-content__post-thumb">
                    <?php the_post_thumbnail( "large" ); ?>
                </div>
            </div> <!-- end s-content__media -->

            <div class="col-full s-content__main">

                <?php the_content(); ?>
                <p class="s-content__tags">
                    <span>Post Tags</span>

                    <span class="s-content__tag-list">
                        <!-- the_tags("","","");  or below-->
                        <?php echo get_the_tag_list(); ?>
                    </span>
                </p> <!-- end s-content__tags -->

                <div class="s-content__author">
                    <!-- <img src="images/avatars/user-03.jpg" alt=""> -->
                    <?php echo get_avatar( get_the_author_meta( "ID" ) );?>

                    <div class="s-content__author-about">
                        <h4 class="s-content__author-name">
                            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta( "ID" ))); ?>"><?php the_author(); ?></a>
                        </h4>
                    
                        <p><?php the_author_meta("description") ;?></p>

                        <ul class="s-content__author-social">

                        <?php 
                        $philosophy_facebook = get_field("facebook", "user_".get_the_author_meta("ID"));
                        $philosophy_instagram = get_field("instagram", "user_".get_the_author_meta("ID"));
                        $philosophy_twitter = get_field("twitter", "user_".get_the_author_meta("ID"));
                        ?>
                           <?php 
                           if($philosophy_facebook):?>
                           <li><a href="<?php echo esc_url( $philosophy_facebook ); ?>">Facebook</a></li>
                           <?php endif; ?>

                           <?php 
                           if($philosophy_facebook):?>
                           <li><a href="<?php echo esc_url( $philosophy_instagram ); ?>">Instragram</a></li>
                           <?php endif; ?>

                           <?php 
                           if($philosophy_facebook):?>
                           <li><a href="<?php echo esc_url( $philosophy_twitter ); ?>">Twitter</a></li>
                           <?php endif; ?>
                           
                        
                        </ul>
                    </div>
                </div>

                <div class="s-content__pagenav">
                    <div class="s-content__nav">
                        <div class="s-content__prev">

                        <?php 
                        $philosophy_prev_post = get_previous_post( );
                        if($philosophy_prev_post):
                        ?>
                            <a href="<?php echo get_the_permalink($philosophy_prev_post); ?>" rel="prev">
                                <span><?php _e( "Previous Post", "philosophy" )?></span>
                               <?php echo get_the_title( $philosophy_prev_post ); ?>
                            </a>
                        <?php endif; ?>
                        </div>

                        <div class="s-content__next">

                        <?php 
                        $philosophy_next_post = get_next_post( );
                        if($philosophy_next_post):
                        ?>
                            <a href="<?php echo get_the_permalink($philosophy_next_post); ?>" rel="next">
                                <span><?php _e( "Next Post", "philosophy" )?></span>
                               <?php echo get_the_title( $philosophy_next_post ); ?>
                            </a>
                        <?php endif; ?>
                        </div>
                    </div>
                </div> <!-- end s-content__pagenav -->

            </div> <!-- end s-content__main -->

        </article>


        End=========================================


==========================================================================    START ==========================================================================(Part-12)
==================***********========================******************====================================******************===========================================
Comment form
18.13 single post comment 


 <?php 
        if(!post_password_required()){
            comments_template();
        }
        
        ?>

function.php

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



==========================================================================    START ==========================================================================(Part-12)
==================***********========================******************====================================******************===========================================
18.14 category archieve 
 <div class="row narrow">
            <div class="col-full s-content__header" data-aos="fade-up">
                <!-- <h1>Category: Lifestyle</h1> -->
                <h1><?php single_cat_title(); ?></h1>
                
                <p class="lead"><?php echo category_description(); ?></p>
            </div>
        </div>


        // category extra p tag remove 
remove_filter('term_description','wpautop'); 

==========================================================================    START ==========================================================================(Part-13)
==================***********========================******************====================================******************===========================================

ABOUT US Page :

18.15 


