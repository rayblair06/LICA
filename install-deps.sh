#!/bin/bash

if [ -x "$(which apt-get)" ]
then
    sudo apt-get -y install \
        jpegoptim \
        optipng \
        pngquant \
        gifsicle \
        webp
fi

if [ -x "$(which dnf)" ]
then
    sudo dnf -y install \
        epel-release \
        jpegoptim \
        optipng \
        pngquant \
        gifsicle \
        libwebp-tools
fi

if [ -x "$(which npm)" ]
then
    sudo npm install -g svgo
fi