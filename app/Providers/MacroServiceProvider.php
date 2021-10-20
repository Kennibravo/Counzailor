<?php


namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        Builder::macro('whereOneLike', function (string $attribute, string $searchTerm) {
            return $this->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
        });

        Builder::macro('whereMultiLike', function (string $attributes, string $searchTerm) {
            foreach(Arr::wrap($attributes) as $attribute){
                $this->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
            }

            return $this;
        });
    }
}
