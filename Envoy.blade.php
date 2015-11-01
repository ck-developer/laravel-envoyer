@include('vendor/autoload.php')

@setup
    $envoyer = (isset($stage)) ? new Ck\Envoyer\Envoyer($stage) : new Ck\Envoyer\Envoyer();
    $releases = $envoyer->deployTo() . '/releases';
    $shared = $envoyer->deployTo() . '/shared';
    $current = $envoyer->deployTo() . '/current';
    $release = $releases . '/' . date('YmdHis');
@endsetup

@servers($envoyer->getSsh())

@macro('deploy')
    init
    clone
    composer
    env
    permissions
    current
@endmacro

@task('init')
    mkdir -p {{ $current }};
    mkdir -p {{ $releases }};
    mkdir -p {{ $shared }};
    echo 'Server initialization successfully  ✔';
@endtask

@task('clone')
    cd {{ $releases }};
    git clone {{ $envoyer->getRepository() }} --branch={{ $envoyer->getBranch() }} --depth=1 --quiet {{ $release }};
    echo 'Repository cloned  ✔';
@endtask

@task('composer')
    mkdir -p {{ $shared }}/vendor;
    ln -s {{ $shared }}/vendor {{ $release }}/vendor;
    cd {{ $release }}
    composer install --quiet
    echo 'Dependancy installed  ✔';
@endtask

@task('env')
    mv {{ $release }}/.env.example {{ $release }}/.env;
    cd {{ $release }};
    php artisan key:generate | echo 'env';
@endtask

@task('permissions')
    chmod -R 777 {{ $release }}/storage
@endtask

@task('current')
    rm -Rf {{ $current }};
    ln -s {{ $release }} {{ $current }};
    ls {{ $releases }} | sort -r | tail -n +{{ $envoyer->getKeepReleases() }} | xargs -r -I{} rm -rf {{ $releases }}/{};
@endtask