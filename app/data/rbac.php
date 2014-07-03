<?php
return [
    'items' => [
        'accessAdmin' => [
            'type' => 2,
            'description' => 'access to admin panel',
        ],
        'rootAccess' => [
            'type' => 2,
            'description' => 'root access to admin panel',
        ],
        'createModel' => [
            'type' => 2,
            'description' => 'create model',
        ],
        'readModel' => [
            'type' => 2,
            'description' => 'read model',
        ],
        'updateModel' => [
            'type' => 2,
            'description' => 'update model',
        ],
        'deleteModel' => [
            'type' => 2,
            'description' => 'delete model',
        ],
        'listModels' => [
            'type' => 2,
            'description' => 'list models',
        ],
        'createModelRule' => [
            'type' => 2,
            'description' => 'create model',
            'ruleName' => 'canCreate',
            'children' => [
                'createModel',
            ],
        ],
        'readModelRule' => [
            'type' => 2,
            'description' => 'read model',
            'ruleName' => 'canRead',
            'children' => [
                'readModel',
            ],
        ],
        'updateModelRule' => [
            'type' => 2,
            'description' => 'update model',
            'ruleName' => 'canUpdate',
            'children' => [
                'updateModel',
            ],
        ],
        'deleteModelRule' => [
            'type' => 2,
            'description' => 'delete model',
            'ruleName' => 'canDelete',
            'children' => [
                'deleteModel',
            ],
        ],
        'listModelsRule' => [
            'type' => 2,
            'description' => 'list models',
            'ruleName' => 'canList',
            'children' => [
                'listModels',
            ],
        ],
        'user' => [
            'type' => 1,
        ],
        'manager' => [
            'type' => 1,
            'children' => [
                'accessAdmin',
                'listModelsRule',
                'createModelRule',
                'readModelRule',
                'updateModelRule',
                'deleteModelRule',
            ],
        ],
        'admin' => [
            'type' => 1,
            'children' => [
                'manager',
                'createModel',
                'readModel',
                'updateModel',
                'deleteModel',
                'listModels',
            ],
            'assignments' => [
                5 => [
                    'roleName' => 'admin',
                ],
            ],
        ],
        'root' => [
            'type' => 1,
            'children' => [
                'admin',
                'rootAccess',
            ],
            'assignments' => [
                1 => [
                    'roleName' => 'root',
                ],
            ],
        ],
    ],
    'rules' => [
        'canCreate' => 'O:32:"app\\modules\\main\\rbac\\CreateRule":3:{s:4:"name";s:9:"canCreate";s:9:"createdAt";N;s:9:"updatedAt";N;}',
        'canRead' => 'O:30:"app\\modules\\main\\rbac\\ReadRule":3:{s:4:"name";s:7:"canRead";s:9:"createdAt";N;s:9:"updatedAt";N;}',
        'canUpdate' => 'O:32:"app\\modules\\main\\rbac\\UpdateRule":3:{s:4:"name";s:9:"canUpdate";s:9:"createdAt";N;s:9:"updatedAt";N;}',
        'canDelete' => 'O:32:"app\\modules\\main\\rbac\\DeleteRule":3:{s:4:"name";s:9:"canDelete";s:9:"createdAt";N;s:9:"updatedAt";N;}',
        'canList' => 'O:30:"app\\modules\\main\\rbac\\ListRule":3:{s:4:"name";s:7:"canList";s:9:"createdAt";N;s:9:"updatedAt";N;}',
    ],
];
