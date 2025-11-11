<div class="inline-form">
    <?php if($this->range): ?>
        from
        <?php $this->widget('bootstrap.widgets.TbDatePicker', array(
            'name'=>$this->getNameWithPostfix('start'),
            'form' => $this->form,
            'model' => $this->model,
            'options' => array(
                'format' => 'yyyy-mm-dd',
            ),
            'htmlOptions'=>array(
                'id'=>$this->getIdWithPostfix('start')
            )
        )); ?>
        to
        <?php $this->widget('bootstrap.widgets.TbDatePicker', array(
            'name'=>$this->getNameWithPostfix('end'),
            'form' => $this->form,
            'model' => $this->model,
            'options' => array(
                'format' => 'yyyy-mm-dd',
            ),
            'htmlOptions'=>array(
                'id'=>$this->getIdWithPostfix('end')
            )
        )); ?>
    <?php else: ?>
        <?php $this->widget('bootstrap.widgets.TbDatePicker', array(
            'name'=>$this->name,
            'form' => $this->form,
            'model' => $this->model,
            'options' => array(
                'format' => 'yyyy-mm-dd',
            )
        )); ?>
    <?php endif; ?>
</div>