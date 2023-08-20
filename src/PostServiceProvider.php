<?php
namespace Hussain\Post;
use Illuminate\Support\ServiceProvider;
class PostServiceProvider extends ServiceProvider{

    public function boot(){
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views','post');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }
    public function register(){

    }
}