<?
class IzicaCollection
{
    private $isActiveRecord = false;
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
    public function create($arCollection){
        return new IzicaCollection($arCollection);
    }

    //transform active record to array
    public function toArray(){
        if($this->isActiveRecord){
            foreach ($this->arCollection as &$arItem) {
                $arItem = $arItem->toArray();
            }
        }
        $this->isActiveRecord = false;
        return $this;
    }

    public function toJson(){
        $this->toArray();
        return json_encode($this->arCollection);
    }

    public function getCollection(){
        return $this->arCollection;
    }

    public function groupBy($prop){
        $arCollection = [];
        if($this->isActiveRecord){
            foreach ($this->arCollection as $obItem) {
                $arCollection[$obItem->$prop][] = $obItem;
            }
        }else{
            foreach ($this->arCollection as $arItem) {
                $arCollection[$arItem[$prop]][] = $arItem;
            }
        }
        return $arCollection;
    }
}
