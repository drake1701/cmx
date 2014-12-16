#!/bin/bash
SCRIPTDIR=$(dirname $0)
php $SCRIPTDIR/setup.php
php $SCRIPTDIR/testrx.php $1