
<a href="<?=$model->url?>" class="col-sm-6 col-md-4 blog-post">
    <div class="image-wrapper">
        <img src="<?=$model->imageSmall?>" alt="<?=$model->title?>">
    </div>

    <p class="date"><?=$model->createdNice?></p>
    <h3 class="headline"><?=$model->title?></h3>
    <p class="tags"><?=$model->tags?></p>
</a>

