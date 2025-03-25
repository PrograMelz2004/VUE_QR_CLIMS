<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class SystemServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $system = DB::table('system')->first();

        Config::set('app.system_long_name', $system ? $system->sys_l_name : 'EVSU DC');
        Config::set('app.system_short_name', $system ? $system->sys_s_name : 'EVSU DC');
    }

    public function register()
    {
        //
    }
}
