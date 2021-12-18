<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;

class Payment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hourly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ежечасное списание оплаты за объявления';

    protected Connection $connection;

    public function __construct(DatabaseManager $manager)
    {
        $this->connection = $manager->connection();
        parent::__construct();
    }

    public function handle(): void
    {
        $result = $this->connection->select('SELECT 2+2 AS value');
        dump("2 + 2 = {$result[0]->value}");

        dump("Тут выполняется код каждый час");
    }
}
