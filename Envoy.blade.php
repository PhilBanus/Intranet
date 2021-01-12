@servers(['web-1' => '10.4.252.4', 'web-2' => '10.4.252.5'])

@task('deploy', ['on' => ['web-1', 'web-2'], 'parallel' => true])
    cd site
    git pull origin {{ $branch }}
    php artisan migrate
@endtask