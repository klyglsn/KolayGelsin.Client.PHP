<?php

class KolayGelsinClient
{
    // Test Base Url
    public string $baseUrl = "https://api-dev.sendeo.com.tr";


    function Login($req)
    {
        return $this->LoginAES($req, '/api/Token/LoginAES');
    }

    function SetDelivery($token, $req)
    {
        return $this->Request($req, $token, '/api/Cargo/SETDELIVERY', true);
    }


    function TrackDelivery($token, $req)
    {
        $queryString = '?trackingNo=' . $req->trackingNo . '&referenceNo=' . $req->referenceNo;
        return $this->Request($req, $token, '/api/Cargo/TRACKDELIVERY' . $queryString, false);
    }


    function CancelDelivery($token, $req)
    {
        $queryString = '?trackingNo=' . $req->trackingNo . '&referenceNo=' . $req->referenceNo;
        return $this->Request($req, $token, '/api/Cargo/CANCELDELIVERY' . $queryString, true);
    }


    function CargoMeasurementUpdate($token, $req)
    {
        return $this->Request($req, $token, '/api/Cargo/CARGOMEASUREMENTUPDATE', true);
    }

    function GetBarcodeByTrackingNumber($token, $req)
    {
        return $this->Request($req, $token, '/api/Cargo/GETBARCODEBYTRACKINGNUMBER', true);
    }

    function GetCityDistricts($token, $req)
    {
        $queryString = '?CityName=' . $req->CityName . '&DistrictName=' . $req->DistrictName;
        return $this->Request($req, $token, '/api/Cargo/GetCityDistricts' . $queryString, false);
    }


    private function Request($data, $authToken, $path, $isPost = false)
    {
        // Setup cURL
        $ch = curl_init($this->baseUrl . $path);

        if ($isPost) {
            curl_setopt_array(
                $ch,
                array(
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer ' . $authToken,
                        'Content-Type: application/json'
                    ),
                    CURLOPT_POSTFIELDS => json_encode($data)
                )
            );
        } else {
            curl_setopt_array(
                $ch,
                array(
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer ' . $authToken,
                        'Content-Type: application/json'
                    ),
                )
            );
        }

        // Send the request
        $response = curl_exec($ch);

        // Check for errors
        if ($response === FALSE) {
            die(curl_error($ch));
        }

        // Decode the response
        $responseData = json_decode($response, TRUE);

        // Close the cURL handler
        curl_close($ch);

        // Print the date from the response
        return $responseData;
    }


    private function LoginAES($data, $path)
    {
        $curl = curl_init($this->baseUrl . '/' . $path);

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            )
        );

        $response = curl_exec($curl);

        // Check for errors
        if ($response === FALSE) {
            die(curl_error($curl));
        }

        // Decode the response
        $responseData = json_decode($response, TRUE);

        // Close the cURL handler
        curl_close($curl);

        // Print the date from the response
        return $responseData;
    }
}
