# php-json

A user-friendly PHP JSON class wrapping the built-in `json_decode` function. Provides automatic JSON validation, array-like and object-like manipulation of deserialized data, and clean key/property access without raising notices.

## Usage

When a string is passed to the class constructor, it will be deserialized into an object:

```php
$json = new PHP\JSON('{"a":1, "b":2, "c":[1,2,3], "f":{"a":1}, "d":[], "e":{}}');
```

If an invalid JSON string is provided, an exception will be thrown with a code corresponding to the [builtin JSON error codes](https://secure.php.net/manual/en/function.json-last-error.php):

```php
$json = new PHP\JSON('{111'); // throws PHP\JSONException with code JSON_ERROR_SYNTAX
```

Values can be accessed either as array keys or object properties. Inaccessible keys/properties will not raise notices and will return null. However, `isset` and `empty` work just like on regular arrays.

```php
// {"a":1, "b":2, "c":[1,2,3], "f":{"a":1}, "d":[], "e":{}}

$json[1] = 6;
$json->k = 5;

// {"a":1, "b":2, "c":[1,2,3], "f":{"a":1}, "d":[], "e":{}, "1": 6, "k": 5}

$json['a']; // 1
$json->a;   // 1

$json->notset; // null

isset($json->notset); // false

```

The object can be counted and iterated as a regular array:

```php
count($json); // 8

foreach ($json as $key => $value) {
    echo "$key: $value\n";
}

```

The object will be automatically serialized when being cast to a string:

```php
echo $json;
// {"a": 1, "b": 2, "c": [1, 2, 3], "f": {"a": 1}, "d": [], "e": {}, "1": 6, "k": 5}
```

## Installation

Requires [composer](https://github.com/composer/composer)

Example composer.json:

```
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/kivkovic/php-json"
        }
    ],
    "require": {
        "kivkovic/php-json": "dev-master"
    }
}
```
