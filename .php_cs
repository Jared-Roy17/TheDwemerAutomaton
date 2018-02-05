<?php
$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__.'/app');
return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'binary_operator_spaces' => [
            'align_double_arrow' => true,
            'align_equals' => true
        ],
        'ordered_imports' => true,
        'array_syntax' => [
            'syntax' => 'short'
        ],
    ])
    ->setFinder($finder);