@include('vendor/autoload.php')

@setup
    $envoyer = (isset($stage)) ? new Ck\Envoyer\Envoyer($stage) : new Ck\Envoyer\Envoyer();
    $releases = $envoyer->deployTo() . '/releases';
    $shared = $envoyer->deployTo() . '/shared';
    $current = $envoyer->deployTo() . '/current';
    $release = $releases . '/' . date('YmdHis');
@endsetup

@servers($envoyer->getServers())

@macro('deploy', ['on' => $envoyer->getStage())], 'parallel' => $envoyer->isParallel())
    init
    clone
    env
    share
    composer
    npm
    elixir
    permissions
    migration
    current
@endmacro

@task('init')
    mkdir -p {{ $envoyer->getCurrentPath() }};
    mkdir -p {{ $envoyer->getReleasesPath() }};
    mkdir -p {{ $envoyer->getSharedPath() }};
    echo 'Server initialization successfully  ✔';
@endtask

@task('clone')
    cd {{ $envoyer->getReleasesPath() }};
    git clone {{ $envoyer->getRepository() }} --branch={{ $envoyer->getBranch() }} --depth=1 --quiet {{ $release }};
    echo 'Repository cloned  ✔';
@endtask

@task('env')
    mv {{ $release }}/.env.example {{ $release }}/.env;
    cd {{ $release }};
    php artisan key:generate | echo 'env';
@endtask

@task('share')
@foreach($envoyer->getShared() as $share)
    mkdir -p {{ $shared }}/vendor;
    ln -s {{ $shared }}/vendor {{ $envoy->getReleasePath() }}/{{ $share }};
    echo 'Folders shared  ✔';
@endforeach
@endtask

@task('composer')
    cd {{ $release }}
    composer install --quiet
    echo 'PHP Dependancy installed  ✔';
@endtask

@task('npm')
    npm i -g gulp bower
    cd {{ $release }}
    npm i
    echo 'Node Dependancy installed  ✔';
@endtask

@task('elixir')
    cd {{ $release }}
    gulp
    echo 'PHP Dependancy installed  ✔';
@endtask

@task('permissions')
    chmod -R 777 {{ $release }}/storage
@endtask

@task('current')
    rm -Rf {{ $current }};
    ln -s {{ $release }} {{ $current }};
    ls {{ $releases }} | sort -r | tail -n +{{ $envoyer->getKeepReleases() }} | xargs -r -I{} rm -rf {{ $releases }}/{};
@endtask