#!/usr/bin/env bash

if [ "$(echo x | sed -E 's/(.)/\U\1/')" != 'X' ]; then
  # This script is incompatible with sed on Mac OS or BSD, as they do not support \U in extended regular expressions.
  echo "Incompatible version of sed found: $(which sed)" >&2
  echo "GNU sed with full extended regex support is required" >&2
  exit 1
fi

for FILE in view/frontend/web/svg/heroicons2/24/solid/*.svg; do
  method_name="$(basename -s .svg $FILE | sed -E 's/-(.)/\U\1/g')Html"
  echo " * @method string $method_name(string \$classnames = '', ?int \$width = 24, ?int \$height = 24, array \$attributes = [])"
done
