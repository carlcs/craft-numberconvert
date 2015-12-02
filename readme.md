# Number Convert plugin for Craft

Provides a collection of Twig filters to convert numbers.

## Installation

To install the plugin, copy the numberconvert/ folder into craft/plugins/. Then go to Settings → Plugins and click the "Install" button next to "Number Convert".


## Twig filters

### numeralSystem( numeralSystem, zero )

Converts a number (arabic numeral system) to a representation of that number in another numeral system. If applied to a rational number (float), the filter rounds it to the closest integer first.


```html
{{ 42|numeralSystem('roman') }}

{# outputs XLII #}

```

#### Parameters

- **`numeralSystem`** (required) – The numeral system the number gets converted to. You can convert to the roman numberal system (`'roman'`, `'upperRoman'` or `'lowerRoman'`) or to the alphabetical equivalent to the input number (`'alpha'`, `'upperAlpha'` or `'lowerAlpha'`).

- **`zero`** – Maps all negative numbers and zero. Setting this argument to `-1` gives you a decimal number to alphabetical character mapping like so: `-1` → `-B`, `0` → `-A`, `1` → `A`. Any other argument value other than `-1` or `1` does only map `0` to this value (i.e. `0` → `myZero`) and leaves negative number untouched. (Default value is `-1`)

### unitPrefix( system, decimals, trailingZeros, decPoint, thousandsSep, unitSep)

Formats a number with unit prefixes.

```html
{{ 72064|unitPrefix }}

{# outputs 72.1 k #}

```

#### Parameters

- **`system`** – Either a string (e.g. "decimal") to use a predefined configuration or an array of custom settings. (Default value is `decimal`)

- **`decimals`** – The number of decimal points. (Default value is `1`)

- **`trailingZeros`** – Whether to show trailing zeros. (Default value is `false`)

- **`decPoint`** – The separator for the decimal point. (Default value is `.`)

- **`thousandsSep`** – The thousands separator. (Default value is `''`)

- **`unitSep`** – The separator between number and unit. (Default value is `' '`)


### fractionToFloat( precision )

Converts a fraction to a decimal number.

```html
{{ '2/3'|fractionToFloat }}

{# outputs 0.6667 #}

```

#### Parameters

- **`precision`** – The precision (number of digits after the decimal point) the returned value gets rounded to. (Default value is `4`)

### floatToFraction( tolerance )

Converts a decimal number to a fraction.

```html
{{ 0.7143|floatToFraction }}

{# outputs 5/7 #}

```

#### Parameters

- **`tolerance`** – The allowed tolerance for the fraction calculation. So, for example, `0.7143` gets converted to `5/7` instead of `7138/9993`. (Default value is `0.001`)
