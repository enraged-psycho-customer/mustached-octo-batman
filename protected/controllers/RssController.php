<?php
/**
 * Created by PhpStorm.
 * User: alexok
 * Date: 08.03.14
 * Time: 2:37
 */

class RssController extends CController
{
    public function actionFeed()
    {
        Yii::import('ext.efeed.*');
        $feed = new EFeed();

        $feed->title= 'Адовые Клиенты!';
        $feed->description = '';

        /*$feed->setImage('Testing RSS 2.0 EFeed class','http://www.ramirezcobos.com/rss',
            'http://www.yiiframework.com/forum/uploads/profile/photo-7106.jpg');*/

        //$feed->addChannelTag('language', 'en-us');
        $feed->addChannelTag('pubDate', date(DATE_RSS));
        $feed->addChannelTag('link', 'http://clfh.org');
        //$feed->addChannelTag('atom:link','http://www.ramirezcobos.com/rss/');

        $criteria = new CDbCriteria();
        $criteria->condition = 'YEAR(created_at) = YEAR(CURDATE())';
        $criteria->limit = 3;
        $criteria->order = 'created_at';

        $models = Items::model()->findAll($criteria);

        foreach($models as $model) { /* @var Items $model */

            /* @var EFeedItemRSS2 $item */
            $item = $feed->createNewItem();

            $item->title = $model->getTitle();
            //$item->link = "";
            $item->date = time();
            $item->description = $model->content;

            //$item->setEncloser('http://www.tester.com', '1283629', 'audio/mpeg');
            //$item->addTag('author', 'thisisnot@myemail.com (Antonio Ramirez)');
            //$item->addTag('guid', 'http://www.ramirezcobos.com/',array('isPermaLink'=>'true'));

            $feed->addItem($item);
        }



        $feed->generateFeed();
        Yii::app()->end();
    }
} 