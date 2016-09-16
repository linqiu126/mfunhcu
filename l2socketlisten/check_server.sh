#!/bin/bash -x
PATH="/bin:/usr/bin:/usr/sbin"
count=`ps -fe |grep "cloud_callback_socket_listening.php" | grep -v "grep" | grep "master" | wc -l`
 
echo  $(date +%Y-%m-%d_%H:%M:%S)": Live swoole server master process number is "$count >> /home/qiulin/check_server.log
if [ $count -lt 1 ]
    then
    ps -eaf |grep "cloud_callback_socket_listening.php" | grep -v "grep"| awk '{print $2}'|xargs kill -9

    echo $(date +%Y-%m-%d_%H:%M:%S)": Swoole server will start in 2 seconds." >> /home/qiulin/check_server.log
    sleep 2
    ulimit -c unlimited

    ipaddr=`LC_ALL=C ifconfig | grep 'inet '| grep -v '10.168' |grep -v '127'|cut -d: -f2 | awk '{ print $2}'`
    ipxiaohui='121.40.118.33'
    ipaiqi='121.40.185.177'
    #echo $(date +%Y-%m-%d_%H:%M:%S)": ipaddr is "$ipaddr >> /home/qiulin/check_server.log
    #echo $(date +%Y-%m-%d_%H:%M:%S)": PATH is "$PATH >> /home/qiulin/check_server.log

    if [ $ipaddr = $ipxiaohui ]
    then
        echo "xiaohui yun script to be done";
    elif [ $ipaddr = $ipaiqi ]
    then
        echo $(date +%Y-%m-%d_%H:%M:%S)": Aiqiyun Swoole server to be restarted soon." >> /home/qiulin/check_server.log
        cd /data/www/xhzn/mfunhcu/l1mainentry
        php cloud_callback_socket_listening.php >> /home/qiulin/swooleserver.log 2>&1 &
        echo $(date +%Y-%m-%d_%H:%M:%S)": Aiqiyun Swoole server restart done."
    else
        echo $(date +%Y-%m-%d_%H:%M:%S)": VMWARE Swoole_server to be restarted soon." >> /home/hitpony/check_server.log
        cd /var/www/html/mfunhcu/l1mainentry
        php cloud_callback_socket_listening.php >> /home/hitpony/swooleserver.log 2>&1 &
        echo $(date +%Y-%m-%d_%H:%M:%S)": VMWARE Swoole_server restart done." >> /home/hitpony/check_server.log
    fi
fi
