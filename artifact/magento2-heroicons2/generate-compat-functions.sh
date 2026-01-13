#!/usr/bin/env bash

if [ "$(echo x | sed -E 's/(.)/\U\1/')" != 'X' ]; then
  # This script is incompatible with sed on Mac OS or BSD as they do not support \U in extended regular expressions.
  echo "Incompatible version of sed found: $(which sed)" >&2
  echo "GNU sed with full extended regex support is required" >&2
  exit 1
fi

while IFS="," read -r from to; do
  from_name="$(echo $from | sed -E 's/-(.)/\U\1/g')Html"
  to_name="$(echo $to | sed -E 's/-(.)/\U\1/g')Html"
  echo "
    #[Deprecated(
        reason: 'Replaced by $to_name()',
        replacement: '%class%->$to_name(%parametersList%)',
    )]
    public function $from_name(string \$classnames = '', ?int \$width = 24, ?int \$height = 24, array \$attributes = []): string
    {
        return \$this->$to_name(\$classnames, \$width, \$height, \$attributes);
    }"
done < updated-icon-names.csv
