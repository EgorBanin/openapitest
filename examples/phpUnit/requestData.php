<?php

return [
    '/users/{id}' => [
        'get' => [
            [
                'params' => [
                    'id' => 123,
                ],
                'expectedCode' =>  200,
            ],
            [
                'params' => [
                    'id' => 0,
                ],
                'expectedCode' =>  404,
            ],
        ],
    ],
];