<?php
/*
* created @2015/09/19 by QIU Lin
* backup MySQL database every 10 mins
*/

//10Min timer_cron trigger
$obj = new classTaskL1vmCoreRouter();
$obj->mfun_l1vm_task_main_entry(MFUN_TASK_ID_L2TIMER_CRON, NULL, NULL, MSG_ID_L2TIMER_CRON_10MIN_COMING);

?>