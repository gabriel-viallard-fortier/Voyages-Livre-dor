<?php
function destinations_ethiopie() 
{
    $data = [
        'stylesheets' => [
            'assets/css/voyages.css',
            'assets/css/ethiopie.css',
        ]
    ];
    load_view_with_layout('destinations/ethiopie', $data);
}
function get_destinations_img_path($destination) 
{
    return PUBLIC_PATH . "/assets/images/" . $destination . "/";
}

function destinations_bali() 
{
        $data = [
        'stylesheets' => [
            'assets/css/voyages.css',
            'assets/css/bali.css',
        ]
    ];
    load_view_with_layout('destinations/bali', $data);
}