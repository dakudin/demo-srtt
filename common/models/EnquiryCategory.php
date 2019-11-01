<?php

namespace common\models;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;

/**
 * This is the model class for table "enquiry_category".
 * use NestedSetBehavior
 *
 * @property integer $id
 * @property integer $tree
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property string $name
 * @property string $alias
 * @property integer $is_active
 * @property integer $is_visible
 * @property string $image
 * @property string $enquiry_class_name
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_keyword
 * @property string $seo_h1
 */
class EnquiryCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'enquiry_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['lft', 'rgt', 'depth', 'name', 'alias', 'image'], 'required'],
            [['name', 'alias', 'image'], 'required'],
            [['tree', 'lft', 'rgt', 'depth', 'is_active', 'is_visible'], 'integer'],
            [['name', 'alias', 'image'], 'string', 'max' => 50],
            [['name', 'alias'], 'unique'],
            [['enquiry_class_name'], 'string', 'max' => 20],
            [['seo_title'], 'string', 'max' => 100],
            [['seo_description', 'seo_keyword'], 'string', 'max' => 160],
            [['seo_h1'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tree' => 'Tree',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'depth' => 'Depth',
            'name' => 'Name',
            'alias' => 'Alias',
            'is_active' => 'Is Active',
            'is_visible' => 'Is Visible',
            'image' => 'Image',
        ];
    }

    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new EnquiryCategoryQuery(get_called_class());
    }

    public function getImageUrl()
    {
        if($this->is_active){
            return '/images/category/' . $this->image;
        }

        return '/images/category/coming-soon/' . $this->image;
    }
}
