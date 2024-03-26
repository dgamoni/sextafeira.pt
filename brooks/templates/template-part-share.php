<?php $id = 'share-' . brooks_get_unique_id();?>
<?php brooks_enqueue_custom( 'data-actions' );?>

<div class="theme__share-module">
    <div class="share-in" data-toggle="class" data-class="active" data-target="#<?php echo $id; ?>">
        <span class="bicon bi-share"></span>
    </div>
    <ul class="share-links" id="<?php echo $id; ?>" data-class="active">
        <li>
            <a href="#" data-share="twitter">
                <i class="bicon bi-twitter-fill"></i>
            </a>
        </li>
        <li>
            <a href="#" data-share="facebook">
                <i class="bicon bi-facebook-fill"></i>
            </a>
        </li>
        <li>
            <a href="#" data-share="google">
                <i class="bicon bi-googleplus-fill"></i>
            </a>
        </li>
        <li>
            <a href="#" data-share="pinterest">
                <i class="bicon bi-pinterest-fill"></i>
            </a>
        </li>
        <li>
            <a href="#" data-share="linkedin"><i class="bicon bi-in-fill"></i>
            </a>
        </li>
    </ul>
</div>