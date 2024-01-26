<?php

namespace XtendLunar\Addons\QuizApp;

use Binaryk\LaravelRestify\Traits\InteractsWithRestifyRepositories;
use CodeLabX\XtendLaravel\Base\XtendAddonProvider;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;
use Lunar\Hub\Facades\Menu;
use Lunar\Hub\Menu\MenuLink;
use QuizApp\Database\Seeders\QuizSeeder;
use XtendLunar\Addons\QuizApp\Livewire\Quiz\Table;
use XtendLunar\Addons\QuizApp\Models\Quiz;
use XtendLunar\Addons\QuizApp\Models\QuizQuestion;
use XtendLunar\Addons\QuizApp\Policies\QuizPolicy;

class QuizAppProvider extends XtendAddonProvider
{
    use InteractsWithRestifyRepositories;

    protected $policies = [
        Quiz::class => QuizPolicy::class,
        QuizQuestion::class => QuizPolicy::class,
    ];

    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . '/../route/hub.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'xtend-lunar-quiz-app');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'xtend-lunar::quiz-app');
        $this->loadRestifyFrom(__DIR__.'/Restify', __NAMESPACE__.'\\Restify\\');
        $this->mergeConfigFrom(__DIR__.'/../config/quiz-app.php', 'quiz-app');

        $this->registerLivewireComponents();

        $this->registerSeeders([
			QuizSeeder::class,
	    ]);
    }

    public function boot()
    {
        $this->registerPolicies();
        Blade::componentNamespace('XtendLunar\\Addons\\QuizApp\\Components', 'xtend-lunar::quiz-app');

        Menu::slot('sidebar')
            ->group('hub.configure')
            ->addItem(function (MenuLink $item) {
                return $item->name('Quiz App')
                    ->handle('hub.quiz-app')
                    ->route('hub.quiz-app.index')
                    ->icon('users');
            });

        $this->publishes([
           __DIR__.'/../config/quiz-app.php' => config_path('quiz-app.php'),
        ]);
    }

    protected function registerSeeders(array $seeders = []): void
	{
		$this->callAfterResolving(DatabaseSeeder::class, function (DatabaseSeeder $seeder) use ($seeders) {
			collect($seeders)->each(
				fn ($seederClass) => $seeder->call($seederClass),
			);
		});
	}

    protected function registerLivewireComponents(): void
    {
        Livewire::component('xtend-lunar::quiz-app.quizzes.table', Table::class);
    }

    protected function registerPolicies()
    {
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}
