<?php
/* @var SiteController $this */
/** @var $map */

$this->widget('\YandexMaps\Canvas', array(
		'htmlOptions' => array(
			'class' => 'twelve columns panel',
			'style' => 'height: 600px;',
		),
		'map' => $map,
	));