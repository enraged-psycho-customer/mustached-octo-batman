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
 */
class Comments extends CActiveRecord
{
    const AVATAR_BOY = 1;
    const AVATAR_GIRL = 2;

    public $avatar = 1;
    public $parent_id = 0;
    public $captcha;

    private $avatars = array(
        self::AVATAR_BOY => 'boy',
        self::AVATAR_GIRL => 'girl',
    );

    public function getAvatarClass()
    {
        $parts = array('avatar');
        if ($this->is_admin) $parts[] = 'admin';
        else $parts[] = isset($this->avatars[$this->avatar]) ? $this->avatars[$this->avatar] : 'boy';

        return implode("_", $parts);
    }

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
            array('content, created_at, updated_at', 'safe'),

            // Create scenario
            array('content', 'length', 'min' => 1, 'max' => 500, 'allowEmpty' => false, 'on' => 'create'),
            array('created_at', 'default', 'value' => new CDbException('NOW()'), 'on' => 'create'),
            array('parent_id', 'default', 'value' => 0, 'setOnEmpty' => true, 'on' => 'create'),
            array('avatar', 'default', 'value' => self::AVATAR_BOY, 'setOnEmpty' => true, 'on' => 'create'),

            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, content, mode, item_id, created_at, updated_at, is_admin', 'safe', 'on' => 'search'),
        );
    }

    public function afterSave()
    {
        $item = Items::model()->findByPk($this->item_id);
        $item->saveCounters(array('comments_count' => 1));

        parent::afterSave();
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