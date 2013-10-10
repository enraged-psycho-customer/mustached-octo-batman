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
 * @property int $comments_count
 * @property string $email
 * @property string $title
 */
class Items extends CActiveRecord
{
    const SPOILER_LIMIT = 500;

    const CATEGORY_QUOTES = 1;
    const CATEGORY_IMAGES = 2;
    const CATEGORY_INQUISITION = 3;

    const STATE_SUBMITTED = 0;
    const STATE_AWAITING_MODERATION = 1;
    const STATE_PUBLISHED = 2;
    const STATE_JUNK = 3;

    const DEFAULT_SORT_TYPE = 'created_at';
    const DEFAULT_SORT_DIR = 'desc';

    const IMAGE_TEMP_DIR = 'uploads/temp/';
    const IMAGE_DIR = 'uploads/item/image/';

    const THUMB_WIDTH = 480;
    const THUMB_HEIGHT = 240;

    const FILE_LIMIT = 5;

    private $categories = array(
        self::CATEGORY_QUOTES,
        self::CATEGORY_IMAGES,
        self::CATEGORY_INQUISITION,
    );

    private $sort_types = array(
        'created_at',
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
     * Image upload handler
     *
     * @param $fullFileName
     * @param $userdata
     */
    public function onImageUploaded($fullFileName, $userdata)
    {
        //var_dump($fullFileName);
        Yii::app()->user->setState('image_upload', $fullFileName);
    }

    /**
     * File upload handler
     *
     * @param $fullFileName
     * @param $userdata
     */
    public function onFilesUploaded($fullFileName, $userdata)
    {
        $file_upload = Yii::app()->user->getState('file_upload');
        if (is_null($file_upload) || count($file_upload) >= Items::FILE_LIMIT) $file_upload = array();
        $file_upload[] = $fullFileName;
        Yii::app()->user->setState('file_upload', $file_upload);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            // Default validators
            array('category, rating', 'numerical', 'integerOnly' => true),
            array('image', 'length', 'max' => 255),

            // Create scenario
            array('content, category, email, title', 'safe', 'on' => 'create, create_image'),
            array('category', 'in', 'range' => $this->categories, 'allowEmpty' => false, 'on' => 'create, create_image'),

            array('content', 'length', 'min' => 1, 'allowEmpty' => false, 'on' => 'create'),
            array('content', 'length', 'min' => 1, 'allowEmpty' => true, 'on' => 'create_image'),

            array('email', 'length', 'max' => 255, 'allowEmpty' => true, 'on' => 'create, create_image'),
            array('email', 'email', 'allowEmpty' => true, 'on' => 'create, create_image'),

            array('state', 'default', 'value' => self::STATE_PUBLISHED, 'setOnEmpty' => false, 'on' => 'create, create_image'),
            array('created_at', 'default', 'value' => new CDbExpression('NOW()'), 'on' => 'create, create_image'),
            array('rating', 'default', 'value' => 0, 'on' => 'create, create_image'),

            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, content, category, state, image, rating, created_at, updated_at, comments_count', 'safe', 'on' => 'search, update'),
        );
    }

    public function behaviors()
    {
        return array(
            'PurifyText' => array(
                'class' => 'DPurifyTextBehavior',
                'sourceAttribute' => 'content',
                'destinationAttribute' => 'content',
                'purifierOptions' => array(
                    'HTML.Allowed'=> 'b,strong,br',
                ),
                'processOnBeforeSave' => true,
            )
        );
    }

    public function validateContent()
    {
        if (!strlen($this->content)) {
            $this->addError('content', 'Введите текст цитаты');
            return false;
        } else {
            $this->content = nl2br($this->content);
            return true;
        }
    }

    public function beforeSave()
    {
        if ($this->scenario == 'create' || $this->scenario == 'create_image') {
            switch ($this->category) {
                case self::CATEGORY_QUOTES:
                    if (!$this->validateContent()) return false;
                    break;

                case self::CATEGORY_IMAGES:
                    $image_session = Yii::app()->user->getState('image_upload');
                    if (!strlen($image_session)) {
                        $this->addError('image', 'Загрузите картинку (не более 2МБ)');
                        return false;
                    }
                    break;

                case self::CATEGORY_INQUISITION:
                    if (!$this->validateContent()) return false;
                    if (!strlen($this->title)) {
                        $this->addError('title', 'Введите имя клиента');
                        return false;
                    }

                    break;
            }
        }

        return parent::beforeSave();
    }

    public function afterSave()
    {
        parent::afterSave();

        if ($this->isNewRecord && ($this->scenario == 'create' || $this->scenario == 'create_image')) {
            switch ($this->category) {
                case self::CATEGORY_IMAGES:
                    $this->processImage();
                    break;

                case self::CATEGORY_INQUISITION:
                    $this->proccessFiles();
                    break;
            }
        }
    }

    public function proccessFiles()
    {
        // Create item directory
        $files = Yii::app()->user->getState('file_upload');
        if (!is_null($files)) {
            $file_directory = self::IMAGE_DIR . $this->id . DIRECTORY_SEPARATOR;
            mkdir($file_directory);

            // Copy all files
            foreach ($files as $file) {
                // Copy new file
                $filename = str_replace(self::IMAGE_TEMP_DIR, '', $file);
                copy($file, $file_directory . $filename);

                // Save metadata to database
                $fileModel = new Files();
                $fileModel->item_id = $this->id;
                $fileModel->filename = $filename;
                $fileModel->save();

                // Remove temp files
                unlink($file);
            }
        }

        // Remove upload state
        Yii::app()->user->setState('file_upload', NULL);
    }

    public function processImage()
    {
        // Copy image from temp directory
        $image_session = Yii::app()->user->getState('image_upload');
        $image_directory = self::IMAGE_DIR . $this->id . DIRECTORY_SEPARATOR;
        $this->image = str_replace(self::IMAGE_TEMP_DIR, '', $image_session);

        mkdir($image_directory);
        copy($image_session, $image_directory . $this->image);

        // Create thumbnail
        $image = new EasyImage($image_directory . $this->image);
        $image->resize(self::THUMB_WIDTH, self::THUMB_HEIGHT);
        $image->save($image_directory . 'thumb_' . $this->image);

        // Save new image data
        $this->isNewRecord = false;
        $this->saveAttributes(array('image'));

        // Remove upload state and temp file
        Yii::app()->user->setState('image_upload', NULL);
        unlink($image_session);
    }

    public function getImageDir()
    {
        return '/' . self::IMAGE_DIR . $this->id . '/';
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
            'files' => array(self::HAS_MANY, 'Files', 'item_id'),
        );
    }

    public function getCategories()
    {
        $stage = Stages::getStage();

        $categories = array();

        if ($stage >= Stages::STAGE_INIT) {
            $categories[self::CATEGORY_QUOTES] = 'Новая цитата';
            $categories[self::CATEGORY_IMAGES] = 'Новая картинка';
        }

        if ($stage >= Stages::STAGE_INQUISITION) {
            $categories[self::CATEGORY_INQUISITION] = 'Новый грешник';
        }

        return $categories;
    }

    public function getComments()
    {
        $result = array(0 => array());
        if (!count($this->comments)) return $result;

        foreach ($this->comments as $comment) {
            $result[$comment->parent_id][] = $comment;
        }

        return $result;
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
            'inquisition' => array(
                'condition' => 'category = :category',
                'params' => array(':category' => self::CATEGORY_INQUISITION),
            ),
        );
    }

    public function filterBy($query = null, $type = null, $direction = null)
    {
        // Search
        if (!is_null($query) && mb_strlen($query) >= 3) {
            $criteria = new CDbCriteria;
            $criteria->compare('content', $query, true, 'OR');
            $criteria->compare('title', $query, true, 'OR');
            $this->getDbCriteria()->mergeWith($criteria);
        }

        // Hidden items
        $hiddenItems = explode(",", Yii::app()->request->cookies['hiddenItems']);
        if (is_array($hiddenItems) && count($hiddenItems)) {
            $criteria = new CDbCriteria;
            $criteria->addNotInCondition('id', $hiddenItems);
            $this->getDbCriteria()->mergeWith($criteria);
        }

        // Order and direction
        if (is_null($type) || !in_array($type, $this->sort_types)) $type = self::DEFAULT_SORT_TYPE;
        if (is_null($direction) || !in_array($direction, $this->sort_dirs)) $direction = self::DEFAULT_SORT_DIR;
        $order = implode(" ", array($type, $direction));
        $this->getDbCriteria()->mergeWith(array('order' => $order));

        return $this;
    }
}