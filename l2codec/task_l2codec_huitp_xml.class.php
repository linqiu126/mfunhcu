<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/25
 * Time: 15:02
 */

include_once "l2codec_huitp_msg_dict.php";

class classHuitpMsgDecode
{
    //构造函数
    public function __construct()
    {

    }

    private function func_huitp_ieid_uni_com_report($ieData)
    {
        switch($ieData)
        {
            case HUITP_IEID_UNI_COM_REPORT_NULL:
                $resp ="HUITP_IEID_UNI_COM_REPORT_NULL";
                break;
            case HUITP_IEID_UNI_COM_REPORT_YES:
                $resp ="HUITP_IEID_UNI_COM_REPORT_YES";
                break;
            case HUITP_IEID_UNI_COM_REPORT_NO:
                $resp ="HUITP_IEID_UNI_COM_REPORT_NO";
                break;
            case HUITP_IEID_UNI_COM_REPORT_INVALID:
                $resp ="HUITP_IEID_UNI_COM_REPORT_INVALID";
                break;
            default:
                $resp ="";
                break;
        }

        return $resp;
    }

    public function mfun_l1vm_huitp_msg_decode($msgData, $msgLen)
    {
        //先生成$loggerObj对应的指针
        $loggerObj = new classApiL1vmFuncCom();
        $log_time = date("Y-m-d H:i:s", time());

        //先处理接收到的消息的基本情况
        if (empty($msgData) == true){
            $loggerObj->logger("NULL", "mfun_l1vm_task_main_entry", $log_time, "P: empty message IE received");
            echo "";
            //return false;
        }

        $ie_ptr = 0;
        $ie_unpack = array();
        while($ie_ptr < $msgLen)
        {
            $ieId = substr($msgData, $ie_ptr, MFUN_HUITP_IEID_LENGTH);
            $ieId = hexdec($ieId) & 0xFFFF; //转化成10进制整数
            $ie_ptr = $ie_ptr + MFUN_HUITP_IEID_LENGTH; //取数指针移到下一个读取位置

            $ieLen = substr($msgData, $ie_ptr, MFUN_HUITP_IELEN_LENGTH);
            $ieLen = hexdec($ieLen) & 0xFFFF; //转化成10进制整数
            $ie_ptr = $ie_ptr + MFUN_HUITP_IELEN_LENGTH; //取数指针移到下一个读取位置

            switch($ieId)
            {
                case HUITP_IEID_uni_com_report:
                    $ieData = substr($msgData, $ie_ptr, ($ieLen * 2));
                    if ($ieLen != strlen($ieData)/2) {
                        return "HUITP_IEID_uni_com_report length invalid";  //消息长度不合法，直接返回
                    }
                    $ie_ptr = $ie_ptr + $ieLen * 2;
                    $ie_unpack = array(HUITP_IEID_uni_com_report=>array('baseReport'=>$ieData));
                    break;
                case HUITP_IEID_uni_ccl_lock_state:
                    $maxLockNo = substr($msgData, $ie_ptr, MFUN_HUITP_IELEN_1B);
                    $ie_ptr = $ie_ptr + MFUN_HUITP_IELEN_1B;
                    $lockId = substr($msgData, $ie_ptr, MFUN_HUITP_IELEN_1B);
                    $ie_ptr = $ie_ptr + MFUN_HUITP_IELEN_1B;
                    $lockState = substr($msgData, $ie_ptr, MFUN_HUITP_IELEN_4B);
                    $ie_ptr = $ie_ptr + MFUN_HUITP_IELEN_4B;
                    $ie_unpack = array(HUITP_IEID_uni_ccl_lock_state=>array('maxLockNo'=>$maxLockNo, 'lockId'=>$lockId, 'lockState'=>$lockState));
                    break;

                default:
                    break;

            }


        }



    }//end of mfun_l1vm_huitp_msg_decode

}
?>