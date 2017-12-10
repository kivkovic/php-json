# php-json

A user-friendly wrapper for PHP JSON objects

## Usage

Passing a JSON string to the class constructor will deserialize it into an object:

```php
$json = new Kreso\JSON('{"a":1, "b":2, "c":[1,2,3], "f":{"a":1}, "d":[], "e":{}}');
```

Values can be accessed either as array keys or object properties. Inaccessible keys/properties will not raise notices. However, `isset` and `empty` work just like on regular arrays.

```php
// {"a":1, "b":2, "c":[1,2,3], "f":{"a":1}, "d":[], "e":{}}

$json[1] = 6;
$json->k = 5;

// {"a":1, "b":2, "c":[1,2,3], "f":{"a":1}, "d":[], "e":{}, "1": 6, "k": 5}

$json['a']; // 1
$json->a;   // 1

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
