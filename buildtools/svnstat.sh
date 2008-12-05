#!/bin/bash

svn log -v -r {2008-07-20}:{2010-01-01} --xml svn://svn.clientview.ca/norex2 > svn.log

java -jar statsvn.jar -verbose -output-dir svnstats -title "Development CMS" -exclude "buildtools/;core/PEAR/**;core/jpgraph/**" -tags ".*" ./svn.log ..
