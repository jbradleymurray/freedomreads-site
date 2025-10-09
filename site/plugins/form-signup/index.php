<?php

Kirby::plugin('fr/form-signup', [
    'blueprints' => [
        'blocks/form-signup'  => __DIR__ . '/blueprints/blocks/form-signup.yml'
    ],
    'snippets'   => [
        'blocks/form-signup'  => __DIR__ . '/snippets/blocks/form-signup.php'
    ]
]);