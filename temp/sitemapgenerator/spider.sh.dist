# To use this script
# set URL and
# (un-)set LEVEL
wget --spider --force-html -r -l$LEVEL http://$URL 2>&1 \
  | grep '^--' | awk '{ print $1 "\t" $2 "\t" $3 }' \
  | grep -v '\.\(css\|js\|png\|gif\|jpg\|ico\|txt\)$' \
  | sort | uniq \
  > urllist_rl$LEVEL.txt
rm -rf ./$URL
