#!/bin/bash
count=`ps -fe |grep "cloud_callback_socket_listening.php" | grep -v "grep" | grep "master" | wc -l`
 
echo "Current running swoole server master process number is "$count
if [ $count -lt 1 ]; then
ps -eaf |grep "cloud_callback_socket_listening.php" | grep -v "grep"| awk '{print $2}'|xargs kill -9

echo "Swoole server will start in 2 seconds."
sleep 2
ulimit -c unlimited

cd /home/hitpony/workspace/mfunhcu/l1mainentry
php cloud_callback_socket_listening.php > /home/hitpony/swoole_server.log &
echo $(date +%Y-%m-%d_%H:%M:%S)": Swool server restart done."
#echo $(date +%Y-%m-%d_%H:%M:%S) >/data/log/restart.log
fi