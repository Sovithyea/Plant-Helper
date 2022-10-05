<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SpaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spa:make {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $model = $this->argument('model');
        $model = strtolower($model);
        $model = str_replace(' ', '_', $model);

        if (file_exists (resource_path('js\view\\'.$model.'\Index.vue')))
        {
            $this->warn('Index.vue already exist.');
        } else if (File::copy(resource_path('js\view\spa\Index.vue'), resource_path('js\view\\'.$model.'\Index.vue'))) {
            $this->info('Index.vue has been create successfull.');
        }

        return 0;
    }
}
