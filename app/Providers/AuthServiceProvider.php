<?php
namespace Corp\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Corp\Article;
use Corp\Category;
use Corp\Portfolio;
use Corp\Filter;
use Corp\Permission;
use Corp\Menu;
use Corp\User;
use Corp\Policies\ArticlePolicy;
use Corp\Policies\CategoryPolicy;
use Corp\Policies\PortfolioPolicy;
use Corp\Policies\FilterPolicy;
use Corp\Policies\PermissionPolicy;
use Corp\Policies\MenusPolicy;
use Corp\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Article::class => ArticlePolicy::class,
        Category::class => CategoryPolicy::class,
        Portfolio::class => PortfolioPolicy::class,
        Filter::class => FilterPolicy::class,
        Permission::class => PermissionPolicy::class,
        Menu::class => MenusPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('VIEW_ADMIN', function($user) {
            return $user->canDo('VIEW_ADMIN', FALSE);
        });

        $gate->define('VIEW_ADMIN_ARTICLES', function($user) {
            return $user->canDo('VIEW_ADMIN_ARTICLES', FALSE);
        });

        $gate->define('VIEW_ADMIN_CATEGORIES', function($user) {
            return $user->canDo('VIEW_ADMIN_CATEGORIES', FALSE);
        });

        $gate->define('VIEW_ADMIN_PORTFOLIOS', function($user) {
            return $user->canDo('VIEW_ADMIN_PORTFOLIOS', FALSE);
        });

        $gate->define('VIEW_ADMIN_FILTERS', function($user) {
            return $user->canDo('VIEW_ADMIN_FILTERS', FALSE);
        });

        $gate->define('EDIT_USERS', function($user) {
            return $user->canDo('EDIT_USERS', FALSE);
        });

        $gate->define('VIEW_ADMIN_MENU', function($user) {
            return $user->canDo('VIEW_ADMIN_MENU', FALSE);
        });

        //
    }
}
