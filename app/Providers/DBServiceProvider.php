<?php

namespace App\Providers;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class DBServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // 不是所有的类都可以调用macro方法 只有类中use  Illuminate\Support\Traits\Macroable; 这个trait才行
        QueryBuilder::macro('lists', function () {
            $res = $this->get()->all();
            $result = [];

            foreach ($res as $value) {
                $result[] = (array)$value;
            }

            return $result;
        });
    }
}
