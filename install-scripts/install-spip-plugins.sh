#!/usr/bin/bash

PLUGINS_DIR=./plugins/auto
TEMP_DIR=./downloads

mkdir -p $PLUGINS_DIR
mkdir -p $TEMP_DIR
for i in $@;
do
  if [ ! -f "$TEMP_DIR/$i.zip" ]; then
    wget http://files.spip.org/spip-zone/$i.zip -P $TEMP_DIR
  fi
  if [ ! -f "$TEMP_DIR/$i.zip" ]; then
    echo "LE PLUGIN '$i' EST INTROUVABLE !";
  else
    unzip -o $TEMP_DIR/$i.zip -d $PLUGINS_DIR
  fi
done
