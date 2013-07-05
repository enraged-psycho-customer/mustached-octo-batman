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
 * @property string $published_at
 * @property int $comments_count
 * @property string $email
 */
class Items extends CActiveRecord
{
    const CATEGORY_QUOTES = 1;
    const CATEGORY_IMAGES = 2;

    const STATE_SUBMITTED = 0;
    const STATE_AWAITING_MODERATION = 1;
    const STATE_PUBLISHED = 2;
    const STATE_JUNK = 3;

    const DEFAULT_SORT_TYPE = 'published_at';
    const DEFAULT_SORT_DIR = 'desc';

    private $categories = array(
        self::CATEGORY_QUOTES,
        self::CATEGORY_IMAGES
    );

    private $sort_types = array(
        'published_at',
        'updated_at',
        'comments_count'
    );

    private $sort_dirs = array(
        'asc',
        'desc'
    );

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
            array('content, created_at, updated_at, published_at, comments_count', 'safe'),

            // Create scenario
            array('category', 'in', 'range' => $this->categories, 'allowEmpty' => false, 'on' => 'create'),
            array('content', 'length', 'min' => 10, 'max' => 2000, 'allowEmpty' => false, 'on' => 'create'),

            array('email', 'length', 'max' => 255, 'allowEmpty' => false, 'on' => 'create'),
            array('email', 'email', 'allowEmpty' => false, 'on' => 'create'),

            array('state', 'default', 'value' => self::STATE_SUBMITTED, 'on' => 'create'),
            array('created_at', 'default', 'value' => new CDbException('NOW()'), 'on' => 'create'),
            array('rating', 'default', 'value' => 0, 'on' => 'create'),

            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, content, category, state, image, rating, created_at, updated_at, published_at, comments_count', 'safe', 'on' => 'search'),
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

    public function getCategories()
    {
        return array(
            self::CATEGORY_QUOTES => 'Новая цитата',
            self::CATEGORY_IMAGES => 'Новая картинка',
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'content' => 'Текст',
            'category' => 'Category',
            'state' => 'State',
            'image' => 'Image',
            'rating' => 'Rating',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'email' => 'E-mail'
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
        $criteria->compare('published_at', $this->published_at, true);
        $criteria->compare('comments_count', $this->comments_count, true);
        $criteria->compare('email', $this->email, true);

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
        );
    }

    public function sortBy($type, $direction)
    {
        if (is_null($type) || !in_array($type, $this->sort_types)) $type = self::DEFAULT_SORT_TYPE;
        if (is_null($direction) || !in_array($direction, $this->sort_dirs)) $direction = self::DEFAULT_SORT_DIR;
        $order = implode(" ", array($type, $direction));

        $this->getDbCriteria()->mergeWith(array(
            'order' => $order,

        ));
        return $this;
    }
}