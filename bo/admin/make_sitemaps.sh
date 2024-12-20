#!/bin/sh

# Script for generating a full set of sitemaps for jernbane.net
#
# NOTE: This file must be updated and more sitemap files added here and in the 
#       sitemap indexing file in /sitemap when database grows

export SITE=https://jernbane.net
#export SITE=http://localhost/~rune/jernbane.net/web
export OUTDIR=/var/www/jernbane.net/public_html
#export OUTDIR=/home/jernbane/public_html
#export OUTDIR=/home/rune/work/jernbane.net/web


wget -q -U Mozilla -O $OUTDIR/sitemap/sitemap_img1.xml $SITE/bo/admin/make_sitemap.php\?type=img\&n=1
wget -q -U Mozilla -O $OUTDIR/sitemap/sitemap_img2.xml $SITE/bo/admin/make_sitemap.php\?type=img\&n=2
wget -q -U Mozilla -O $OUTDIR/sitemap/sitemap_img3.xml $SITE/bo/admin/make_sitemap.php\?type=img\&n=3
wget -q -U Mozilla -O $OUTDIR/sitemap/sitemap_img4.xml $SITE/bo/admin/make_sitemap.php\?type=img\&n=4
wget -q -U Mozilla -O $OUTDIR/sitemap/sitemap_types.xml $SITE/bo/admin/make_sitemap.php\?type=type\&n=1

