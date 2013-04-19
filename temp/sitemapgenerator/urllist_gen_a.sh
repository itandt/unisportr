# Settings
# 
# %base_url%
# - examples
# http://unisportr-zf.itt.loc
# 
# %domain%
# - examples
# unisportr-zf.itt.loc
# 
# %store_into_prelist%
# - examples
# /var/www/itt/unisportr-zf/temp/googlesitemapgen/temp/prelist_local.txt
# /var/www/itt/unisportr-zf/temp/googlesitemapgen/temp/prelist_google.txt
# 
# %store_into_urllist%
# - examples
# /var/www/itt/unisportr-zf/temp/googlesitemapgen/temp/urllist_local.txt
# /var/www/itt/unisportr-zf/temp/googlesitemapgen/temp/urllist_google.txt
wget -mk --spider -r -l2 %base_url% -o %store_into_prelist%
cat %store_into_prelist% | tr ' ' '\012' \
  | grep "^http" \
  | egrep -vi "[?]|[.]jpg$" \
  | egrep -vi "[?]|[.]txt$" \
  | egrep -vi "[?]|[.]ico$" \
  | egrep -vi "[?]|[.]css$" \
  | egrep -vi "[?]|[.]js$" \
  | egrep -vi "[?]|[.]png$" \
  | sort -u > %store_into_urllist%
rm %store_into_prelist%