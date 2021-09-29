<?php 
/**
 * Template Name: Contact Us Page
 */
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
            </div> <!-- end s-content__header -->

            <div class="s-content__media col-full">
                <?php 
                //API-Key: // AIzaSyA6FF3J1dyLLSySF6pNpG4GQquG64Xv6Lk
                if(is_active_sidebar( "contact_maps" )){
                    dynamic_sidebar( "contact_maps" );
                }
                
                ?>
            </div> <!-- end s-content__media -->


            <div class="col-full s-content__main">

                <?php the_content(); ?>

                <!-- here about us widget -->

                <div class="row block-1-2 block-tab-full">
                   
                <?php 
                
                    if(is_active_sidebar( "contact_page" )){
                        dynamic_sidebar( "contact_page" );
                    }
                
                ?>

                </div>

                <h3><?php _e( "Say Hello.", "philosophy" ); ?></h3>

                <div name="cForm" id="cForm">
                
                    <?php 
                        if(get_field("contact_form_shortcode")){
                            echo do_shortcode(get_field("contact_form_shortcode"));
                        }
                    ?>

                </div>

                <!-- end form -->

            </div> <!-- end s-content__main -->

        </article>
        

    </section> <!-- s-content -->


    <!-- s-extra
    ================================================== -->
    <?php get_footer();?>