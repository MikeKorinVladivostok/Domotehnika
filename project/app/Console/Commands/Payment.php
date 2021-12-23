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
    //я прочитал документацию по ларе, в которой узнал что можно реализовать планировщик задач не с помощью cron демона линукс , а вот агентами
    // в kernel указана периодичность каждый час

    public function handle(): void
    {
        //использую подключение к таблице adverts
        DB::table('adverts')
            //что бы не грузить систему делаю чёнки по 500 записей
            ->chunkById(500, function ($adverts) {
                // на вход функции приходит переменная и я её пробегаю циклом
                foreach ($adverts as $advert) {
                    //подключаюсь к таблице с псевдонимом advert для join по ключевому столбцу
                    $result = DB::table('adverts as advert')
                        // из цикла беру айди записей по очереди в рамках чанка
                        ->where('advert.id',$advert -> id)
                        //если 1 то это бесплатные, тут костыль , поздно заметил
                        ->where('advert.category_id', '>',1)
                        //если баланс больше нуля
                        ->where('advert.amount', '>', 0)
                        //соединенеие по ключевому столбцу
                        ->join('categories AS cat', 'cat.id', '=', 'advert.category_id')
                        //выборка столбцов
                        ->get(['advert.*', 'cat.price AS tarif'])
                        //выгрузка
                        ->all();
                    //бывает при выгрузке пустые элементы, их пропускаем
                    if(!$result){
                        continue;
                    }
                    //сразу же в цикле апдейт и вычитание 1/24 суммы по тарифу
                    $update = array(
                        'id' => $result[0]->id,
                        'paying' => $result[0]->amount  - ($result[0]->tarif)/24
                    );
                    // метод ларавель ищу по id объявление
                    $hourlyPay = Advert::find($update['id']);
                    //нет ошибок - обновляем таблицу
                    if ($hourlyPay) {
                        $hourlyPay->amount = $update['paying'];
                        // перезаписались, ларавель говорит что апдейтить можно save() методом, я ей верю
                        $hourlyPay->save();
                    }

                }
            });
    }
}
