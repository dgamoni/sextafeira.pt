<?php
/**
 * Class Brooks_Footer_Action_Content
 *
 * Attach html output to wp_footer action
 */
class Brooks_Footer_Action_Content {
    function __construct($body = '', $modal_id = '', $title = '') {
        if(empty($body))
            return;
        $this->body = $body;

        add_action( 'wp_footer', array(&$this, 'the_content') );
    }

    public function the_content() {
        echo $this->body;
    }
}