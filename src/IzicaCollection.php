<?
class IzicaCollection
{
    private $isActiveRecord = false;
    private $isNeedJson = false;
    private $arCollection;

    function __construct($arItems = false)
    {
        if($arItems != false){
            if(is_array($arItems)){
                $this->arCollection = $arItems;
            }else{
                $this->isActiveRecord = true;
                foreach ($arItems as $obItem) {
                    $this->arCollection[] = $obItem;
                }
            }
        }
        return $this;
    }

    //create new collection
    public function create($collection){
        return new IzicaCollection($collection);
    }

    private function returnResponse($arCollection){
        if($this->isNeedJson){
            return json_encode($arCollection);
        }else{
            return $arCollection;
        }
    }

    //transform active record to array
    public function toArray($isCollection = false){
        if($this->isActiveRecord){
            foreach ($this->arCollection as &$arItem) {
                $arItem = $arItem->toArray();
            }
        }
        if($isCollection){
            return $this->returnResponse($this->arCollection);
        }
        $this->isActiveRecord = false;
        return $this;
    }

    public function toJson($isCollection = false){
        $this->isNeedJson = true;
        $this->toArray();
        if($isCollection){
            return $this->returnResponse($this->arCollection);
        }
        return $this;
    }

    public function groupBy($obProperty){
        $arCollection = [];
        if(is_callable($obProperty)){
            foreach ($this->arCollection as $arItem) {
                $arCollection[$obProperty($arItem)][] = $arItem;
            }
        }else{
            //check if active record
            if($this->isActiveRecord){
                foreach ($this->arCollection as $arItem) {
                    $arCollection[$arItem->$obProperty][] = $arItem;
                }
            }else{
                foreach ($this->arCollection as $arItem) {
                    $arCollection[$arItem[$obProperty]][] = $arItem;
                }
            }
        }
        return $this->returnResponse($arCollection);
    }

    public function keyBy($obProperty){
        $arCollection = [];
        if(is_callable($obProperty)){
            foreach ($this->arCollection as $arItem) {
                $arCollection[$obProperty($arItem)] = $arItem;
            }
        }else{
            //check if active record
            if($this->isActiveRecord){
                foreach ($this->arCollection as $arItem) {
                    $arCollection[$arItem->$obProperty] = $arItem;
                }
            }else{
                foreach ($this->arCollection as $arItem) {
                    $arCollection[$arItem[$obProperty]] = $arItem;
                }
            }
        }
        return $this->returnResponse($arCollection);
    }

    public function average($arProperties = false){
        $this->toArray();
        if($arProperties == false){
            //find numeric properties
            if(is_array($this->arCollection[0])){
                $arProperties = [];
                foreach ($this->arCollection[0] as $key => $value) {
                    if(is_numeric($value)){
                        $arProperties[] = $key;
                    }
                }
                //numeric properties not found
                if(count($arProperties) == 0)
                    return false;
            }else{
                //array not numeric;
                if(is_numeric($this->arCollection[0]) == false)
                    return false;

                $count = 0;
                $value = 0;
                foreach ($this->arCollection as $nItem) {
                    $count++;
                    $value += $nItem;
                }
                return $value/$count;
            }
        }

        if(is_array($arProperties)){
            $result = [];
            foreach ($arProperties as $arProperty) {
                $result[$arProperty] = [
                    'count' => 0,
                    'value' => 0
                ];
            }
            foreach ($this->arCollection as $arItem) {
                foreach ($arProperties as $arProperty) {
                    $result[$arProperty]['count']++;
                    $result[$arProperty]['value'] += $arItem[$arProperty];
                }
            }
            foreach ($result as &$resItem) {
                $resItem = $resItem['value']/$resItem['count'];
            }
            return $result;
        }else{
            if(!isset($this->arCollection[0][$arProperties]) || !is_numeric($this->arCollection[0][$arProperties]))
                return false;

            $count = 0;
            $value = 0;
            foreach ($this->arCollection as $arItem) {
                $count++;
                $value += $arItem[$arProperties];
            }
            return $value/$count;
        }

        return $result;
    }


}
