<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Policies\ModelPolicy;
use Spatie\Permission\Models\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Definir políticas de autorização para modelos específicos, se necessário
        // $this->defineModelPolicies();

        // Definir gates para cada permissão usando Spatie Permission, se necessário
        $this->definePermissionGates();

        // Gate global antes de todas as verificações
        Gate::before(function (User $user) {
            if ($user->hasRole('Super Admin')) {
                return true;
            }
        });

        // Gate global após todas as verificações
        Gate::after(function (User $user, $ability) {
            return $user->hasRole('Super Admin'); // retorna booleano
        });
    }

    /**
     * Define políticas de autorização para modelos específicos, se necessário.
     *
     * @return void
     */
    protected function defineModelPolicies()
    {
        // $this->policies([
        //     Model::class => ModelPolicy::class,
        // ]);
    }

    /**
     * Define gates para cada permissão usando Spatie Permission, se necessário.
     *
     * @return void
     */
    protected function definePermissionGates()
    {
        // $permissions = Permission::with('roles')->get();
        // foreach ($permissions as $permission) {
        //     Gate::define($permission->name, function (User $user) use ($permission) {
        //         return $user->hasPermissionTo($permission);
        //     });
        // }
    }
}
