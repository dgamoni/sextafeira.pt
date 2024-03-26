<?php
/**
 * The template for displaying comments.
 */

// Do not delete these sympathiques
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die ('Please do not load this page directly. Thanks!');
?>

<div class="comment__section">
    <div class="row">
        <div class="col-md-12">
            <?php if ( post_password_required() ): ?>
                <p class="no-comments"><?php esc_html_e('This post is password protected. Enter the password to view comments.', 'brooks'); ?></p>
            <?php
                return;
            endif; ?>

            <?php wp_enqueue_script( 'comment-reply' ); ?>

            <?php if ( have_comments() ) : ?>
                <h2><?php comments_number(esc_html__('NO COMMENTS', 'brooks'), esc_html__('COMMENTS (1)', 'brooks'), esc_html__('COMMENTS (%)', 'brooks')); ?></h2>
                <div class="line__md"></div>

                <div class="comments">
                    <ul class="comments__list">
                        <?php wp_list_comments( array( 'type'=>'all', 'avatar_size' => 60, 'callback' => 'brooks_comment_template') ); ?>
                    </ul>

                    <div class="comments__navigation">
                        <div class="text-left"><?php previous_comments_link( '<i class="bicon bi-arrow-left"></i>' . esc_html__('Older Comments', 'brooks') ); ?></div>
                        <div class="text-right"><?php next_comments_link( esc_html__('Newer Comments', 'brooks') . '<i class="bicon bi-arrow-right"></i>' ); ?></div>
                    </div>
                </div>
                <div class="space__offset__xs__30 space__offset__md__50"></div>
            <?php endif; ?>


            <?php
                $commenter = wp_get_current_commenter();
                $req = get_option( 'require_name_email' );
                $aria_req = ( $req ? " aria-required='true'" : '' );

                comment_form(array(
                    'fields' => apply_filters( 'comment_form_default_fields', array(
                            'comment_notes_before' => '',
                            'comment_notes_after' => '',
                            'author' => '<div class="row"><div class="col-md-6"><div class="input-field"><input id="author" name="author" type="text" placeholder="'.esc_html__( 'Name', 'brooks' ). ( $req ? ' *' : '' ).'" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div></div>',
                            'email' => '<div class="col-md-6 p-l-md-0"><div class="input-field"><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" placeholder="'. esc_html__( 'Email', 'brooks' ) . ( $req ? ' *' : '' ) .'" ' . $aria_req . ' /></div></div></div>',
                            'url' => ''
                        )
                    ),
                    'logged_in_as' => '',
                    'comment_notes_before' => '',
                    'comment_notes_after' => '',
                    'title_reply_after' => '</h2><div class="line__md"></div>',
                    'title_reply_before' => '<h2>',
                    'title_reply' => esc_html__( 'LEAVE A COMMENT', 'brooks' ),
                    'comment_field' => '<div class="row"><div class="col-md-12"><div class="input-field"><textarea id="comment" placeholder="' . esc_html__( 'Your Comment', 'brooks' ) . ( $req ? ' *' : '' ) . '" name="comment" rows="8" aria-required="true" class="materialize-textarea"></textarea></div></div></div>',
                    'label_submit' => esc_html__( 'Submit Comment', 'brooks' ),
                    'class_submit' => 'btn btn-color waves-effect waves-light margin-top-20',
                    'id_submit' => 'submit_my_comment'

                ));
            ?>
            <div class="space__offset__xs__30 space__offset__md__50"></div>
        </div>
    </div>
</div>