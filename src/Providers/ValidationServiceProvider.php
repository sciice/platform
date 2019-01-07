<?php

namespace Platform\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Platform\Rules\Mobile;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->registeredRules() as $item) {
            $rules = $item['class'];

            Validator::replacer($item['name'], function ($message, $attribute, $rule, $parameters) use ($rules) {
                return $rules->message();
            });

            Validator::extend($item['name'], function ($attribute, $value, $parameters, $validator) use ($rules) {
                return $rules->passes($attribute, $value);
            });
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Rules of list.
     *
     * @return array
     */
    private function registeredRules()
    {
        return [
            [
                'name' => 'mobile',
                'class' => new Mobile(),
            ]
        ];
    }
}
