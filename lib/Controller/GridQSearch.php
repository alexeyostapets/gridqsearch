<?php
namespace gridqsearch;
class Controller_GridQSearch extends \View {
    public $grid;
    function init(){
        parent::init();

        $this->api->requires('atk','4.2');

        $symbols=$this->grid->model->_dsql()->field($this->grid->model->_dsql()->expr("DISTINCT LEFT($this->field,1) as symbol"))->order($this->field);

        if ( (isset($_GET[$this->name.'_filter'])) && ($_GET[$this->name.'_filter']!='') ){
            if ($_GET[$this->name.'_filter']=='clear'){
                $this->api->forget($this->name.'_filter');
            }else{
                $this->api->memorize($this->name.'_filter',trim($_GET[$this->name.'_filter']));
            }
        }

        $symbols_arr=array();
        $symbols_arr[]['name']="clear";
        foreach ($symbols as $symbol) {
            $symbols_arr[]['name']=strtoupper($symbol['symbol']);
        }

        $lister=$this->add('gridqsearch\Lister_QSearch');
        
        $lister->setSource($symbols_arr,'name');

        if ($this->api->recall($this->name.'_filter')!=''){
            $this->grid->model->addCondition($this->field,'like',$this->api->recall($this->name.'_filter').'%');
        }
    }

    function defaultTemplate() {
        
        $l=$this->api->locate('addons',__NAMESPACE__,'location');
        $addon_location = $this->api->locate('addons',__NAMESPACE__);
        $this->api->pathfinder->addLocation($addon_location,array(
            //'js'=>'templates/js',
            'css'=>'templates/css',
            'template'=>'templates',
            ))->setParent($l);
        
        return array("view/gridqsearch");
    }
}

