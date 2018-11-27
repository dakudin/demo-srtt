<?php
/**
 * Created by Kudin Dmitry
 * Date: 09.11.2017
 * Time: 17:16
 */

namespace frontend\models;

use Yii;
use yii\base\Model;
use \common\components\Helper;

/**
 * ContactForm is the model behind the contact form.
 */
class SkiEnquiryForm extends Model
{
    public $enquire_title;
    public $enquire_firstname;
    public $enquire_surname;
    public $enquire_email;
    public $enquire_phone;
    public $enquire_postcode;
    public $formatted_address;
    public $enquire_offer_details;
    public $enquire_company;
    public $enquire_address1;
    public $enquire_address2;
    public $enquire_address3;
    public $enquire_address4;
    public $enquire_address5;
    public $enquire_town;
    public $enquire_county;
    public $enquire_country;
    public $enquire_sub_building;
    public $enquire_building_name;
    public $enquire_building_number;
    public $enquire_street;
    public $enquire_ad;
    public $enquire_ch;
    public $enquire_message;
//    public $form-name; //:contact-form
    public $enquire_brochure;
    public $enquire_type;
    public $current_url;

    /**
     * Creates a form model with default values.
     *
     * @param array $config name-value pairs that will be used to initialize the object properties
     */
    public function __construct($config = [])
    {
        $this->enquire_brochure = 0;
        $this->enquire_type = 'general';

        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['enquire_title', 'enquire_email', 'enquire_firstname', 'enquire_surname', 'enquire_phone',
                'enquire_postcode', 'enquire_message'], 'required'],

            ['enquire_email', 'email'],
            [['enquire_email', 'enquire_firstname', 'enquire_surname'], 'string', 'max' => 255],
            ['enquire_phone', 'match', 'pattern' => Helper::REGEXP_PHONE],
            ['enquire_postcode', 'match', 'pattern' => Helper::REGEXP_POSTCODE],
            ['enquire_title', 'in', 'range' => ['Mr', 'Mrs', 'Miss', 'Ms']],

            [['formatted_address','enquire_offer_details','enquire_company','enquire_address1','enquire_address2',
                'enquire_address3','enquire_address4','enquire_address5','enquire_town','enquire_county',
                'enquire_country','enquire_sub_building','enquire_building_name','enquire_building_number',
                'enquire_street','enquire_ad','enquire_ch','enquire_message','enquire_brochure','enquire_type',
                'current_url'], 'safe'],
        ];
    }

    public static function getAdditionalParam()
    {
        return ['form-name' => 'contact-form'];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'enquire_title' => 'Title',
            'enquire_firstname' => 'First Name',
            'enquire_surname' => 'Surname',
            'enquire_email' => 'Email',
            'enquire_phone' => 'Phone Number',
            'enquire_postcode' => 'Postcode',
            'enquire_ad' => 'Number of Adults',
            'enquire_ch' => 'Number of Children',
            'enquire_message' => 'Details',
        ];
    }

    /**
     * @return array
     */
    public static function getListTitle()
    {
        return ['Mr' => 'Mr', 'Mrs' => 'Mrs', 'Miss' => 'Miss', 'Ms' => 'Ms'];
    }
}
