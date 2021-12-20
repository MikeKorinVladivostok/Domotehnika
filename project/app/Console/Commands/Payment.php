<?php

namespace App\Console\Commands;

use App\Models\Advert;
use Illuminate\Console\Command;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\DB;

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
        DB::table('adverts')
            ->chunkById(500, function ($adverts) {
                foreach ($adverts as $advert) {
                    $result = DB::table('adverts as advert')
                        ->where('advert.id',$advert -> id)
                        ->where('advert.category_id', '>',1)
                        ->where('advert.amount', '>', 0)
                        ->join('categories AS cat', 'cat.id', '=', 'advert.category_id')
                        ->get(['advert.*', 'cat.price AS tarif'])
                        ->all();

                    if(!$result){
                        continue;
                    }

                    $update = array(
                        'id' => $result[0]->id,
                        'paying' => $result[0]->amount  - ($result[0]->tarif)/24
                    );

                    $hourlyPay = Advert::find($update['id']);

                    if ($hourlyPay) {
                        $hourlyPay->amount = $update['paying'];

                        $hourlyPay->save();
                    }

                }
            });
    }
}
