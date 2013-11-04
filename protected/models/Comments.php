<?php

/**
 * This is the model class for table "comments".
 *
 * The followings are the available columns in table 'comments':
 * @property integer $id
 * @property string $content
 * @property integer $mode
 * @property integer $item_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $is_admin
 * @property integer $avatar
 * @property integer $parent_id
 * @property integer $x
 * @property integer $y
 * @property integer $width
 * @property integer $height
 */
class Comments extends CActiveRecord
{
    public $parent_id = 0;
    public $captcha;
    public $imgWidth;
    public $imgHeight;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Comments the static model class
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
        return 'comments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('mode, item_id, is_admin', 'numerical', 'integerOnly' => true),
            array('content, created_at, updated_at, avatar, x, y, width, height, imgWidth, imgHeight', 'safe'),

            // Create scenario
            array('content', 'length', 'min' => 1, 'max'=>'145', 'allowEmpty' => false, 'on' => 'create, create_hover'),
            array('created_at', 'default', 'value' => new CDbExpression('NOW()'), 'on' => 'create, create_hover'),
            array('parent_id', 'default', 'value' => 0, 'setOnEmpty' => true, 'on' => 'create, create_hover'),

            array('captcha', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements(), 'on' => 'create'),
            array('captcha', 'captcha', 'allowEmpty' => true, 'on' => 'create_hover'),

            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, content, mode, item_id, created_at, updated_at, is_admin', 'safe', 'on' => 'search, update'),
        );
    }

    public function beforeSave()
    {
        if ($this->is_admin) {
            $this->avatar = 0;
        }
        else if ($this->avatar > Stages::getStage() || $this->avatar == 0) {
            $this->avatar = 1;
        }
        if($this->isNewRecord)
        {
            $this->x = round((100 / $this->imgWidth) * ($this->x + 6));
            $this->y = round((100 / $this->imgHeight) * ($this->y + 18));
        }
        return parent::beforeSave();
    }


    public function behaviors()
    {
        return array(
            'PurifyText' => array(
                'class' => 'DPurifyTextBehavior',
                'sourceAttribute' => 'content',
                'destinationAttribute' => 'content',
                'purifierOptions' => array(
                    'HTML.Allowed'=> '',
                ),
                'processOnBeforeSave' => true,
            )
        );
    }

    public function afterSave()
    {
        parent::afterSave();

        /* @var $item Items */
        if ($this->isNewRecord) {
            $item = Items::model()->findByPk($this->item_id);
            $item->comments_count = $item->comments_count + 1;
            $item->updated_at = new CDbExpression('NOW()');
            $item->save(false);
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'content' => 'Content',
            'mode' => 'Mode',
            'item_id' => 'Item',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_admin' => 'Is Admin',
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
        $criteria->compare('mode', $this->mode);
        $criteria->compare('item_id', $this->item_id);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('is_admin', $this->is_admin);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}