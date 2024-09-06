<?php

return [

    'default' => 'default',
    'documentations' => [
        'default' => [
            'info' => [
                'title' => 'API de Livros',
                'description' => 'Documentação da API de Livros e Usuários',
                'version' => '1.0.0',
            ],
            'servers' => [
                [
                    'url' => env('APP_URL', 'http://127.0.0.1:8000'),
                ],
            ],
        ],
    ],

    'paths' => [
        'annotations' => [
            base_path('app/Http/Controllers'),  // Diretório onde estão suas anotações
        ],
        'docs' => storage_path('api-docs'),  // Diretório onde os arquivos da documentação serão gerados
        'docs_json' => 'api-docs.json',      // Nome do arquivo JSON gerado
        'docs_yaml' => 'api-docs.yaml',      // Nome do arquivo YAML gerado
        'format_to_use_for_docs' => 'json',  // Formato da documentação (json ou yaml)
        'excludes' => [],                   // Diretórios ou arquivos a serem excluídos
    ],

    'generate_always' => false,  // Gera a documentação sempre que o projeto é atualizado

    'swagger_version' => '3.0',

    'securityDefinitions' => [
        'bearerAuth' => [
            'type' => 'apiKey',
            'name' => 'Authorization',
            'in' => 'header',
            'scheme' => 'bearer',
        ],
    ],
];
