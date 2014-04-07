#!/bin/bash

# Usage
usage(){
    echo "Usage: $0 <target_dir>"
    echo -e "Installs slider-captcha to target_dir"
    echo "target_dir MUST be the WordPress root directory"
    exit 1
}

filenotfound() {
	echo "The installation directory doesn't look like a WordPress installation."
	echo "Are you sure that $1 is a valid WordPress directory?"
	exit 1
}

if [[ $# -lt 1 ]]
then
  usage
fi 


# Get arguments
target_dir=$1
theme_dir=$target_dir/wp-content/plugins/slider-captcha

if [ ! -f $target_dir/wp-content/themes/index.php ];
then
	filenotfound
fi   


echo "Installing slider-captcha on $target_dir"

echo "Copy customizations.. "
rsync -aq --cache --exclude '.git' . $theme_dir
# rsync -av --delete --exclude '.svn' bla/ $target_dir.new/bla
# chmod og-rwx $IDP_TESTING_DIR/cert/idp-testing.privatekey.pem
echo "Slider Captcha installed on $theme_dir"
echo "done!"
