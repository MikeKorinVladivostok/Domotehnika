GetAdvertResponse,  CatalogResponse:
В конструктор был добавлен возврат результата. Какую проблему вы таким образом исправили?
(Это дебаг, выводил значения на экран, смотрел как работает выборка, забыл убрать)

CatalogController:
Осталась переменная $connection =  $this->connection->table('adverts');
Она для какой-то цели должна была использоваться?
(тоже мой недосмтотр 
$connection =  $this->connection->table('adverts');

                $records = $this->connection->table('adverts')
  должна была встать сюда, вместо конструкции 

но в торопях не поставил)


Почему отдельно обрабатывается запрос для категории id = 1? По логике вижу, что там не используется фильтр по балансу,
(это костыль, я почему то подумал что категория id = 1 это всегда будет бесплатные товары, а когда прочитал что это телевизоры то все понял, времени исправлять не было, много логики пришлось бы исправлять, хотел сделать по быстрее)

При выводе объявлений баланс, как я понимаю, не учитывается?
(пытался учесть
$records = $this->connection->table('adverts')
                ->where('category_id', '=', $request->getCategoryId())
                ->where('amount','>' , 0)
                добавил поле баланса амоунт и если денег больше нуля, то показать)
                
в обоих изначальных методах (список и объявление) использовался определенный для данного метода класс "запроса" (GetAdvertRequest, CatalogRequest).
В методе getPaymentResponseAndUpdateAmount тоже был написан request - GetPaymentRequest, а уже в методе sendPaymentRequest используется "общий" Request и $request->all() для получения массива данных. Почему так?В чем разница между двумя этими методами, почему в них разные подходы к получению данных из запроса?
                                                                                                                                                                                                                   Не понятна и практика упаковки данных в массив и использование далее по коду.
(Сделал получение данных  с формы вот таким длинным способом, потому что в данном коде при импорте увидел, что используются классы для получения реквеста,  а потом в документации увидел, что есть метод all() и применил его, потому что отправка данных по большей части это абстракция и я показал этим методом, что я отправл данные на платежную систему )

Функцию проверки подписи проверяли на указанном в README.md примере? Т.к. заметил в описании принципа формирования подписи ненамеренную опечатку - перед item_id пропущен &, а в примере он указан.
(да , опечатка, тестил , а потом перед деплоем решил сделать конкантенацию красивую и потерял амперсанд)

