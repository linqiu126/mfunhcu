<?php
/**
 * Created by PhpStorm.
 * User: Zehong Liu
 * Date: 2017/1/22
 * Time: 15:51
 */

//HUITP协议消息

//云控锁-锁
define("HUITP_MSGID_uni_ccl_lock_min", 0x4D00);
define("HUITP_MSGID_uni_ccl_lock_req", 0x4D00);
define("HUITP_MSGID_uni_ccl_lock_resp", 0x4D80);
define("HUITP_MSGID_uni_ccl_lock_report", 0x4D81);
define("HUITP_MSGID_uni_ccl_lock_confirm", 0x4D01);
define("HUITP_MSGID_uni_ccl_lock_auth_inq", 0x4D90);
define("HUITP_MSGID_uni_ccl_lock_auth_resp", 0x4D10);
define("HUITP_MSGID_uni_ccl_lock_max", 0x4D10);

//云控锁-状态聚合
define("HUITP_MSGID_uni_ccl_state_min", 0x4E00);
define("HUITP_MSGID_uni_ccl_state_req", 0x4E00);
define("HUITP_MSGID_uni_ccl_state_resp", 0x4E80);
define("HUITP_MSGID_uni_ccl_state_report", 0x4E81);
define("HUITP_MSGID_uni_ccl_state_confirm", 0x4E01);
define("HUITP_MSGID_uni_ccl_state_max", 0x4E01);




?>

