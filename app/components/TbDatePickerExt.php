<?php
Yii::import('bootstrap.widgets.TbDatePicker');

class TbDatePickerExt extends TbDatePicker
{

	public function registerClientScript()
	{
		$cs = Yii::app()->getClientScript();

		$cs->registerCssFile('/js/bootstrap-datepicker/css/datepicker.min.css');
		$cs->registerScriptFile('/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
	}

	public function registerLanguageScript()
	{

	}
}
