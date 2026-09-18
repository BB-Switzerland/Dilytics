#!/bin/zsh
# Sends the plugin and the build scripts to the server, then runs the build.
#
#   wordpress/deploy.sh               push only
#   wordpress/deploy.sh setup contact push, then run those build steps
#   wordpress/deploy.sh all           push, then rebuild the whole site
#
# Variables are always written ${HOST}: in zsh, "$HOST:c…" reads as a
# modifier on $HOST and silently sends the files to a local folder.
set -e

HOST=nivw.ftp.infomaniak.com
SITE=sites/dilytics.businessbooster.agency
WP="php \$HOME/bin/wp --path=\$HOME/${SITE}"

cd "$(dirname "$0")/.."

node wordpress/tools/export-content.mjs
node wordpress/tools/compile-css.mjs >/dev/null

# no file carrying a syntax error ever reaches the live site
for f in $(find wordpress/dilytics-modules wordpress/chantier -name '*.php'); do
  php -l "$f" >/dev/null || { php -l "$f"; exit 1; }
done

ssh "${HOST}" 'mkdir -p ~/chantier/dilytics/img'
rsync -az --delete wordpress/dilytics-modules/ "${HOST}:${SITE}/wp-content/plugins/dilytics-modules/"
rsync -az --delete --exclude img wordpress/chantier/ "${HOST}:chantier/dilytics/"
rsync -az --delete app/assets/img/ "${HOST}:chantier/dilytics/img/"

ssh "${HOST}" "${WP} plugin is-active dilytics-modules || ${WP} plugin activate dilytics-modules"

if [ $# -gt 0 ]; then
  ssh "${HOST}" "${WP} eval-file \$HOME/chantier/dilytics/build.php $* --user=1"
fi

# WP Rocket keeps minified copies of the plugin's CSS and JS apart from the page
# cache: both go, or visitors keep the previous sheets.
ssh "${HOST}" "${WP} eval 'if ( function_exists( \"rocket_clean_minify\" ) ) { rocket_clean_minify(); } if ( function_exists( \"rocket_clean_domain\" ) ) { rocket_clean_domain(); }'"
