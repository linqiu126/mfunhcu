#!/bin/bash
count=`ps -fe |grep "cloud_callback_socket_listening.php" | grep -v "grep" | grep "master" | wc -l`
echo $count
if [ $count -ge 1 ]; then
ps -eaf |grep "cloud_callback_socket_listening.php" | grep -v "grep"| awk '{print $2}'|xargs kill -15

echo "swoole server killed";
date +%Y-%m-%d_%H:%M:%S
#echo $(date +%Y-%m-%d_%H:%M:%S) >/data/log/restart.log
fi