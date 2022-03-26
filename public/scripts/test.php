<?php

use app\models\CronEmail;

$cron_email = new CronEmail();

$cron_email = $cron_email->getAll();

var_dump($cron_email);

