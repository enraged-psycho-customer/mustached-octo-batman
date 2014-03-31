<?php
/**
 * Created by PhpStorm.
 * User: alexok
 * Date: 08.03.14
 * Time: 2:37
 */

class RssController extends CController
{
    public function actionFeed($month = null)
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'state = :state AND YEAR(created_at) = YEAR(CURDATE())';
        $criteria->params[':state'] = Items::STATE_PUBLISHED;
        $criteria->order = 'created_at DESC';

        if ($month == null) {
            $criteria->limit = 5;
        } else {
            $criteria->addCondition('MONTH(created_at) = :month');
            $criteria->params['month'] = (int) $month;
        }

        $models = Items::model()->findAll($criteria);

        Yii::import('ext.efeed.*');
        $feed = new EFeed();

        $feed->title= 'Адовые клиенты';
        $feed->description = 'Лента адовых клиентов';

        $feed->addChannelTag('link', Yii::app()->createAbsoluteUrl('/'));
        //$feed->addChannelTag('atom:link', Yii::app()->createAbsoluteUrl('rss/feed'));

        if (count($models)) {
            $feed->addChannelTag('pubDate', date_create($models[0]->created_at)->format(DATE_RSS));
        } else {
            $feed->addChannelTag('pubDate', date(DATE_RSS));
        }

        foreach($models as $model) { /* @var Items $model */
            /* @var EFeedItemRSS2 $item */
            $item = $feed->createNewItem();

            $url = Yii::app()->createAbsoluteUrl('items/view', array('id'=>$model->id));

            $item->title = trim($model->getTitle());
            $item->link = trim($url);
            $item->date = date_create($model->created_at)->format(DATE_RSS);

            $image = $this->getRandomImage();

            if ($image) {
                $item->description = sprintf('<table><tr><td>%s</td><td>%s</td></tr></table>', $image, $model->content);
            } else {
                $item->description = $model->content;
            }

            $feed->addItem($item);
        }

        $feed->generateFeed();
        //Yii::app()->end();
    }

    public function actionTest()
    {
        echo $this->getRandomImage();
    }

    private function getRandomImage()
    {
        $path = Yii::getPathOfAlias('webroot');
        $file = sprintf('images/share/%s.png', rand(1,6));

        if (is_file($path .DS. $file)) {
            return Yii::app()->createAbsoluteUrl(Yii::app()->homeUrl).'/'.$file;
        }

        return null;
    }
}
