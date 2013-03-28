<?php
namespace gridqsearch;
class Lister_QSearch extends \CompleteLister {
    function init() {
        parent::init();
        
        $this->addClass('gridqsearch');
    }
    
    function formatRow(){
        parent::formatRow();
        
        $v=$this->add('View','search_'.$this->current_row['id'],'name')->set($this->current_row['name']);
        $v->addStyle('cursor','pointer');
        
        if ($this->api->recall($this->owner->name.'_filter')==strtoupper($this->current_row['name'])){
            $v->addClass('current');
        }        
        $v->js('click',array(
                $this->owner->grid->js()->reload(array(
                    $this->owner->name.'_filter'=>$v->js()->text(),
                )),
        ));
        $this->current_row_html['name']=$v->getHTML();
    }
    
 }