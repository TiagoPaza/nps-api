<?php

namespace App\Providers;

use App\Observers\PlanActivityObserver;
use App\Observers\PlanObserver;
use App\Observers\QuestionObserver;
use App\Observers\QuestionReplyObserver;
use App\Observers\UserObserver;
use App\Plan;
use App\PlanActivity;
use App\Question;
use App\QuestionReply;
use App\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        PlanActivity::observe(PlanActivityObserver::class);
        Plan::observe(PlanObserver::class);
        QuestionReply::observe(QuestionReplyObserver::class);
        Question::observe(QuestionObserver::class);
        User::observe(UserObserver::class);
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
}
