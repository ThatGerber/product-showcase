#!/usr/bin/env bash
# Move to Project Root
DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
cd $DIR;
cd ../;
# Move Files
## Images
cp node_modules/slick-carousel/slick/ajax-loader.gif assets/images/ajax-loader.gif
## CSS
cp node_modules/slick-carousel/slick/slick.css assets/css/slick.css
cp node_modules/slick-carousel/slick/slick-theme.css assets/css/slick-theme.css
### Fix image location
sed -i .bak 's/.\/ajax-loader.gif/..\/images\/ajax-loader.gif/' assets/css/slick-theme.css
rm -f assets/css/slick-theme.css.bak
## JS
cp node_modules/slick-carousel/slick/slick.js assets/js/slick.js
cp node_modules/slick-carousel/slick/slick.min.js assets/js/slick.min.js
## Fonts
cp -R node_modules/slick-carousel/slick/fonts assets/css/fonts
cd bin/