Plugins
=======

Plugins can be loaded using event listeners. Simple listen to `PhuninCake.Node.start` and call the addPlugin on the pass *PhuninNode* instance.

```php
$event->data['node']->addPlugin(new \PhuninNode\Plugins\Plugins());
```