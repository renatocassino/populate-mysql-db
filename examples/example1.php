<?php

date_default_timezone_set('America/Los_Angeles');

/**
Table example

CREATE TABLE `table_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  `bigint` bigint(20) DEFAULT NULL,
  `mediumint` mediumint(9) DEFAULT NULL,
  `smallint` smallint(6) DEFAULT NULL,
  `tinyint` tinyint(4) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `text` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1

Command:
php examples/example1.php
 */

require dirname(dirname(__FILE__)) . '/src/Populate/LoremIpsumGenerator.class.php';
require dirname(dirname(__FILE__)) . '/src/Populate/Populate.class.php';

try {
	$pdo = new PDO("mysql:host=localhost;dbname=test;charset=utf8",'root','Piko-iko');
	$populate = new Populate();
	$populate->beginWithLoremIpsum(false);
	$populate->setPDO($pdo);

	$populate->setTable('table_test');
	$populate->setFixValue('image_example','/assets/image/photo.jpg');
	echo $populate->insert(100);
	//echo $populate->clear();
}
catch(Exception $e)
{
	die($e->getMessage());
}
