<?php

CroogoNav::add('settings.children.noaa', array(
	'title' => 'NOAA',
	'url' => array(
		'admin' => true,
		'plugin' => 'settings',
		'controller' => 'settings',
		'action' => 'prefix',
		'NOAA',
	),
));