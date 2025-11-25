<?php PagesInfoStorage::initiate($this->activePage);?>
<!doctype html>
<html lang="en">
<head>
    <?php $this->renderPartial('//layouts/partials/meta', [])?>
</head>
<body class="<?=$this->activePage?>-page" id="top">
    <div id="back-to-top" class="local-link">
        <a href="#top">Back to Top</a>
    </div>

    <?php $this->renderPartial('//layouts/partials/header', [])?>

    <?=$content?>

    <?php $this->renderPartial('//layouts/partials/footer', [])?>

    <?php
    $cs = Yii::app()->getClientScript();

    $cs->registerCssFile('/js/jReject/css/jquery.reject.css');

    $cs->registerCssFile('/js/bootstrap/css/bootstrap.min.css');

    $cs->registerCssFile('/js/Smooth-Div-Scroll/css/smoothDivScroll.css');

    $cs->registerCssFile('/css/helpers.css?1');
    $cs->registerCssFile('/css/helpers-media.css?1');

    $cs->registerCssFile('/css/styles.css?2');


    $cs->registerCoreScript('jquery');

    $cs->registerScriptFile('/js/jquery.browser.min.js');
    $cs->registerScriptFile('/js/jReject/js/jquery.reject.js');

    $cs->registerScriptFile('/js/bootstrap/js/bootstrap.min.js');
    $cs->registerScriptFile('/js/jquery.sticky.js');
    $cs->registerScriptFile('/js/jquery.appear.js');

    $cs->registerScriptFile('/js/jQuery-Parallax/scripts/jquery.parallax-1.1.3.js');
    $cs->registerScriptFile('/js/jQuery-Parallax/scripts/jquery.localscroll.min.js');
    $cs->registerScriptFile('/js/jQuery-Parallax/scripts/jquery.scrollto.min.js');

    $cs->registerCssFile('/js/slick/slick.css');
    //$cs->registerCssFile('/js/slick/slick-theme.css');
    $cs->registerScriptFile('/js/slick/slick.min.js');

    $cs->registerScriptFile('/js/scripts.js?1');
    ?>
</body>
</html>