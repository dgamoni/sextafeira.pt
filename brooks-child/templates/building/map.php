<?php
if(empty(rwmb_meta('address')) || empty(rwmb_meta('map')))
    return;

brooks_enqueue_custom('map');

$map_id = 'map_block_'.brooks_get_unique_id();
$map_preloader_id = 'map_block_'.brooks_get_unique_id();
$position = explode(',', rwmb_meta('map'));

$map_mode = '-normal';
$map_bw = false;
$map_bw = $map_bw?'-mono':'';

$map_settings = array(
    'center'        => array(
        'latitude'      => $position[0],
        'longitude'     => $position[1]
    ),
    'preloader'     => $map_preloader_id,
    'markerImage'   => BROOKS_IMAGES . '/40x40.png',
    'clusterImage'  => BROOKS_IMAGES . '/40x40.png',
    'markers'       => array(
        array(
            'latitude'          => $position[0],
                'longitude'         => $position[1],
            'markup'    => '<div class="simple-marker"><i class="bicon bi-pin-fill"></i></div>',
        )
    )
);

brooks_add_frontend_data( array('Data', 'Map', 'templates'), array( 'simple_marker_content' => include BROOKS_TEMPLATES . '/map/marker-simple-content.php') );
brooks_add_frontend_data( array('Data', 'Map', $map_id), $map_settings );
?>

<section class="theme__section">
    <div class="space__offset__xs__200"></div>
    <div class="theme__google__map__block  <?php echo $map_mode;?> <?php echo $map_bw;?>" id="<?php echo $map_id; ?>"></div>
    <div class="theme__google__map__preloader" id="<?php echo $map_preloader_id; ?>">
        <div class="preloader-wrapper active">
            <div class="spinner-layer">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div><div class="gap-patch">
                    <div class="circle"></div>
                </div><div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="space__offset__xs__200"></div>
</section>