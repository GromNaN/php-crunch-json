PHP implementation of the node module [`graphql-crunch`](https://github.com/banterfm/graphql-crunch#readme).

> Optimizes JSON responses by minimizing duplication and improving compressibility.

Installation
------------

```
composer require gromnan/json-crunch
```

How does it work?
-----------------

> We flatten the object hierarchy into an array using a post-order traversal of the object graph. As we traverse we efficiently check if we've come across a value before, including arrays and objects, and replace it with a reference to it's earlier occurence if we've seen it. Values are only ever present in the array once.

Usage
-----

```php
use function GromNaN\JsonCrunch\crunch;

$data = json_decode('{"a":["a","b","a"],"b":["a","b","a"]}');

$crunched = crunch($data);

echo json_encode($data, JSON_PRETTY_PRINT);
```

Result:
```json
[
    "a",
    "b",
    [0,1,0],
    {"a":2,"b":2}
]
```

Command-line
------------

```
bin/crunch-json <file>
```
