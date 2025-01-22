<?php

return [
    'name' => 'ReportFIA',
    'manifest' => [
        'name' => env('APP_NAME', 'My PWA App'),
        'short_name' => 'ReportFIA',
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation' => 'any',
        'status_bar' => 'black',
        'icons' => [
            '72x72' => [
                'path' => '/assets/img/icons/icon-72x72.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/assets/img/icons/icon-96x96.png',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => '/assets/img/icons/icon-128x128.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/assets/img/icons/icon-144x144.png',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => '/assets/img/icons/icon-152x152.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/assets/img/icons/icon-192x192.png',
                'purpose' => 'any'
            ],
            '256x256' => [
                'path' => '/assets/img/icons/icon-256x256.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/assets/img/icons/icon-512x512.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => '/assets/img/icons/splash-640x1136.png',
            '750x1334' => '/assets/img/icons/splash-750x1334.png',
            '828x1792' => '/assets/img/icons/splash-828x1792.png',
            '1125x2436' => '/assets/img/icons/splash-1125x2436.png',
            '1242x2208' => '/assets/img/icons/splash-1242x2208.png',
            '1242x2688' => '/assets/img/icons/splash-1242x2688.png',
            '1536x2048' => '/assets/img/icons/splash-1536x2048.png',
            '1668x2224' => '/assets/img/icons/splash-1668x2224.png',
            '1668x2388' => '/assets/img/icons/splash-1668x2388.png',
            '2048x2732' => '/assets/img/icons/splash-2048x2732.png',
        ],
        'custom' => [
            'description' => 'ReportFIA es una aplicación para el reporte de incidencias en la FIA.',
            'screenshots' =>  [
                [
                    'src' => '/assets/img/screenshots/detalle-reporte.png',
                    'sizes' => '1882x870',
                    'type' => 'image/png',
                    'form_factor' => 'wide',
                    'label' => 'Detalle de reporte'
                ],
                [
                    'src' => '/assets/img/screenshots/inicio-mobile.png',
                    'sizes' => '1170x2531',
                    'type' => 'image/png',
                    'form_factor' => 'narrow',
                    'label' => 'Inicio'
                ],
                [
                    'src' => '/assets/img/screenshots/listado-reporte-mobile.png',
                    'sizes' => '1170x2531',
                    'type' => 'image/png',
                    'form_factor' => 'narrow',
                    'label' => 'Listado de reportes'
                ],
                [
                    'src' => '/assets/img/screenshots/detalle-reporte-mobile.png',
                    'sizes' => '1170x2531',
                    'type' => 'image/png',
                    'form_factor' => 'narrow',
                    'label' => 'Detalle de reporte'
                ]
            ],
            'shortcuts' => [
                [
                    'name' => 'Inicio',
                    'description' => 'Inicio de la aplicación',
                    'url' => '/inicio',
                    'icons' => [
                        [
                            'src' => '/assets/img/icons/icon-96x96.png',
                            'sizes' => '96x96',
                            'type' => 'image/png',
                            'purpose' => 'any'
                        ]
                    ]
                ],
                [
                    'name' => 'Reportes',
                    'description' => 'Listado de reportes',
                    'url' => '/reportes/listado-general',
                    'icons' => [
                        [
                            'src' => '/assets/img/icons/icon-96x96.png',
                            'sizes' => '96x96',
                            'type' => 'image/png',
                            'purpose' => 'any'
                        ]
                    ]
                ]
            ],
        ],
    ]
];
