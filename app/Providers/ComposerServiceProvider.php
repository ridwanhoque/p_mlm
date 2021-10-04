<?php

namespace App\Providers;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\OptionRepository;
use App\Repositories\WalletRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Factory;
use Illuminate\View\View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @param Factory $factory
     * @return void
     */
    public function boot(Factory $factory)
    {
        $factory->composer('partials.nav-menu', function (View $view){
            $repository = new CategoryRepository();

            $view->with('categories', $repository->categoryMenu())
            ->with('featuredCategories', $repository->featuredCategoryMenu());
        });

        $factory->composer('layouts.website', function (View $view){

            $view->with('options', (new OptionRepository())->getOptions());
        });

        $factory->composer('layouts.portal', function (View $view){

            $view->with('options', (new OptionRepository())->getOptions())
                ->with('wallet_amount', (new WalletRepository())->presentWalletAmount());
        });
    }
}
