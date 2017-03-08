<?php

namespace interactivesolutions\honeycombscripts\app\commands;

use interactivesolutions\honeycombcore\commands\HCCommand;

class HCRoutes extends HCCommand
{
    const ROUTES_PATH = 'app/honeycomb/routes.php';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hc:routes {directory?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generating routes file';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle ()
    {
        if ($this->argument ('directory'))
            $rootDirectory = $this->argument ('directory');
        else
            $rootDirectory = '';

        $files = $this->file->allFiles ($rootDirectory . 'app/routes');

        $finalContent = '<?php' . "\r\n";

        foreach ($files as $file) {
            $finalContent .= "\r\n";
            $finalContent .= '//' . (string)$file;
            $finalContent .= str_replace ('<?php', '', $this->file->get ((string)$file)) . "\r\n";
        }

        $this->file->put ($rootDirectory . HCRoutes::ROUTES_PATH, $finalContent);

        $this->comment ($rootDirectory . HCRoutes::ROUTES_PATH . ' file generated');
    }
}