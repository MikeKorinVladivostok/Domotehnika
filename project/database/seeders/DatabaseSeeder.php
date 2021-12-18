<?php

namespace Database\Seeders;

use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private Connection $connection;

    public function __construct(DatabaseManager $manager)
    {
        $this->connection = $manager->connection();
    }

    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        $this->connection->table('categories')->insert([
            [
                'id'    => 1,
                'title' => 'Телевизоры',
                'price' => 0,
            ],
            [
                'id'    => 2,
                'title' => 'Холодильники',
                'price' => 50,
            ],
            [
                'id'    => 3,
                'title' => 'Смартфоны',
                'price' => 50,
            ],
            [
                'id'    => 4,
                'title' => 'Стиральные машины',
                'price' => 50,
            ],
            [
                'id'    => 5,
                'title' => 'Игровые приставки',
                'price' => 100,
            ],
            [
                'id'    => 6,
                'title' => 'Подарки',
                'price' => 10,
            ],
        ]);

        for ($i = 0; $i < 1000; ++$i) {

            $this->connection->table('adverts')->insert([
                'id'          => 5555 + $i,
                'title'       => 'Playstation ' . ($i % 2 ? 4 : 5) . ' Белая',
                'description' => 'Состояние: новая',
                'contacts'    => '+7 (999) ' . random_int(100, 999) . '-' . random_int(10,
                        99) . '-66, звонить до 8 утра',
                'category_id' => 5,
            ]);
        }

        for ($i = 0; $i < 5000; ++$i) {

            $this->connection->table('adverts')->insert([
                'title'       => 'Товар ' . md5(uniqid('', true)),
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'contacts'    => '+7 (999) ' . random_int(100, 999) . '-' . random_int(10,
                        99) . '-66, звонить до 8 утра',
                'category_id' => random_int(1, 6),
            ]);
        }
    }
}
