<?php

    CONST RADIO = 1;
    CONST CHECKBOX = 2;
    CONST INPUT = 3;
    
    $form = [
        'q1' => [
            'title' => '被害の種類を選択してください。',
            'db' => true,
            'type' => RADIO,
            'require' => false,
            'key' => 'categories',
            'content' => [],
        ],
        'q2' => [
            'title' => '会員園、非会員園の選択をしてください。',
            'db' => false,
            'type' => RADIO,
            'require' => false,
            'content' => [
                'c1' => ['title' => '会員園', 'btn' => false],
                'c2' => ['title' => '非会員園', 'btn' => false],
            ],
        ],
        'q3' => [
            'title' => '保育施設・事業所のある郵便番号/都道府県/地域をご記入(選択して)ください。',
            'db' => false,
            'type' => INPUT,
            'form' => true,
            'require' => true,
            'content' => [
                'c1' => [
                    'select' => false,
                    'title' => '郵便番号',
                    'desc' => false,
                    'btn' => false,
                    'err' => true,
                    'className' => 'post_code',
                ],
                'c2' => [
                    'select' => true,
                    'title' => '都道府県',
                    'desc' => false,
                    'btn' => false,
                    'db' => true,
                    'key' => 'cities',
                    'err' => true,
                    'className' => 'city',
                ],
                'c3' => [
                    'select' => true,
                    'title' => '地域',
                    'desc' => false,
                    'btn' => true,
                    'custom' => [
                        'className' => 'c3-custom',
                        'title' => '絞り込む',
                    ],
                    'db' => true,
                    'key' => 'wards',
                    'err' => false,
                ],
                'c4' => [
                    'select' => true,
                    'title' => '施設名',
                    'desc' => true,
                    'desc-title' => '保育施設名もしくは、事業所名を記入してください。',
                    'btn' => false,
                    'db' => false,
                    'key' => 'name',
                    'err' => true,
                    'className' => 'name',
                ],
            ]
        ]
    ]

?>