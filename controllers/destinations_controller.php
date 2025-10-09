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
function destinations_cdn() 
{
    $data = [
        'stylesheets' => [
            'assets/css/voyages.css',
            'assets/css/cdn.css',
        ]
    ];
    load_view_with_layout('destinations/cdn', $data);
}
function destinations_japon() 
{
    $data = [
        'stylesheets' => [
            'assets/css/voyages.css',
            'assets/css/japon.css',
        ]
    ];
    load_view_with_layout('destinations/japon', $data);
}