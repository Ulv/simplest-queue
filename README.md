# simplest-queue
Simplest asyncronous queue possible

Example usage:

```php
// establish redis connection
$redis = new Redis();
$redis->connect('127.0.0.1');

// set queue name
$queueName = 'abcdef';

// instantiate redis connector
$connector = new \Ulv\SimplestQueue\RedisConnector($redis, $queueName);

// instantiate queue
$queue = new \Ulv\SimplestQueue\Queue($connector);

// instantiate simple DTO
$dto = new \Ulv\SimplestQueue\SimplestDto(['a' => 1, 'b' => 2]);

// some operations on it
$dto['c'] = 3;
unset($dto['b']);

// push DTO to queue
var_dump($queue->push($dto));

// pop DTO from queue
var_dump($queue->pop());
```
