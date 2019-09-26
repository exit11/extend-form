<?php

namespace Exit11\ExtendForm;

use Encore\Admin\Form\Field;

class Address extends Field
{
  
    public static $js = [
        'http://dmaps.daum.net/map_js_init/postcode.v2.js',
    ];
    
    /**
     * @var string
     */
    protected $view = 'extend-form::address';
    
    /**
     * {@inheritdoc}
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function render()
    {
        
        $this->script = <<<"EOT"
    $('.btn-daum-address').on('click', function() {
        var t = $(this);
        new daum.Postcode({
            oncomplete: function(data) {
                t.closest('.input-group').find('input').val(data.address);                
            }
        }).open();
    });
EOT;
        
        return parent::render();
    }
    
}