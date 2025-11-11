
<?php if(!empty($model)): ?>
    <div class="container pt-90 blog-section">

        <div class="row">
            <div class="col-md-12">
                <h2 class="bold mb-40">BLOG & NEWS</h2>
            </div>
        </div>

        <div class="row">
            <?php foreach($model as $item): ?>
                <?php $this->render('partials/news_post', array(
                    'model'=>$item
                ))?>
            <?php endforeach; ?>
        </div>

    </div>
<?php endif; ?>

