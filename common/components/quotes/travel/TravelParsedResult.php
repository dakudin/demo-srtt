<?php
/**
 * Created by Kudin Dmitry
 * Date: 10.10.2017
 * Time: 20:11
 */

namespace common\components\quotes\travel;


class TravelParsedResult
{
    public $companyId;
    public $companyName;
    public $companyUrl;

    public $resorts;

    /**
     * @param $id integer
     * @param $name string
     * @param $url string
     */
    public function __construct($id, $name, $url){
        $this->companyId = $id;
        $this->companyName = $name;
        $this->companyUrl = $url;
        $this->resorts = [];
    }

    public function addResort($hotelName, $resort, $imgUrl, $detailUrl, $price, $hotelStar, $description, $info){
        $this->resorts[] = [
            'hotelName' => $hotelName,
            'resort' => $resort,
            'imgUrl' => $imgUrl,
            'detailUrl' => $detailUrl,
            'price' => $price,
            'hotelStar' => $hotelStar,
            'description' => $description,
            'info' => $info
        ];
    }


}