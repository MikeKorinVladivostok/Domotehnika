<?php

namespace App\Http\Controllers\Api\Catalog;

use App\Models\Advert;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class CatalogController
{
    private const ITEMS_PER_PAGE = 20;
    private Connection $connection;

    public function __construct(DatabaseManager $manager)
    {
        $this->connection = $manager->connection();
    }

    public function index(CatalogRequest $request): CatalogResponse
    {
        $connection =  $this->connection->table('adverts');

        if($request->getCategoryId() == 1){
            $records = $this->connection->table('adverts')
                ->where('category_id', '=', $request->getCategoryId())
                ->limit(self::ITEMS_PER_PAGE)
                ->offset($request->getPage() * self::ITEMS_PER_PAGE)
                ->orderBy('id', 'DESC')
                ->get()
                ->all();
        }else{
            $records = $this->connection->table('adverts')
                ->where('category_id', '=', $request->getCategoryId())
                ->where('amount','>' , 0)
                ->limit(self::ITEMS_PER_PAGE)
                ->offset($request->getPage() * self::ITEMS_PER_PAGE)
                ->orderBy('id', 'DESC')
                ->get()
                ->all();
        }

        return new CatalogResponse($records);

    }

    public function advert(GetAdvertRequest $request): GetAdvertResponse
    {
        $advert = $this->connection->table('adverts AS a')
            ->join('categories AS c', 'c.id', '=', 'a.category_id')
            ->where('a.id', '=', $request->getId())
            ->get(['a.*', 'c.title AS category'])
            ->first();

        if (!$advert) {
            throw new NotFoundHttpException();
        }

        return new GetAdvertResponse($advert);

    }

    public function getPaymentResponseAndUpdateAmount(GetPaymentRequest $request)
    {
        $paymentRequest = array(
            'transaction_id' => $request->getTransactionId(),
            'item_id'        => $request->getItemId(),
            'site_id'        => $request->getSiteId(),
            'amount'         => $request->getAmount(),
            'parameters'     => $request->getParametersPayment(),
            'signature'      => $request->getSignature(),
        );

        $secret =  getenv('APP_KEY');

        if(sha1($secret . "&transaction=" .$paymentRequest['transaction_id'].
            "item_id=". $paymentRequest['item_id'] ."&site_id=". $paymentRequest['site_id'] .
            "&amount=". $paymentRequest['amount'] ."&user=". $paymentRequest['parameters']['user']
            ."&value=". $paymentRequest['parameters']['value'] ) != $paymentRequest['signature'])
        {
            //return response( ['success' => 'false'], 200);
            //имитация ошибки
        }

        $updateAmountAdvertsTable = Advert::find($paymentRequest['item_id']);

        if ($updateAmountAdvertsTable) {
            $updateAmountAdvertsTable->amount = $paymentRequest['amount'];

            $updateAmountAdvertsTable->save();

            return response( ['success' => 'true'], 200);

        } else {
            return response( ['success' => 'false'], 200);
        }

    }

    public function sendPaymentRequest(Request $request)
    {
        $sendPaymentData = $request -> all();

        $item_id = $sendPaymentData['item_id'];
        $parametersUser = $sendPaymentData['parameters']['user'];
        $parametersValue = $sendPaymentData['parameters']['value'];
        $site_id = $sendPaymentData['site_id'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://payment.ru/pay?item_id=".$item_id ."&parameters%5Buser%5D=".$parametersUser."
            &parameters%5Bvalue%5D=".$parametersValue."&site_id=".$site_id."",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,

            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }

}
