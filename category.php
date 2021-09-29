
    <!-- pageheader
    ================================================== -->
    <?php get_header();?>


<!-- s-content
================================================== -->
<section class="s-content">

        <div class="row narrow">
            <div class="col-full s-content__header" data-aos="fade-up">
                <!-- <h1>Category: Lifestyle</h1> -->
                <h1><?php single_cat_title(); ?></h1>
                
                <p class="lead"><?php echo category_description(); ?></p>
            </div>
        </div>

    
    <div class="row masonry-wrap">
        <div class="masonry">

            <div class="grid-sizer"></div>

            <!-- remove if it has no category and show no category  -->
            <?php 
             if( ! have_posts() ):
            ?>
            <h4 class="align-center"><?php _e( "There is no post in this category", "philosophy" ); ?><h4>
            <?php endif;?>

            <!-- load all articale with post type  -->
            <?php
            while(have_posts()){
                the_post();

                get_template_part( "template-parts/post-formats/post",get_post_format());
                
            }
            ?>


        </div> <!-- end masonry -->
    </div> <!-- end masonry-wrap -->

    <!-- <div class="row">
        <div class="col-full">
            <nav class="pgn">
                <ul>
                    <li><a class="pgn__prev" href="#0">Prev</a></li>
                    <li><a class="pgn__num" href="#0">1</a></li>
                    <li><span class="pgn__num current">2</span></li>
                    <li><a class="pgn__num" href="#0">3</a></li>
                    <li><a class="pgn__num" href="#0">4</a></li>
                    <li><a class="pgn__num" href="#0">5</a></li>
                    <li><span class="pgn__num dots">…</span></li>
                    <li><a class="pgn__num" href="#0">8</a></li>
                    <li><a class="pgn__next" href="#0">Next</a></li>
                </ul>
            </nav>
        </div>
    </div> -->


    <div class="row">
        <div class="col-full">
            <nav class="pgn">
                <?php philosophy_pagination(); ?>
            </nav>
        </div>
    </div>

</section> <!-- s-content -->


<!-- s-extra
================================================== -->
<?php get_footer();?>