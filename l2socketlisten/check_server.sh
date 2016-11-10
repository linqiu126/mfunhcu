#!/bin/bash -x
PATH="/bin:/usr/bin:/usr/sbin:/sbin"
count=`ps -fe |grep "cloud_callback_socket_listening.php" | grep -v "grep" | grep "master" | wc -l`

ipaddr=`LC_ALL=C ifconfig | grep 'inet '| grep -v '10.' |grep -v '127'|cut -d: -f2 | awk '{ print $2}'`
ipxiaohui='121.40.118.33'
ipaiqi='121.40.185.177'

if [ $ipaddr = $ipxiaohui ]
then
    swoole_server_logfile='/home/swoole_server.log'
    mfunhcu_l1mainentry_directory='/var/www/html/mfunhcu/l1mainentry'
elif [ $ipaddr = $ipaiqi ]
then
    swoole_server_logfile='/home/qiulin/swoole_server.log'
    mfunhcu_l1mainentry_directory='/data/www/xhzn/mfunhcu/l1mainentry'
else
    swoole_server_logfile='/home/hitpony/swoole_server.log'
    mfunhcu_l1mainentry_directory='/var/www/html/mfunhcu/l1mainentry'
fi

#echo $(date +%Y-%m-%d_%H:%M:%S)" ipaddr is "$ipaddr >> $swoole_server_logfile
#echo $(date +%Y-%m-%d_%H:%M:%S)" PATH is "$PATH >> $swoole_server_logfile

echo  $(date +%Y-%m-%d_%H:%M:%S)" Swoole server master process number is "$count >> $swoole_server_logfile
if [ $count -lt 1 ]
    then
    ps -eaf |grep "cloud_callback_socket_listening.php" | grep -v "grep"| awk '{print $2}'|xargs kill -9

    echo $(date +%Y-%m-%d_%H:%M:%S)" Swoole server will start in 2 seconds." >> $swoole_server_logfile
    sleep 2
    ulimit -c unlimited

    echo $(date +%Y-%m-%d_%H:%M:%S)" Swoole server to be restarted soon." >> $swoole_server_logfile
    cd $mfunhcu_l1mainentry_directory
    php cloud_callback_socket_listening.php >> $swoole_server_logfile 2>&1 &
    echo $(date +%Y-%m-%d_%H:%M:%S)" Swoole server restart done." >> $swoole_server_logfile
fi
