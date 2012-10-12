cd /var/www
rm -rf panda
mkdir panda
cd panda
cvs -d :pserver:pshen@localhost:/Panda login
cvs -d :pserver:pshen@localhost:/Panda checkout default
rm -rf default/CVS
cvs -d :pserver:pshen@localhost:/Panda checkout _down_
rm -rf _down_/CVS
cvs -d :pserver:pshen@localhost:/Panda checkout about
rm -rf about/CVS
cvs -d :pserver:pshen@localhost:/Panda checkout admin
rm -rf admin/CVS
cvs -d :pserver:pshen@localhost:/Panda checkout common
rm -rf common/CVS
cvs -d :pserver:pshen@localhost:/Panda checkout css
rm -rf css/CVS
cvs -d :pserver:pshen@localhost:/Panda checkout help
rm -rf help/CVS
cvs -d :pserver:pshen@localhost:/Panda checkout home
rm -rf home/CVS
cvs -d :pserver:pshen@localhost:/Panda checkout image
rm -rf image/CVS
cvs -d :pserver:pshen@localhost:/Panda checkout install
rm -rf install/CVS
cvs -d :pserver:pshen@localhost:/Panda checkout js
rm -rf checkout/CVS
cvs -d :pserver:pshen@localhost:/Panda checkout message
rm -rf message/CVS
cvs -d :pserver:pshen@localhost:/Panda checkout project
rm -rf project/CVS
cvs -d :pserver:pshen@localhost:/Panda checkout search
rm -rf search/CVS
cvs -d :pserver:pshen@localhost:/Panda checkout utils
rm -rf utils/CVS
chmod -R 644 */*.php
chmod -R 644 */*.png
chmod -R 644 */*/*.png
chmod -R 644 */*.gif
chmod -R 644 */*/*.gif
chmod -R 644 */*.js
chmod -R 644 */*/*.js
chmod -R 644 */*.css
chmod -R 644 */*/*.css
chmod -R 644 */*.swf
chmod -R 644 */*/*.ttf
