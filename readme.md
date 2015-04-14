# Number Convert plugin for Craft

Provides a collection of Twig filters to convert numbers.

## Installation

To install the plugin, copy the numberconvert/ folder into craft/plugins/. Then go to Settings → Plugins and click the "Install" button next to "Number Convert".


## Twig filters

### numeralSystem( numeralSystem, zero )

Converts a natural number (arabic numeral system) to a representation of that number in another numeral system. You can also apply the filter to any rational number and rounds to the closest natural number first.

```html
{{ 42|number_convert('roman') }}

{# outputs XLII #}

```

#### Arguments

- **`numeralSystem`** (required) – The numeral system the number gets converted to. You can convert to the roman numberal system (`'roman'`, `'upperRoman'` or `'lowerRoman'`) or to the alphabetical equivalent to the input number (`'alpha'`, `'upperAlpha'` or `'lowerAlpha'`).

- **`zero`** – Maps all negative numbers and zero. Setting this argument to `-1` gives you a decimal number to alphabetical character mapping like so: `-1` → `-B`, `0` → `-A`, `1` → `A`. Any other argument value other than `-1` or `1` does only map `0` to this value (i.e. `0` → `myZero`) and leaves negative number untouched. (Default value is `-1`)

### fractionToFloat( precision )

Converts a fraction to a decimal number.

```html
{{ '2/3'|number_convert }}

{# outputs 0.6667 #}

```

#### Arguments

- **`precision`** – The precision (number of digits after the decimal point) the returned value gets rounded to. (Default value is `4`)

### floatToFraction( tolerance )

Converts a decimal number to a fraction.

```html
{{ 0.7143|number_convert }}

{# outputs 5/7 #}

```

#### Arguments

- **`tolerance`** – The allowed tolerance for the fraction calculation. So, for example, `0.7143` gets converted to `5/7` instead of `7138/9993`. (Default value is `0.001`)
