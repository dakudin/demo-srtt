<?php
/**
 * Created by Kudin Dmitry
 * Date: 17.01.2019
 * Time: 15:07
 */

namespace common\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;

class EnquiryCategoryQuery extends \yii\db\ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}