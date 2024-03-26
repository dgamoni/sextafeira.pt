<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

return <<<EOF
<div class="theme__map__infobox -simple__infobox" style="width:{{width}}px;height:{{height}}px">
    <h6>{{title}}</h6>
    <p>{{desc}}</p>
</div>
EOF;
