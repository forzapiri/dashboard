#!/bin/bash
echo MySQL user
read mysqlUser

echo MySQL pass
read mysqlPass

echo Database
read mysqlDb

files=$(find 'sql/' -type f -iname '*.sql')

for file in $files; do
	mysql -u $mysqlUser -p$mysqlPass $mysqlDb < $file
done
