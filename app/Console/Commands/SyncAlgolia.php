<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncAlgolia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'algolia:sync {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronise an Algolia model to the Algolia servers.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $model = "App\\" . $this->argument('model');

        $model = new $model();

        $usedTraits = class_uses($model);

        if(!isset($usedTraits['AlgoliaSearch\Laravel\AlgoliaEloquentTrait'])) {
            $this->error('The model is not using the AlgoliaEloquentTrait!');
            return;
        }

        $elements = $model->all();

        $bar = $this->output->createProgressBar($elements->count());
        $bar->setFormat("%message%\n %current%/%max% [%bar%] %percent:3s%%");
        $bar->setMessage('Starting synchronisation');
        $bar->start();

        foreach($elements as $element) {
            $bar->setMessage("Syncing {$element->title}\n");
            $element->pushToIndex();
            $bar->advance();
        }

        $bar->finish();
    }
}
