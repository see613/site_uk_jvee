
<div id="shallow-picture" class="shallow-slider"
     data-percent-height="<?=$data[0]['percentHeight']?>"
     data-min-height="<?=$data[0]['minHeight']?>"
     data-valign="<?=$data[0]['valign']?>">

    <?php foreach($data as $item):?>
        <div class="item relative">
            <img src="<?=$item['picture']?>">
        </div>
    <?php endforeach;?>

    <div class="content">
        <?php
        $number = count($data);
        $i=0;
        ?>
        <?php foreach($data as $item):?>
            <?php $i++?>
            <div class="inner">
                <div class="headline">
                    <h1>
                        <div class="animation"><?=$item['headline-1']?></div>
                        <div class="animation"><?=$item['headline-2']?></div>
                    </h1>
                </div>

                <div class="pagination animation">
                    <table>
                        <tr>
                            <?php for($j=1; $j<=$number; $j++):?>
                                <td class="<?=$j==$i ? 'active' : ''?>"></td>
                            <?php endfor;?>
                        </tr>
                    </table>
                </div>

                <div class="description animation">
                    <p><?=$item['description']?></p>
                </div>
            </div>
        <?php endforeach;?>

    </div>
</div>



