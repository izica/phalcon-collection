# Todo List
- [x] work with MVC collection
- [ ] all
- [ ] avg
- [ ] avgBy
- [x] groupBy
- [ ] keyBy
- [ ] last
- [ ] map
- [ ] unique
- [x] toArray
- [x] toJson
- [ ] where
- [ ] zip
- [ ] etc....

## Register service:
```php
    $di = new DI();
    $di->set('collection', function() {
        return new IzicaCollection();
    });
```
## Usage:
```php
    use Phalcon\Mvc\Controller;

    class IndexController extends Controller
    {
        public function indexAction()
        {
            $arCars = Cars::find();
            $jsonResponse = $this->collection->create($arCars)->groupBy('year')->toJson();
        }
    }
```
