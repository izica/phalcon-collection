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


}
