<?php

return [
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
    'branch' => 'dev-master',

    /**
     * The last n releases are kept for possible rollbacks.
     */
    'keep_releases' => 3,

    /**
     * Run
     */
    'seeder' => true,

    /**
     *
     */
    'node' => true,

    'elixir' => true,
];