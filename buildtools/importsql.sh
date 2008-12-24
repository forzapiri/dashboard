#!/bin/bash
dbConf="../include/db-config.php"
#if [ -r $dbConf ]
#then
#	dbConf=`cat $dbConf`
#	i=0
#	declare -a dt
#	echo "$dbConf" | \
#	while read line; do
#		echo $line
#		if [[ "$line" =~ "\$................"  ]]
#		then
#			dt[$i]="$line"
#			echo "$line"
#			i=`expr $i + 1`
#		fi
#	done

#else
#	echo Error reading db-config.php
#	exit
#fi

echo MySQL user
read mysqlUser

echo MySQL password
stty_orig=`stty -g`
stty -echo
read mysqlPass
stty $stty_orig

echo Database
read mysqlDb

declare -a files

files=$(find 'sql/' -type f -iname '*.sql')
for file in $files; do
	mysql -u $mysqlUser -p$mysqlPass $mysqlDb < $file
	echo $file imported to $mysqlDb
done

i=0
dirs=$(find '../modules/' -type d)
for dir in $dirs; do
	tmp=$(find $dir -type f -iname 'schema.sql')
	if [ "$tmp" != "" ]
	then
		files[$i]=$tmp
		i=`expr $i + 1`
	fi
done
	
for file in $files; do
	mysql -u $mysqlUser -p$mysqlPass $mysqlDb < $file
	echo $file imported to $mysqlDb
done
