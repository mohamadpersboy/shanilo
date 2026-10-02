<?php

return [

    'uploader_folder' => storage_path() . '/app/public/',

    'temp_folder' => 'temp',

    'fine_uploader' => [

        'allowed_extensions' => ['mp4','mp3'],
        'size_limit'    => 128*1024*1024, // 20 Mb
        'input_name'    => 'qqfile',
        'chunks_folder' => 'chunks'

    ],

    // Can be overridden by client
    'thumbnails' => [
        'height' => 100,
        'width' => 100,
        'crop' => 'fill'
    ],

    'storage' => 'local',

    'storage_url_resolver' => function($file) {
        return '/' . $file->getUploaderPath() . '/' . $file->getFilename();
    },

    'success_response_class' => Optimus\FineuploaderServer\Response\OptimusResponse::class,

    'storages' => [

        'local' => [
            'class' => Optimus\FineuploaderServer\Storage\LocalStorage::class,
            'config' => [
                'root_folder' => storage_path() . '/app/public/'
            ]
        ]

    ],

    'naming_strategy' => Optimus\FineuploaderServer\Naming\UniqidStrategy::class,

    'middleware' => [
//        [
//            'class' => Optimus\FineuploaderServer\Middleware\ThumbnailCreator::class,
//            'config' => [
//
//            ]
//        ]
    ]

];
