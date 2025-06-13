#!/usr/bin/bash

SPIP=spip-$1.zip
TEMP_DIR=./downloads

mkdir -p $TEMP_DIR
if [ ! -f "$TEMP_DIR/$SPIP" ]; then
  wget https://files.spip.net/spip/stable/$SPIP
fi
unzip -o $TEMP_DIR/$SPIP -d $TEMP_DIR
mv $TEMP_DIR/spip/* .
rm -rf $TEMP_DIR/spip
