<?php

/*
 *
 * BoletoFacil é uma solução para emissão de cobranças da BoletoBancario.com
 * Para usar, é necessário ter um cadastro no boleto fácil e gerar um token de integração.
 * Acesse e confira: https://www.boletobancario.com/boleto-facil
 * Documentação: https://www.boletobancario.com/boletofacil/integration/integration.html
 * Criado por: Junior Barros
 *
 */

namespace BoletoFacil;

class BoletoFacil {

    public $amountTransfer;

    public $description;
    public $reference;
    public $amount;
    public $dueDate;
    public $installments;
    public $maxOverdueDays;
    public $fine;
    public $interest;
    public $discountAmount;
    public $discountDays;

    public $payerName;
    public $payerCpfCnpj;
    public $payerEmail;
    public $payerSecondaryEmail;
    public $payerPhone;
    public $payerBirthDate;

    public $billingAddressStreet;
    public $billingAddressNumber;
    public $billingAddressComplement;
    public $billingAddressCity;
    public $billingAddressState;
    public $billingAddressPostcode;

    public $notifyPayer;
    public $notificationUrl;
    
    private $token;
    private $sandbox;

    const PROD_URL = "https://www.boletobancario.com/boletofacil/integration/api/v1/";
    const SANDBOX_URL = "https://sandbox.boletobancario.com/boletofacil/integration/api/v1/";
    const RESPONSE_TYPE = "JSON";

    function __construct($token, $sandbox = false) {
        $this->token = $token;
        $this->sandbox = $sandbox;
    }

    public function createCharge($payerName, $payerCpfCnpj, $description, $amount, $dueDate) {
        $this->payerName = $payerName;
        $this->payerCpfCnpj = $payerCpfCnpj;
        $this->description = $description;
        $this->amount = $amount;
        $this->dueDate = $dueDate;
        return $this;
    }

    public function issueCharge() {
        $requestData = array(
            'token'                     =>  $this->token,
            'description'               =>  $this->description,
            'reference'                 =>  $this->reference,
            'amount'                    =>  $this->amount,
            'dueDate'                   =>  $this->dueDate,
            'installments'              =>  $this->installments,
            'maxOverdueDays'            =>  $this->maxOverdueDays,
            'fine'                      =>  $this->fine,
            'interest'                  =>  $this->interest,
            'discountAmount'            =>  $this->discountAmount,
            'discountDays'              =>  $this->discountDays,
            'payerName'                 =>  $this->payerName,
            'payerCpfCnpj'              =>  $this->payerCpfCnpj,
            'payerEmail'                =>  $this->payerEmail,
            'payerSecondaryEmail'       =>  $this->payerSecondaryEmail,
            'payerPhone'                =>  $this->payerPhone,
            'payerBirthDate'            =>  $this->payerBirthDate,
            'billingAddressStreet'      =>  $this->billingAddressStreet,
            'billingAddressNumber'      =>  $this->billingAddressNumber,
            'billingAddressComplement'  =>  $this->billingAddressComplement,
            'billingAddressCity'        =>  $this->billingAddressCity,
            'billingAddressState'       =>  $this->billingAddressState,
            'billingAddressPostcode'    =>  $this->billingAddressPostcode,
            'notifyPayer'               =>  $this->notifyPayer,
            'notificationUrl'           =>  $this->notificationUrl,
            'responseType'              =>  BoletoFacil::RESPONSE_TYPE
        );

        return $this->request("issue-charge", $requestData);
    }

    public function fetchPaymentDetails($paymentToken) {
        $requestData = array(
            'paymentToken'   => $paymentToken,
            'responseType'   => BoletoFacil::RESPONSE_TYPE
        );

        return $this->request("fetch-payment-details", $requestData);
    }


    public function fetchBalance() {
        $requestData = array(
            'token'         => $this->token,
            'responseType'  => BoletoFacil::RESPONSE_TYPE
        );

        return $this->request("fetch-balance", $requestData);
    }


    public function requestTransfer() {
        $requestData = array(
            'token'         => $this->token,
            'responseType'  => BoletoFacil::RESPONSE_TYPE,
            'amount'        => $this->amountTransfer
        );

        return $this->request("request-transfer", $requestData);
    }


    public function cancelCharge($code) {
        $requestData = array(
            'token'         => $this->token,
            'code'          => $code,
            'responseType'  => BoletoFacil::RESPONSE_TYPE
        );

        return $this->request("cancel-charge", $requestData);
    }


    private function request($urlSufix, $data) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => ($this->sandbox ? BoletoFacil::SANDBOX_URL : BoletoFacil::PROD_URL).$urlSufix,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "UTF-8",
            CURLOPT_MAXREDIRS => 2,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($data) . "\n",
            CURLOPT_HTTPHEADER => $data
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

}