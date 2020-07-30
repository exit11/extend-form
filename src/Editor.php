<?php

namespace Exit11\ExtendForm;

use Encore\Admin\Form\Field;

class Editor extends Field
{
    public static $js = [
        '/vendor/exit11/extend-form/eltiptap/editor.js',
    ];
    
    protected static $css = [];
    
    /**
     * @var string
     */
    protected $view = 'extend-form::editor';
    
    /**
     * {@inheritdoc}
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function render()
    {
        $this->script = <<<EOT

    
EOT;
        return parent::render();
    }
}
