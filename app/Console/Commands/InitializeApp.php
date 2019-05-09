<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InitializeApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates the database for the app and applies the migrations to scaffold the tables';

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
        $database = env('DB_DATABASE');

        if (empty($database)) {
            $this->info('Can not intialize application, DB_DATABASE .env is an empty value.');
            return;
        }

        try {
            $conn = new \mysqli(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), null, env('DB_PORT'));

            $this->info("Attempting to create database {$database}");

            $result = $conn->query(sprintf(
                'CREATE DATABASE IF NOT EXISTS %s CHARACTER SET %s COLLATE %s;',
                $database,
                env('DB_CHARSET', 'utf8'),
                env('DB_COLLATION', 'utf8_general_ci')
            ));

            if ($result === false) {
                $this->error('Failed creating database.');
                return;
            }

            $this->info('Applying migrations to database.');

            // Call the migrate artisan command
            $this->call('migrate');

            $this->info('done');

        } catch (\Exception $ex) {
           $this->error("Failed to create database {$database}, {$ex->getMessage()}");
        }
    }
}
