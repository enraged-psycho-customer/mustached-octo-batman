<?php

/**
 * This is the model class for table "items".
 *
 * The followings are the available columns in table 'items':
 * @property integer $id
 * @property string $content
 * @property integer $category
 * @property integer $state
 * @property string $image
 * @property integer $rating
 * @property string $created_at
 * @property string $updated_at
 */
class Items extends CActiveRecord
{
    const CATEGORY_QUOTES = 1;
    const CATEGORY_IMAGES = 3;

    const STATE_SUBMITTED = 0;
    const STATE_AWAITING_MODERATION = 1;
    const STATE_PUBLISHED = 2;
    const STATE_JUNK = 3;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Items the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'items';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('category, state, rating', 'numerical', 'integerOnly' => true),
            array('image', 'length', 'max' => 255),
            array('content, created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, content, category, state, image, slug, rating, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'comments' => array(self::HAS_MANY, 'Comments', 'item_id'),
            'commentsCount' => array(self::STAT, 'Comments', 'item_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'content' => 'Content',
            'category' => 'Category',
            'state' => 'State',
            'image' => 'Image',
            'rating' => 'Rating',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('category', $this->category);
        $criteria->compare('state', $this->state);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('rating', $this->rating);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function scopes()
    {
        return array(
            'published' => array(
                'condition' => 'state = :state',
                'params' => array(':state' => self::STATE_PUBLISHED),
            ),
            'quotes' => array(
                'condition' => 'category = :category',
                'params' => array(':category' => self::CATEGORY_QUOTES),
            ),
            'images' => array(
                'condition' => 'category = :category',
                'params' => array(':category' => self::CATEGORY_IMAGES),
            ),
            'latest' => array(
                'order' => 'updated_at DESC'
            ),
        );
    }
}