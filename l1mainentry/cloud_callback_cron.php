<?php
/*
* created @2015/09/19 by QIU Lin
* backup MySQL database every xx mins
*/
include_once "../l1comvm/vmlayer.php";
/*   PHP CRON带参数执行
 *   command 命令行填写：php /home/piaoyi.org/public_html/cron.php q1 q2
 *   然后，在cron.php页面使用  $argv[1] 来获取 q1 第一个参数值， $argv[2] 获取第二个参数 q2 的值； $argv[0] 的值是路径及
 *   文件名，在这里为：/home/piaoyi.org/public_html/cron.php
 */

/*
 *  这里约定CRONTABLE的参数
 *  1. 只带第一个参数$arg[1]
 *  2. 1=1分钟，2=3分钟，3=10分钟，4=30分钟，5=1小时，6=6小时，7=24小时，8=2天，9=7天，10=30天
 *  3. 缺省当做1个小时定时
 *  4. 云上的VPS的CRONTABLE配置，需要指向本php文件
 */

//Timer_cron trigger
$obj = new classTaskL1vmCoreRouter();
if ($argv[1] == 1) $obj->mfun_l1vm_task_main_entry(MFUN_TASK_ID_L2TIMER_CRON, MSG_ID_L2TIMER_CRON_1MIN_COMING, "MSG_ID_L2TIMER_CRON_1MIN_COMING", MSG_ID_L2TIMER_CRON_1MIN_COMING);
elseif ($argv[1] == 2) $obj->mfun_l1vm_task_main_entry(MFUN_TASK_ID_L2TIMER_CRON, MSG_ID_L2TIMER_CRON_3MIN_COMING, "MSG_ID_L2TIMER_CRON_3MIN_COMING", MSG_ID_L2TIMER_CRON_3MIN_COMING);
elseif ($argv[1] == 3) $obj->mfun_l1vm_task_main_entry(MFUN_TASK_ID_L2TIMER_CRON, MSG_ID_L2TIMER_CRON_10MIN_COMING, "MSG_ID_L2TIMER_CRON_10MIN_COMING", MSG_ID_L2TIMER_CRON_10MIN_COMING);
elseif ($argv[1] == 4) $obj->mfun_l1vm_task_main_entry(MFUN_TASK_ID_L2TIMER_CRON, MSG_ID_L2TIMER_CRON_30MIN_COMING, "MSG_ID_L2TIMER_CRON_30MIN_COMING", MSG_ID_L2TIMER_CRON_30MIN_COMING);
elseif ($argv[1] == 5) $obj->mfun_l1vm_task_main_entry(MFUN_TASK_ID_L2TIMER_CRON, MSG_ID_L2TIMER_CRON_1HOUR_COMING, "MSG_ID_L2TIMER_CRON_1HOUR_COMING", MSG_ID_L2TIMER_CRON_1HOUR_COMING);
elseif ($argv[1] == 6) $obj->mfun_l1vm_task_main_entry(MFUN_TASK_ID_L2TIMER_CRON, MSG_ID_L2TIMER_CRON_6HOUR_COMING, "MSG_ID_L2TIMER_CRON_6HOUR_COMING", MSG_ID_L2TIMER_CRON_6HOUR_COMING);
elseif ($argv[1] == 7) $obj->mfun_l1vm_task_main_entry(MFUN_TASK_ID_L2TIMER_CRON, MSG_ID_L2TIMER_CRON_24HOUR_COMING, "MSG_ID_L2TIMER_CRON_24HOUR_COMING", MSG_ID_L2TIMER_CRON_24HOUR_COMING);
elseif ($argv[1] == 8) $obj->mfun_l1vm_task_main_entry(MFUN_TASK_ID_L2TIMER_CRON, MSG_ID_L2TIMER_CRON_2DAY_COMING, "MSG_ID_L2TIMER_CRON_2DAY_COMING", MSG_ID_L2TIMER_CRON_2DAY_COMING);
elseif ($argv[1] == 9) $obj->mfun_l1vm_task_main_entry(MFUN_TASK_ID_L2TIMER_CRON, MSG_ID_L2TIMER_CRON_7DAY_COMING, "MSG_ID_L2TIMER_CRON_7DAY_COMING", MSG_ID_L2TIMER_CRON_7DAY_COMING);
elseif ($argv[1] == 10) $obj->mfun_l1vm_task_main_entry(MFUN_TASK_ID_L2TIMER_CRON, MSG_ID_L2TIMER_CRON_30DAY_COMING, "MSG_ID_L2TIMER_CRON_30DAY_COMING", MSG_ID_L2TIMER_CRON_30DAY_COMING);
else $obj->mfun_l1vm_task_main_entry(MFUN_TASK_ID_L2TIMER_CRON, MSG_ID_L2TIMER_CRON_1HOUR_COMING, "MSG_ID_L2TIMER_CRON_1HOUR_COMING", MSG_ID_L2TIMER_CRON_1HOUR_COMING);


?>