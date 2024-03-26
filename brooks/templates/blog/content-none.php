<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

    <h3><?php printf( esc_html__( 'Ready to publish your first post? %1$sGet started here.', 'brooks' ), '<a href="'.admin_url( 'post-new.php' ).'">', '</a>' ); ?></h3>

<?php elseif ( is_search() ) : ?>

    <div class="brooks__not__found">
        <img  src="<?php echo BROOKS_IMAGES; ?>/not-found.svg" alt="">
        <h2><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'brooks' ); ?></h2>
        <form class="input-field" method="get" id="searchform" action="<?php echo esc_url( home_url() ); ?>/">
            <div>
                <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" />
                <input class=" btn btn-clock btn-color"type="submit" id="searchsubmit" value="<?php esc_html_e( 'PLEASE TRY AGAIN', 'brooks' ); ?>" placeholder="<?php esc_html_e( 'SEARCH', 'brooks' ); ?>" />
            </div>
        </form>

    </div>
<?php else : ?>

    <h3><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'brooks' ); ?></h3>

<?php endif; ?>