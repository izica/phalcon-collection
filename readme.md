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

# Functions
#### groupBy
```php
    $arResult = $this->collection->create($arr)->groupBy('value');
    $arResult = $this->collection->create($arr)->groupBy(function($arItem){
        return (int)$arItem['value'] * 2;
    });
```
#### toArray, transforms activeRecord to Array;
```php
    $arResult = $this->collection->create(Cars::find())->toArray()->groupBy('value'); // return result in Array Object after groupBy
    $arResult = $this->collection->create(Cars::find())->toArray(true) // return result in Array string instant, ~Cars::find()->toArray();
```
#### toJson
```php
    $arResult = $this->collection->create($arr)->toJson()->groupBy('value'); // return result in JSON string after groupBy
    $arResult = $this->collection->create($arr)->toJson(true) // return result in JSON string instant
```

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
