<?php

Kirby::plugin('fr/quote-custom', [
    'blueprints' => [
        'blocks/quote-custom'  => __DIR__ . '/blueprints/blocks/quote-custom.yml'
    ],
    'snippets'   => [
        'blocks/quote-custom'  => __DIR__ . '/snippets/blocks/quote-custom.php'
    ]
]);