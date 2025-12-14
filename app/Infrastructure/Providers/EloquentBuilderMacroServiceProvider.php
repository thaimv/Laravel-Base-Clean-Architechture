<?php

namespace App\Infrastructure\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class EloquentBuilderMacroServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Builder::macro('whereLike', function (array $attributes, array $searchTerm) {
            foreach ($attributes as $attribute) {
                if (!isset($searchTerm[$attribute[1]])) {
                    continue;
                }

                $search = preg_replace_callback(
                    "/\\+/",
                    function ($matches) {
                        if (app()->environment('local')) {
                            return $this->getBackslashPrefixByPdo() . str_replace('\\', '\\\\', $matches[0]);
                        }
                        return str_replace('\\', '\\\\', $matches[0]);
                    },
                    $searchTerm[$attribute[1]]
                );

                $search = str_replace(['_', '%'], ['\_', '\%'], $search);
                if (is_array($attribute[0])) {
                    $this->where(function ($query) use ($search, $attribute) {
                        foreach ($attribute[0] as $field) {
                            $query->orWhere($field, 'LIKE', "%{$search}%");
                        }
                    });
                } else {
                    $this->where($attribute[0], 'LIKE', "%{$search}%");
                }
            }

            return $this;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    public static function getBackslashPrefixByPdo()
    {
        return function () {
            $pdoDriver = DB::connection()->getPdo()->getAttribute(\PDO::ATTR_DRIVER_NAME);

            if ($pdoDriver === 'sqlite') {
                return '';
            }

            return '\\';
        };
    }
}
