<?php

return [
    'name' => 'laravel',
    'repository' => 'https://github.com/laravel/laravel.git',
    'default_stage' => 'prod',
    'stages' => [
        'prod' => [
            /**
             * SSH url to the server.
             */
            'server' => 'vagrant@127.0.0.1 -p 2222',

            /**
             * The path on the remote server where the application should be deployed.
             */
            'deploy_to' => '/home/vagrant/laravel/prod',

            /**
             * The branch name to be deployed from SCM.
             */
            'branch' => 'master',

            /**
             * The last n releases are kept for possible rollbacks.
             */
            'keep_releases' => 3,

            /**
             * The last n releases are kept for possible rollbacks.
             */
            'seeder' => false,
        ],
        'dev' => [
            /**
             * SSH url to the server.
             */
            'server' => 'vagrant@127.0.0.1 -p 2222',

            /**
             * The path on the remote server where the application should be deployed.
             */
            'deploy_to' => '/home/vagrant/laravel/dev',

            /**
             * The branch name to be deployed from SCM.
             */
            'branch' => 'develop',


            /**
             * The last n releases are kept for possible rollbacks.
             */
            'keep_releases' => 3,

            /**
             * The last n releases are kept for possible rollbacks.
             */
            'seeder' => true,
        ]
    ],
];