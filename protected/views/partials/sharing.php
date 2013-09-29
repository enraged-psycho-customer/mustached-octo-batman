<?php
$title_parts = array(Yii::app()->name);
$category = Stages::getCategory($this->category);
if (!is_null($category)) $title_parts[] = $category;
$title = implode(" - ", $title_parts);
?>
<meta name="title" content="<?php echo $title; ?>" />
<meta name="description" content="<?php echo $this->description; ?>" />
<?php if (!is_null($this->image)): ?>
<meta property="og:image" content="<?php echo $this->image; ?>"/>
<?php endif; ?>
<link rel="image_src" href="<?php echo $this->createAbsoluteUrl($this->assetsUrl . "/share/_main.png"); ?>" />
<link rel="image_src" href="<?php echo $this->createAbsoluteUrl($this->assetsUrl . "/share/2.png"); ?>" />
<link rel="image_src" href="<?php echo $this->createAbsoluteUrl($this->assetsUrl . "/share/3.png"); ?>" />
<link rel="image_src" href="<?php echo $this->createAbsoluteUrl($this->assetsUrl . "/share/4.png"); ?>" />
<link rel="image_src" href="<?php echo $this->createAbsoluteUrl($this->assetsUrl . "/share/5.png"); ?>" />
<link rel="image_src" href="<?php echo $this->createAbsoluteUrl($this->assetsUrl . "/share/6.png"); ?>" />

<meta property="og:title" content="<?php echo $title; ?>"/>
<meta property="og:description" content="<?php echo $this->description; ?>"/>
<?php if (!is_null($this->image)): ?>
<meta property="og:image" content="<?php echo $this->image; ?>"/>
<?php endif; ?>
<meta property="og:image" content="<?php echo $this->createAbsoluteUrl($this->assetsUrl . "/share/_main.png"); ?>"/>
<meta property="og:image" content="<?php echo $this->createAbsoluteUrl($this->assetsUrl . "/share/2.png"); ?>"/>
<meta property="og:image" content="<?php echo $this->createAbsoluteUrl($this->assetsUrl . "/share/3.png"); ?>"/>
<meta property="og:image" content="<?php echo $this->createAbsoluteUrl($this->assetsUrl . "/share/4.png"); ?>"/>
<meta property="og:image" content="<?php echo $this->createAbsoluteUrl($this->assetsUrl . "/share/5.png"); ?>"/>
<meta property="og:image" content="<?php echo $this->createAbsoluteUrl($this->assetsUrl . "/share/6.png"); ?>"/>