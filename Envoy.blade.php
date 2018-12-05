@servers(['remote' => 'clpt'])

@include('vendor/autoload.php')

@setup
    (new \Dotenv\Dotenv(__DIR__, '.env'))->load();
    $project = env('ENVOY_PROJECT_NAME');
    $project_directory = env('ENVOY_PROJECT_DIRECTORY');
    $app_directory = env('ENVOY_APP_DIRECTORY');
    $repo = env('ENVOY_GIT_REPOSITORY');
    $branch = env('ENVOY_DEPLOYMENT_BRANCH');
    $slack = env('ENVOY_SLACK_WEBHOOK');
@endsetup

@story('install')
    project:init
    git:clone
    permissions:set
    composer:install
    symlink:create
    env:generate
    key:generate
    optimize
@endstory

@story('update')
    down
    optimize:clear
    git:pull
    composer:update
    optimize
    up
@endstory

@task('project:init')
    echo "Checking directories...";
    [ -d {{ $project_directory }} ] || mkdir {{ $project_directory }};
    [ -d {{ $app_directory }}/{{ $project }} ] || mkdir {{ $app_directory }}/{{ $project }};
@endtask

@task('git:clone')
    echo "Cloning repository into {{ $project_directory }}";
    cd {{ $project_directory }};
    git clone -b {{ $branch }} {{ $repo }} {{ $project }};
@endtask

@task('git:pull')
    cd {{ $project_directory }}/{{ $project }};
    git checkout {{ $branch }};
    git reset --hard;
    git pull origin {{ $branch }};
@endtask

@task('git:reset')
    cd {{ $project_directory }}/{{ $project }};
    git reset --hard
@endtask

@task('permissions:set')
    echo "Setting permissions...";
    cd {{ $project_directory }}/{{ $project }};
    chmod -R ug+rwx {{ $project_directory }}/{{ $project }};
@endtask

@task('composer:install')
    echo "Installing composer dependencies...";
    cd {{ $project_directory }}/{{ $project }};
    composer install --prefer-dist --no-suggest -q;
    composer dump-autoload;
@endtask

@task('composer:update')
    echo "Updating composer dependencies...";
    cd {{ $project_directory }}/{{ $project }};
    composer update -q;
    composer dump-autoload;
@endtask

@task('symlink:create')
    echo "Creating symlink...";
    [ -d {{ $app_directory }}/{{ $project }} ] || mkdir {{ $app_directory }}/{{ $project }};
    cd {{ $project_directory }}/{{ $project }};
    mv public public_bak;
    ln -s {{ $app_directory }}/{{ $project }} public;
    cp -a public_bak/* public/;
    cp public_bak/.htaccess public/;
    rm -rf public_bak;
@endtask

@task('env:generate')
    echo "Generating env file...";
    cd {{ $project_directory }}/{{ $project }};
    cp .env.example .env;
@endtask

@task('key:generate')
    echo "Generating key...";
    cd {{ $project_directory }}/{{ $project }};
    php artisan key:generate;
@endtask

@task('up')
    cd {{ $project_directory }}/{{ $project }};
    php artisan up;
@endtask

@task('down')
    cd {{ $project_directory }}/{{ $project }};
    php artisan down;
@endtask

@task('migrate:fresh')
    cd {{ $project_directory }}/{{ $project }};
    php artisan migrate:fresh;
@endtask

@task('migrate:seed')
    cd {{ $project_directory }}/{{ $project }};
    php artisan migrate:fresh --seed;
@endtask

@task('optimize')
    cd {{ $project_directory }}/{{ $project }};
    php artisan optimize;
@endtask

@task('optimize:clear')
    cd {{ $project_directory }}/{{ $project }};
    php artisan optimize:clear;
@endtask

@finished
    echo "Complete! \r\n";
    @slack($slack, '#deployment')
@endfinished