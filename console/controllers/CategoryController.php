<?php
/**
 * Created by Kudin Dmitry
 * Date: 17.01.2019
 * Time: 15:22
 */


namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\EnquiryCategory;
//use yii\console\ExitCode;

/**
 * This command create first variant of enquiry categories
 *
 * @author Kudin Dmitry <dakudin@gmail.com>
 */
class CategoryController extends Controller
{
    /**
     * This command create first variant of enquiry categories
     * @return int Exit code
     */
    public function actionIndex()
    {
        $holiday = new EnquiryCategory(['name' => 'Holiday', 'alias' => 'holiday', 'image' => 'holiday.png', 'is_active' => 0, 'is_visible' => 1]);
        $holiday->makeRoot();

        $travel = new EnquiryCategory(['name' => 'Travel', 'alias' => 'travel', 'image' => 'travel.png', 'is_active' => 1, 'is_visible' => 1]);
        $travel->makeRoot();

        $node = new EnquiryCategory(['name' => 'Beach', 'alias' => 'beach', 'image' => 'beach.png', 'is_active' => 1, 'is_visible' => 1 ]);
        $node->appendTo($travel);
        $node = new EnquiryCategory(['name' => 'Skiing', 'alias' => 'skiing', 'image' => 'skiing.png', 'is_active' => 1, 'is_visible' => 1 ]);
        $node->appendTo($travel);
        $node = new EnquiryCategory(['name' => 'Luxury', 'alias' => 'luxury', 'image' => 'luxury.png', 'is_active' => 0, 'is_visible' => 1 ]);
        $node->appendTo($travel);
        $node = new EnquiryCategory(['name' => 'City Breaks', 'alias' => 'city_breaks', 'image' => 'city_breaks.png', 'is_active' => 0, 'is_visible' => 1 ]);
        $node->appendTo($travel);
        $node = new EnquiryCategory(['name' => 'Cruises', 'alias' => 'cruises', 'image' => 'cruises.png', 'is_active' => 0, 'is_visible' => 1 ]);
        $node->appendTo($travel);

        $node = new EnquiryCategory(['name' => 'Cars', 'alias' => 'cars', 'image' => 'cars.png', 'is_active' => 0, 'is_visible' => 1]);
        $node->makeRoot();
        $node = new EnquiryCategory(['name' => 'Money', 'alias' => 'money', 'image' => 'money.png', 'is_active' => 0, 'is_visible' => 1]);
        $node->makeRoot();
        $node = new EnquiryCategory(['name' => 'Car Hire', 'alias' => 'car_hire', 'image' => 'car_hire.png', 'is_active' => 0, 'is_visible' => 1]);
        $node->makeRoot();
        $node = new EnquiryCategory(['name' => 'Flights', 'alias' => 'flights', 'image' => 'flights.png', 'is_active' => 0, 'is_visible' => 1]);
        $node->makeRoot();
        $node = new EnquiryCategory(['name' => 'Food & Drink', 'alias' => 'food_n_drink', 'image' => 'food_n_drink.png', 'is_active' => 0, 'is_visible' => 1]);
        $node->makeRoot();
        $node = new EnquiryCategory(['name' => 'Home &Garden', 'alias' => 'home_n_garden', 'image' => 'home_n_garden.png', 'is_active' => 0, 'is_visible' => 1]);
        $node->makeRoot();

        exit();
//        return ExitCode::OK;
    }
}