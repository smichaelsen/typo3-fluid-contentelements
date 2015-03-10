<?php

/**************************************************************************
 * Extension Manager/Repository config file for ext "fluid_contentelements".
 *************************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Fluid Content Elements',
	'description' => 'Simple way to create new content element types rendered with fluid',
	'category' => 'frontend',
	'author' => 'Sebastian Michaelsen',
	'author_email' => 'sebastian@michaelsen.io',
	'state' => 'stable',
	'version' => '1.0.0',
	'constraints' => array(
		'depends' => array(
			'typo3' => '6.0.0-7.99.99',
		),
	),
);
