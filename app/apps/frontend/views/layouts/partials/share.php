<?php if(!empty($this->shareData)): ?>
    <?php $data = $this->shareData;?>

    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo $data->url?>" />
    <meta property="og:title" content="<?php echo $data->title?>" />
    <meta property="og:description" content="<?php echo str_replace('"', "'", $data->preview)?>" />

    <?php if(!empty($data->sharingImage)): ?>
        <meta property="og:image" content="<?php echo $data->sharingImage?>" />
    <?php endif; ?>

<?php endif; ?>