# cURL layer


```php
$base_uri = 'http://saeno.app';
$client = (new RESTful($base_uri))->getClient();
```
The code above returns the Guzzle client, this is used under ``request(...)->module(...)``
