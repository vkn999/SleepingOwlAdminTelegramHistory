<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class IdeHelper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ide:helper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

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
        $this->call('ide-helper:generate');
        $this->call('ide-helper:meta');
        $this->call('ide-helper:models', [
            '--nowrite' => true,
        ]);

        ## Remove SleepingOwl Facades section
        $file = '_ide_helper.php';
        $content = file_get_contents($file);
        $content = strtr($content, [
            'namespace SleepingOwl\Admin\Facades {' => 'namespace SleepingOwl___\Admin\Facades {',
        ]);
        file_put_contents($file, $content);

        return 0;
    }
}
