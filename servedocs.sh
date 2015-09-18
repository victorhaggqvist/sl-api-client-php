#!/usr/bin/sh
rm -rf docs
./vendor/bin/phpdoc
pushd docs
python2 -m SimpleHTTPServer 8080
popd
