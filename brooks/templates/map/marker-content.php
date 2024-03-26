<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

return <<<EOF
<div class="theme__map__infobox -post__infobox">
	<div class="infobox__inner">
		<div class="infobox__image" style="background-image: url({{image}})"></div>
		<div class="infobox__title">
			<h6>
				<a href="{{permalink}}">
					{{title}}
				</a>
			</h6>
		</div>
		<div class="infobox__cover">
		    <h4>{{type}}</h4>
		    <address>
		        <div>
		            <a href="tel:{{phone}}">{{phone}}</a>
		        </div>
		        <div>
		            <a href="mailto:{{email}}">{{email}}</a>
		        </div>
		        <div>
		            {{address}}
		        </div>
		    </address>
		</div>
	</div>
</div>
EOF;
