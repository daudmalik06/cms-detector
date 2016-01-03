#!/bin/bash
# Mass CMS Detector
# Coded by : Red V!per <Behnam Vanda>
# E-Mail: beni.vanda@gmail.com
# Telegram id : @witchking
# Red Hat Hackers Channel : https://telegram.me/redhats
# 

FILE=$1

if [ ! -d "CMS" ]; then
mkdir CMS
fi

for SITE in `cat $FILE`
do
CMS=`php index.php "http://$SITE"| cut -d '>' -f 2 | cut -d '<' -f 1`
if [ -z "$CMS" ];
then
echo "http://$SITE" >>CMS/unknown.lst
else
echo "http://$SITE" >>CMS/"$CMS.lst" </dev/null
echo -e "	> http://$SITE/  \x1B[31m [$CMS] \x1B[0m"
fi
done 
