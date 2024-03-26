<?php
$author = Brooks_Meta_Options::getData('author', get_the_ID());
$quote = Brooks_Meta_Options::getData('quote', get_the_ID());
$quote = empty($quote)?get_the_title():$quote;
?>
<i class="single__post__icon bicon bi-quote-close"></i>
<div class="quote__content">
    <?php echo $quote;?>
</div>
<h3><?php echo $author;?></h3>