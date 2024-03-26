<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

return <<<EOF
<a href="{{permalink}}" id="{{id}}" class="{{responsive_item_class}} search__results__item">
    <div class="search__results__inner__wrap">
        <canvas width="3" height="2" style="background-image:url({{image}})"></canvas>
        <div class="search__results__item__description">
            <h3>{{title}}</h3>
            <h6><i class="icon bicon bi-pin-fill"></i>{{address}}</h6>
        </div>
    </div>
</a>
EOF;
