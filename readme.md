# Todo List
- [x] work with MVC collection
- [ ] all
- [x] [average](#average)
- [x] [groupBy](#groupby)
- [x] [keyBy](#keyby)
- [x] [has](#has)
- [ ] last
- [ ] map
- [ ] unique
- [x] [toArray](#toarray)
- [x] [toJson](#tojson)
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

# Functions
#### average
```php
    $arr = [
        ['value' => 2, 'value2' => 4, 'value3' => 'foo'],
        ['value' => 6, 'value2' => 1, 'value3' => 'bar']
    ];
    $arResult = $this->collection->create($arr)->average();
    //Array
    //(
    //    [value] => 4
    //    [value2] => 2.5
    //)
    $arResult = $this->collection->create($arr)->average('value');
    //4
    $collection = $this->collection->create($arr)->average(['value']);
    //Array
    //(
    //    [value] => 4
    //)
    $collection = $this->collection->create([1, 5, 6 ,7])->average();
    //4.75
```
#### groupBy
```php
    $arResult = $this->collection->create($arr)->groupBy('value');
    $arResult = $this->collection->create($arr)->groupBy(function($arItem){
        return (int)$arItem['value'] * 2;
    });
```
#### keyBy
```php
    $arResult = $this->collection->create($arr)->keyBy('id');
    $arResult = $this->collection->create($arr)->keyBy(function($arItem){
        return strtoupper($arItem['code']);
    });
```
#### has
```php
    //has(key, value);
    $arr = ['value' => 'bar', 'value2' => 'foo'];
    $result = $this->collection->create($arr)->has('value'); // true
    $result = $this->collection->create($arr)->has('value', 'bar'); // true
    $result = $this->collection->create($arr)->has('value', 'xyz'); // false

```
#### toArray
transforms activeRecord to Array;
```php
    $arResult = $this->collection->create(Cars::find())->toArray()->groupBy('value'); // return result in Array Object after groupBy
    $arResult = $this->collection->create(Cars::find())->toArray(true) // return result in Array string instant, ~Cars::find()->toArray();
```
#### toJson
```php
    $arResult = $this->collection->create($arr)->toJson()->groupBy('value'); // return result in JSON string after groupBy
    $arResult = $this->collection->create($arr)->toJson(true) // return result in JSON string instant
```
