<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Partner;
use App\Models\Category;
use App\Models\Currency;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $admin_lang = DB::table('admin_languages')->where('is_default','=',1)->first();
        App::setlocale($admin_lang->name);
        User::chekValidation(); 
        cache()->forget('mainMenus'); 
        view()->composer('*',function($settings){

            $settings->with('gs', cache()->remember('generalsettings', now()->addDay(), function () {
                return DB::table('generalsettings')->first();
            }));

            $settings->with('seo', cache()->remember('seotools', now()->addDay(), function () {
                return DB::table('seotools')->first();
            }));

            $settings->with('partnersSection', cache()->remember('partnersSection', now()->addDay(), function () {
                return Partner::where('status', 1)->get();
            }));
            
            $settings->with('socialsetting', cache()->remember('socialsettings', now()->addDay(), function () {
                return DB::table('socialsettings')->first();
            }));

            $settings->with('categories', cache()->remember('categories', now()->addDay(), function () {
                return Category::with('subs')->where('status','=',1)->orderBy('position','asc')->get();
            }));

            if (Session::has('language')){
                $data = cache()->remember('session_language', now()->addDay(), function () {
                    return DB::table('languages')->find(Session::get('language'));
                });
                $data_results = file_get_contents(public_path().'/assets/languages/'.$data->file);
                $lang = json_decode($data_results);
                $settings->with('langg', $lang);
                $settings->with('language', $data);
            }
            else{
                $data = cache()->remember('default_language', now()->addDay(), function () {
                    return DB::table('languages')->where('is_default','=',1)->first();
                });
                $data_results = file_get_contents(public_path().'/assets/languages/'.$data->file);
                $lang = json_decode($data_results);
                $settings->with('langg', $lang);
                $settings->with('language', $data);
            }

                $settings->with('mainMenus', cache()->remember('mainMenus', now()->addDay(), function () {
                    return Menu::where('is_defualt',1)->first();
                }));

             $currentCurrency = session()->has('current_currency') ? Currency::find(session()->get('current_currency')) : Currency::where('is_default', 1)->first();
                $settings->with('current_currency', $currentCurrency);
            if (!Session::has('popup'))
            {
                $settings->with('visited', 1);
            }

            Session::put('popup' , 1);

        });
    }
}
