
<meta charset="utf-8">
<meta class="viewport" name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="robots" content="noimageindex" />
<meta name="Generator" content="Nine Graphics"/>
<meta name="author" content="JV Electrical Essex Ltd"/>

<link rel="icon" href="/favicon.ico">

<?php
$this->widget('front.views.widgets.MetaTagsWidget', array(
    'currentPage'=>!empty($this->activeSubPage) ? $this->activeSubPage : $this->activePage
));
?>
<?php $this->renderPartial('//layouts/partials/share', array())?>
