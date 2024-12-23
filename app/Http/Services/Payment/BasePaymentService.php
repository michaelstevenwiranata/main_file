<?php


namespace App\Http\Services\Payment;

use Illuminate\Support\Facades\Log;

class BasePaymentService
{
    public  $get_way = null;
    private $provider = null;
    public function __construct($object)
    {
        $this->provider = $object['payment_method'];

        $classPath = getPaymentServiceClass($this->provider);
        $this->get_way = new $classPath($object);
//        if ($this->provider == PAYPAL) {
//            $this->get_way = new PaypalService($object);
//        } elseif ($this->provider == STRIPE) {
//            $this->get_way = new StripeService($object);
//        } elseif ($this->provider == BANK) {
//            $conversion_rate = get_option('bank_conversion_rate') ? get_option('bank_conversion_rate') : 0;
//        } elseif ($this->provider == MOLLIE) {
//                $this->get_way = new MollieService($object);
//        }elseif ($this->provider == MERCADOPAGO) {
//                $this->get_way = new MarcadoPagoService($object);
//        }elseif ($this->provider == FLUTTERWAVE) {
//                $this->get_way = new FlutterwaveService($object);
//        }elseif ($this->provider == INSTAMOJO) {
//            $this->get_way = new InstamojoService($object);
//        }elseif ($this->provider == PAYSTAC) {
//            $this->get_way = new PaystackService($object);
//        }elseif ($this->provider == SSLCOMMERZ) {
//            $this->get_way = new SslCommerzService($object);
//        }elseif ($this->provider == COINBASE) {
//            $this->get_way = new CoinbaseService($object);
//        }elseif ($this->provider == ZITOPAY) {
//            $this->get_way = new ZitopayService($object);
//        }elseif ($this->provider == IYZIPAY) {
//            $this->get_way = new IyzipayService($object);
//        }elseif ($this->provider == BITPAY) {
//            $this->get_way = new BitPayService($object);
//        }elseif ($this->provider == BRAINTREE) {
//            $this->get_way = new BrainTreeService($object);
//        }
    }

    public function makePayment($amount,$post_data=null){
        $res = $this->get_way->makePayment($amount,$post_data);
        Log::info($res);
        return $res;
    }

    public function paymentConfirmation($payment_id,$payer_id=null){
        if(is_null($payer_id)){
            return $this->get_way->paymentConfirmation($payment_id);
        }
        return $this->get_way->paymentConfirmation($payment_id,$payer_id);
    }


}
