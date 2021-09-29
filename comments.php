<div class="comments-wrap">

            <div id="comments" class="row">
                <div class="col-full">

                    <!-- <h3 class="h2">5 Comments</h3> -->
                    <h3 class="h2">
                    <?php 
                        $philosophy_cn= get_comments_number();

                        if($philosophy_cn<=1){
                            echo $philosophy_cn." ".__("Comment","philosophy");
                        }else{
                            echo $philosophy_cn." ".__("Comments","philosophy");
                        }
                        ?>

                    </h3>

                    <!-- commentlist -->
                    <ol class="commentlist">

                        <?php wp_list_comments( 'type=comment&callback=mytheme_comment' ); ?>

                    </ol> <!-- end commentlist -->

                    <div class="comments_pagination">
                        <?php
                        the_comments_pagination(array(
                            'screen_reader_text'=>__("pagination", "philosophy"),
                            'prev_text'=> '<'.__("Previous", "philosophy"),
                            'prev_text'=> '>'.__("Previous", "philosophy"),
                        ));
                        ?>
                    </div>


                    <!-- respond
                    ================================================== -->
                    <div class="respond">

                    <h3 class="h2"><?php _e( "Add Comment", "philosophy" )?></h3>

                    <?php
                        if(!comments_open()){
                            _e( "Commets are clsoed", "philosophy" );
                        }
                        
                        $comments_args = array(
                            // change the title of send button 
                            'label_submit'=>'Send',
                            // change the title of the reply section
                            'title_reply'=>'Write a Reply or Comment',
                            // remove "Text or HTML to be displayed after the set of comment fields"
                            'comment_notes_after' => '',
                            // redefine your own textarea (the comment body)
                            'comment_field' => '<div class="message form-field">
                                                    <label for="comment">' . _x( 'Comment', 'noun' ) . '</label>
                                                   
                                                    <textarea id="comment" name="comment" class="full-width" placeholder="Your Message" aria-required="true">
                                                    </textarea>
                                                </div>',
                        );
                    
                        comment_form($comments_args);
                     ?>


                    </div> <!-- end respond -->

                </div> <!-- end col-full -->

            </div> <!-- end row comments -->
        </div> <!-- end comments-wrap -->