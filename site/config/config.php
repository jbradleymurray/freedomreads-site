<?php

return [
    'debug' => false,
    'environment' => 'prod',
    'blocks' => [
        'fieldsets' => [
            'kirby' => [
                'label' => 'Kirby blocks',
                'type' => 'group',
                'fieldsets' => [
                    'heading',
                    'text',
                    'list',
                    'quote',
                    'image',
                    'video',
                    'markdown'
                ]
            ]
        ]
    ],
    'sylvainjule.locator.tiles' => 'mapbox',
    'sylvainjule.locator.mapbox.id' => 'mapbox/outdoors-v11',
    'sylvainjule.locator.mapbox.token' => 'pk.eyJ1IjoiZnJlZWRvbXJlYWRzIiwiYSI6ImNsdWJwM3Y5djB4N3UybW54aWw1cnVta3UifQ.nXaU5D0OsxOe4IxH2R_fBw',
    'thumbs' => [
        'srcsets' => [
            'default' => [
                '300w' => ['width' => 300],
                '600w' => ['width' => 600],
                '900w' => ['width' => 900],
                '1200w' => ['width' => 1200],
                '1800w' => ['width' => 1800]
            ],
            'webp' => [
                '300w' => ['width' => 300, 'format' => 'webp'],
                '600w' => ['width' => 600, 'format' => 'webp'],
                '900w' => ['width' => 900, 'format' => 'webp'],
                '1200w' => ['width' => 1200, 'format' => 'webp'],
                '1800w' => ['width' => 1800, 'format' => 'webp']
            ]
        ]
    ],
    'fatal' => function($kirby, $exception) {
        include $kirby->root('templates') . '/fatal.php';
    },
    'routes' => [
        // Exception for reginald-dwayne-betts
        [
        'pattern' => 'about/people/reginald-dwayne-betts',
        'action'  => function () {
            return page('about/people/reginald-dwayne-betts');
        }
        ],
        // Exception for Board of Directors
          [
            'pattern' => 'about/people/gara-lamarche',
            'action'  => function () {
                return go('about/people/board-of-directors/gara-lamarche');
            }
        ],
         
        [
            'pattern' => 'about/people/alex-duran',
            'action'  => function () {
                return go('about/people/board-of-directors/alex-duran');
            }
        ],
        [
            'pattern' => 'about/people/steve-levitt',
            'action'  => function () {
                return go('about/people/board-of-directors/steve-levitt');
            }
        ],[
        'pattern' => 'about/people/scott-semple',
        'action'  => function () {
            return go('about/people/board-of-directors/scott-semple');
        }
    ],
    [
        'pattern' => 'about/people/bryan-stevenson',
        'action'  => function () {
            return go('about/people/board-of-directors/bryan-stevenson');
        }
    ],
    [
        'pattern' => 'about/people/tracey-meares',
        'action'  => function () {
            return go('about/people/board-of-directors/tracey-meares');
        }
    ],
    [
        'pattern' => 'about/people/deborah-leff',
        'action'  => function () {
            return go('about/people/board-of-directors/deborah-leff');
        }
    ],
    [
        'pattern' => 'about/people/helena-huang',
        'action'  => function () {
            return go('about/people/board-of-directors/helena-huang');
        }
    ],
    [
        'pattern' => 'about/people/robert-raben',
        'action'  => function () {
            return go('about/people/board-of-directors/robert-raben');
        }
    ],
        // General redirect for all other people
        [
        'pattern' => 'about/people/(:any)',
        'action'  => function ($name) {
            return go('about/people/staff/' . $name);
        }
        ]
    ]
    
];
