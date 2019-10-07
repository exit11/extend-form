<?php

namespace Exit11\ExtendForm;

use Encore\Admin\Admin;
use Encore\Admin\Form;
use Encore\Admin\Show;

use Illuminate\Support\ServiceProvider;

class ExtendFormServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(ExtendForm $extension)
    {
        if (! ExtendForm::boot()) {
            return ;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'extend-form');
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/exit11/extend-form')],
                'extend-form'
            );
        }

        $this->app->booted(function () {
            $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'extend-form');
        });

        Admin::booting(function () {
            Form::extend('address', Address::class);
            Form::extend('cropper', Cropper::class);
            Form::extend(ExtendForm::config('field_type', 'Editorjs'), Editor::class);
        });

    }
}