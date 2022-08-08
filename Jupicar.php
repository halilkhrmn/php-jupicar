<?php

namespace App\Libraries;

class Jupicar
{

    public function __construct()
    {
        @libxml_disable_entity_loader(false);
        $soapClientOptions = array(
            'login' => 'edsbilisim@nissan-bayi.com',
            'password' => 'edsbilisim123',
            'cache_wsdl'     => WSDL_CACHE_NONE,
            'trace'          => 1,
            'stream_context' => stream_context_create(
                [
                    'ssl' => [
                        'verify_peer'       => false,
                        'verify_peer_name'  => false,
                        'allow_self_signed' => true
                    ]
                ]
            )
        );
        //Test
        //$this->api = new \SoapClient("https://jupicar.cloud:1409/ws/reservation.wsdl", $soapClientOptions);
        //Live
        $this->api = new \SoapClient("https://jupicar.cloud:2034/ws/reservation.wsdl", $soapClientOptions);
    }


    /**
     * brokerLogin
     *
     * @param string    $email       Broker email
     * @param string    $password    Broker password
     *
     * @return array
     */
    public function brokerLogin($email = "", $password = "")
    {
        try {
            if ($email == "" || $password == "") {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası",
                );
            }
            $brokerLogin  = $this->api->BrokerLogin(array(
                "email" => $email,
                "password" => $password,
            ));
            if (isset($brokerLogin->brokerLogin)) {
                return array(
                    "status" => true,
                    "data" => $brokerLogin->brokerLogin,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }

    /**
     * Campaigns
     *
     * @param int      $pickupLocNo    Pickup location number
     * @param string   $pickupDate     Pickup date
     * @param int      $returnLocNo    Return location number
     * @param string   $returnDate     Return date
     * @param int      $tariffNo       Tariff number
     *
     * @return array
     */
    public function Campaigns($pickupLocNo = "", $pickupDate = "", $returnLocNo = "", $returnDate = "", $tariffNo = "")
    {

        try {
            $Campaigns  = $this->api->Campaigns(array(
                "pickupLocNo" => $pickupLocNo,
                "pickupDate" => $pickupDate,
                "returnLocNo" => $returnLocNo,
                "returnDate" => $returnDate,
                "tariffNo" => $tariffNo,
            ));



            if (isset($Campaigns->campaigns)) {
                return array(
                    "status" => true,
                    "data" => $Campaigns->campaigns,
                );
            } else {

                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası",
                );
            }
        } catch (\Throwable $th) {
            var_dump($th);
            die;
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }


    /**
     * cancelReservation
     *
     * @param int      $resNo      Reservation number
     * @param int      $resCorpNo  resCorpNo
     *
     * @return array
     */
    public function cancelReservation($resNo = "", $resCorpNo = "")
    {
        try {
            $cancelReservation  = $this->api->CancelReservation(array(
                "resNo" => $resNo,
                "resCorpNo" => $resCorpNo,
            ));
            if (isset($cancelReservation->CancelReservation)) {
                return array(
                    "status" => true,
                    "data" => $cancelReservation->CancelReservation,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }


    /**
     * Capacities 
     *
     * @param int      $pickupLocNo      pickupLocNo 
     * @param string   $pickupDate       pickupDate 
     * @param int      $returnLocNo      returnLocNo 
     * @param string   $returnDate       returnDate  
     * @param int      $classNos         classNos 
     * @param int      $tariffNo         tariffNo
     * @param int      $campaignNo       campaignNo
     * @param string   $language        language
     *
     * @return array
     */
    public function Capacities($pickupLocNo  = "", $pickupDate  = "", $returnLocNo  = "", $returnDate  = "", $classNos  = "", $tariffNo  = "", $campaignNo  = "", $language  = "TR")
    {
        try {
            $req = array(
                "pickupLocNo" => $pickupLocNo,
                "pickupDate" => $pickupDate,
                "returnLocNo" => $returnLocNo,
                "returnDate" => $returnDate,
                "classNos" => $classNos,
                "tariffNos" => $tariffNo,
                "campaignNo" => $campaignNo,
                "language" => $language,
            );

            $Capacities  = $this->api->Capacities($req);

            if (isset($Capacities->capacities)) {
                return array(
                    "status" => true,
                    "data" => $Capacities->capacities,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }


    /**
     * Countries
     *
     * @param string      $language     language
     *
     * @return array
     */
    public function Countries($language  = "TR")
    {
        try {
            $Countries   = $this->api->Countries(array(
                "language" => $language,
            ));

            if (isset($Countries->countries)) {
                return array(
                    "status" => true,
                    "data" => $Countries->countries,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
            );
        }
    }


    /**
     * Cities
     *
     * @param string      $countryCode     countryCode
     *
     * @return array
     */
    public function Cities($countryCode  = "TR")
    {
        try {
            $Cities   = $this->api->Cities(array(
                "countryCode" => $countryCode,
            ));

            if (isset($Cities->cities)) {
                return array(
                    "status" => true,
                    "data" => $Cities->cities,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }


    /**
     * Currencies
     *
     * @param string      $countryCode     countryCode
     *
     * @return array
     */
    public function Currencies()
    {
        try {
            $Currencies   = $this->api->Currencies();
            if (isset($Currencies->currencies)) {
                return array(
                    "status" => true,
                    "data" => $Currencies->currencies,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }



    /**
     * CustomerAddressInfo 
     *
     * @param int      $addressNo      addressNo
     * @param int      $addressCorpNo  addressCorpNo
     *
     * @return array
     */
    public function customerAddressInfo($addressNo = "", $addressCorpNo = "")
    {
        try {
            $customerAddressInfo  = $this->api->CustomerAddressInfo(array(
                "addressNo" => $addressNo,
                "addressCorpNo" => $addressCorpNo,
            ));
            if (isset($customerAddressInfo->CustomerAddressInfo)) {
                return array(
                    "status" => true,
                    "data" => $customerAddressInfo->CustomerAddressInfo,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }



    /**
     * exchangeRates  
     *
     * @param string      $date      Y-m-d
     *
     * @return array
     */
    public function exchangeRates($date = "")
    {
        try {
            if ($date == "") {
                $date = date("Y-m-d");
            }
            $exchangeRates   = $this->api->ExchangeRates(array(
                "date" => $date,
            ));
            if (isset($exchangeRates->exchangeRates)) {
                return array(
                    "status" => true,
                    "data" => $exchangeRates->exchangeRates,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası ya da boş veri döndü",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }


    /**
     * extraProducts  
     *
     * @param integer     $rentalDays      rentalDays
     * @param string      $tariffNos       tariffNos 
     * @param string      $campaignNo      campaignNo
     * @param string      $classNo         classNo 
     * @param string      $language        language 
     *
     * @return array
     */
    public function extraProducts($rentalDays = "", $tariffNo = "", $campaignNo = "", $classNo = "", $language = "TR")
    {
        try {
            $req = array(
                "rentalDays" => $rentalDays,
                "tariffNo" => $tariffNo,
                "campaignNo" => $campaignNo,
                "classNo" => $classNo,
                "language" => $language,
            );

            $extraProducts   = $this->api->ExtraProducts($req);
            if (isset($extraProducts->extraProducts)) {
                return array(
                    "status" => true,
                    "data" => $extraProducts->extraProducts,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası ya da boş veri döndü",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }




    /**
     * insertCustomerAddressInfo  
     *
     * @param string      $customerAddressInfo      customerAddressInfo 
     *
     * @return array
     */
    public function insertCustomerAddressInfo($customerAddressInfo  = "")
    {
        try {

            $insertCustomerAddressInfo   = $this->api->insertCustomerAddressInfo(array(
                "customerAddressInfo " => $customerAddressInfo,
            ));
            if (isset($insertCustomerAddressInfo->insertCustomerAddressInfo)) {
                return array(
                    "status" => true,
                    "data" => $insertCustomerAddressInfo->insertCustomerAddressInfo,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası ya da boş veri döndü",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }


    /**
     * insertReservation  
     *
     * @param string      $reservation       reservation  
     *
     * @return array
     */
    public function insertReservation($reservation   = "")
    {
        try {

            $insertReservation   = $this->api->insertReservation(array(
                "reservation  " => $reservation,
            ));
            if (isset($insertReservation->insertReservation)) {
                return array(
                    "status" => true,
                    "data" => $insertReservation->insertReservation,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası ya da boş veri döndü",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }

    /**
     * InsertReservationByRegion   
     *
     * @param string      $reservation       reservation  
     * @param string      $pickupLocNos        pickupLocNos   
     * @param string      $returnLocNos         returnLocNos    
     *
     * @return array
     */
    public function insertReservationByRegion($reservation   = "", $pickupLocNos   = "", $returnLocNos    = "")
    {
        try {

            $insertReservationByRegion   = $this->api->insertReservationByRegion(array(
                "reservation" => $reservation,
                "pickupLocNos" => $pickupLocNos,
                "returnLocNos" => $returnLocNos,

            ));
            if (isset($insertReservationByRegion->insertReservationByRegion)) {
                return array(
                    "status" => true,
                    "data" => $insertReservationByRegion->insertReservationByRegion,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası ya da boş veri döndü",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }



    /**
     * LocationCities   
     *
     * @param string      $language        language   
     * @param string      $cityName         cityName    
     *
     * @return array
     */
    public function locationCities($language    = "", $cityName    = "")
    {
        try {

            $locationCities   = $this->api->locationCities(array(
                "language" => $language,
                "cityName" => $cityName,
            ));
            if (isset($locationCities->locationCities)) {
                return array(
                    "status" => true,
                    "data" => $locationCities->locationCities,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası ya da boş veri döndü",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }


    /**
     * LocationRegions   
     *
     * @param string      $language        language   
     *
     * @return array
     */
    public function locationRegions($language    = "TR")
    {
        try {

            $locationRegions   = $this->api->locationRegions(array(
                "language" => $language,
            ));
            if (isset($locationRegions->locationRegions)) {
                return array(
                    "status" => true,
                    "data" => $locationRegions->locationRegions,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası ya da boş veri döndü",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }


    /**
     * Locations   
     *
     * @param string      $language        language   
     * @param string      $cityName        cityName   
     *
     * @return array
     */
    public function Locations($language    = "TR", $cityName = "")
    {
        try {

            $Locations   = $this->api->Locations(array(
                "language" => $language,
                "cityName" => $cityName,
            ));
            if (isset($Locations->locations)) {
                return array(
                    "status" => true,
                    "data" => $Locations->locations,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası ya da boş veri döndü",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }


    /**
     * paymentTypes   
     *
     * @param string      $language        language   
     *
     * @return array
     */
    public function paymentTypes($language    = "TR")
    {
        try {

            $paymentTypes   = $this->api->paymentTypes(array(
                "language" => $language,
            ));
            if (isset($paymentTypes->paymentTypes)) {
                return array(
                    "status" => true,
                    "data" => $paymentTypes->paymentTypes,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası ya da boş veri döndü",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }


    /**
     * RegionCapacities    
     *
     * @param string      $pickupRegion        pickupRegion   
     * @param string      $pickupDate        pickupDate
     * @param string      $returnRegion    returnRegion
     * @param string      $returnDate        returnDate
     * @param string      $classNos    classNos
     * @param string      $tariffNos    tariffNos
     * @param string      $campaignNo    campaignNo
     * @param string      $language        language
     *
     * @return array
     */
    public function regionCapacities($pickupRegion, $pickupDate, $returnRegion, $returnDate, $classNos, $tariffNos, $campaignNo, $language    = "TR")
    {
        try {

            $regionCapacities   = $this->api->regionCapacities(array(
                "language" => $language,
                "pickupRegion" => $pickupRegion,
                "pickupDate" => $pickupDate,
                "returnRegion" => $returnRegion,
                "returnDate" => $returnDate,
                "classNos" => $classNos,
                "tariffNos" => $tariffNos,
                "campaignNo" => $campaignNo,

            ));
            if (isset($regionCapacities->regionCapacities)) {
                return array(
                    "status" => true,
                    "data" => $regionCapacities->regionCapacities,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası ya da boş veri döndü",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }


    /**
     * RegionCapacities    
     *
     * @param string      $resAdNo         resAdNo    
     * @param string      $resNo         resNo 
     * @param string      $resCorpNo     resCorpNo 
     * @param string      $language         language 
     *
     * @return array
     */
    public function reservationsOfCustomer($resAdNo, $resNo, $resCorpNo, $language = "TR")
    {
        try {

            $reservationsOfCustomer   = $this->api->reservationsOfCustomer(array(
                "language" => $language,
                "resAdNo" => $resAdNo,
                "resNo" => $resNo,
                "resCorpNo" => $resCorpNo,

            ));
            if (isset($reservationsOfCustomer->reservationsOfCustomer)) {
                return array(
                    "status" => true,
                    "data" => $reservationsOfCustomer->reservationsOfCustomer,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası ya da boş veri döndü",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }


    /**
     * reservationSources    
     *
     *
     * @return array
     */
    public function reservationSources()
    {
        try {

            $reservationSources   = $this->api->reservationSources();
            if (isset($reservationSources->reservationSources)) {
                return array(
                    "status" => true,
                    "data" => $reservationSources->reservationSources,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası ya da boş veri döndü",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }



    /**
     * sendBankTransaction     
     *
     * @param string      $bankTransaction          bankTransaction     
     *
     * @return array
     */
    public function sendBankTransaction($bankTransaction)
    {
        try {

            $sendBankTransaction   = $this->api->sendBankTransaction(array(
                "bankTransaction " => $bankTransaction
            ));
            if (isset($sendBankTransaction->sendBankTransaction)) {
                return array(
                    "status" => true,
                    "data" => $sendBankTransaction->sendBankTransaction,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası ya da boş veri döndü",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }



    /**
     * SendMailOnReservationInsert     
     *
     * @param string      $resNo         resNo 
     * @param string      $resCorpNo     resCorpNo 
     * @param boolean      $toVendor          toVendor 
     * @param boolean      $toCustomer          toCustomer  
     *
     * @return array
     */
    public function sendMailOnReservationInsert($resNo, $resCorpNo, $toVendor,  $toCustomer)
    {
        try {

            $sendMailOnReservationInsert   = $this->api->sendMailOnReservationInsert(array(
                "resNo" => $resNo,
                "resCorpNo" => $resCorpNo,
                "toVendor" => $toVendor,
                "toCustomer" => $toCustomer,
            ));
            if (isset($sendMailOnReservationInsert->sendMailOnReservationInsert)) {
                return array(
                    "status" => true,
                    "data" => $sendMailOnReservationInsert->sendMailOnReservationInsert,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası ya da boş veri döndü",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }



    /**
     * Tariffs     
     *
     *
     * @return array
     */
    public function Tariffs()
    {
        try {

            $Tariffs   = $this->api->Tariffs();
            if (isset($Tariffs->tariffs)) {
                return array(
                    "status" => true,
                    "data" => $Tariffs->tariffs,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası ya da boş veri döndü",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }


    /**
     * tariffsOfCustomer     
     *
     * @param string      $promotionCode          promotionCode  
     * @param string      $promotionCodeType      promotionCodeType  
     *
     * @return array
     */
    public function tariffsOfCustomer($promotionCode, $promotionCodeType)
    {
        try {

            $tariffsOfCustomer   = $this->api->tariffsOfCustomer(array(
                "promotionCode " => $promotionCode,
                "promotionCodeType " => $promotionCodeType
            ));
            if (isset($tariffsOfCustomer->tariffsOfCustomer)) {
                return array(
                    "status" => true,
                    "data" => $tariffsOfCustomer->tariffsOfCustomer,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası ya da boş veri döndü",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }


    /**
     * UpdateCustomerAddressInfo      
     *
     * @param string      $customerAddressInfo           customerAddressInfo   
     *
     * @return array
     */
    public function updateCustomerAddressInfo($customerAddressInfo)
    {
        try {

            $updateCustomerAddressInfo   = $this->api->updateCustomerAddressInfo(array(
                "customerAddressInfo" => $customerAddressInfo,
            ));
            if (isset($updateCustomerAddressInfo->updateCustomerAddressInfo)) {
                return array(
                    "status" => true,
                    "data" => $updateCustomerAddressInfo->updateCustomerAddressInfo,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası ya da boş veri döndü",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }



    /**
     * UpdateReservation       
     *
     * @param string      $updateReservationv           updateReservationv   
     *
     * @return array
     */
    public function updateReservation($updateReservationv)
    {
        try {

            $updateReservation   = $this->api->updateReservation(array(
                "updateReservation" => $updateReservationv,
            ));
            if (isset($updateReservation->updateReservation)) {
                return array(
                    "status" => true,
                    "data" => $updateReservation->updateReservation,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası ya da boş veri döndü",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }

    /**
     * VehicleClasses        
     *
     * @param string      $language            language    
     *
     * @return array
     */
    public function vehicleClasses($language = "TR")
    {
        try {
            $vehicleClasses   = $this->api->vehicleClasses(array(
                "language" => $language,
            ));


            if (isset($vehicleClasses->vehicleClasses)) {
                return array(
                    "status" => true,
                    "data" => $vehicleClasses->vehicleClasses,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası ya da boş veri döndü",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }


    /**
     * vehicleTypeDetails        
     *
     * @param string      $language            language    
     * @param string      $typeNo       typeNo
     *
     * @return array
     */
    public function vehicleTypeDetails($typeNo = "", $language = "TR")
    {
        try {

            $vehicleTypeDetails   = $this->api->vehicleTypeDetails(array(
                "typeNo" => $typeNo,
                "language" => $language

            ));
            if (isset($vehicleTypeDetails->vehicleTypeDetails)) {
                return array(
                    "status" => true,
                    "data" => $vehicleTypeDetails->vehicleTypeDetails,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası ya da boş veri döndü",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }

    /**
     * VehicleTypes         
     *
     * @param string      $language            language    
     *
     * @return array
     */
    public function vehicleTypes($language = "TR")
    {
        try {

            $vehicleTypes   = $this->api->vehicleTypes(array(
                "language" => $language,
            ));
            if (isset($vehicleTypes->vehicleTypes)) {
                return array(
                    "status" => true,
                    "data" => $vehicleTypes->vehicleTypes,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası ya da boş veri döndü",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }

    /**
     * Holidays         
     *
     * @param string      $locNo            locNo    
     *
     * @return array
     */
    public function Holidays($locNo  = "TR")
    {
        try {

            $Holidays   = $this->api->Holidays(array(
                "locNo" => $locNo,
            ));
            if (isset($Holidays->holidays)) {
                return array(
                    "status" => true,
                    "data" => $Holidays->holidays,
                );
            } else {
                return array(
                    "status" => false,
                    "data" => "",
                    "message" => "Jupicar API Hatası ya da boş veri döndü",
                );
            }
        } catch (\Throwable $th) {
            return array(
                "status" => false,
                "data" => "",
                "message" => $th->getMessage(),
                "error" => $th,
            );
        }
    }
}
