<?php

namespace Exit11\ExtendForm;

use Encore\Admin\Form\Field;

class Editor extends Field
{
  
    public static $js = [
        //'/vendor/exit11/extend-form/editorjs/editor.js',
        'https://cdn.jsdelivr.net/npm/@editorjs/header@latest',
        'https://cdn.jsdelivr.net/npm/@editorjs/simple-image@latest',
        'https://cdn.jsdelivr.net/npm/@editorjs/delimiter@latest',
        'https://cdn.jsdelivr.net/npm/@editorjs/list@latest',
        'https://cdn.jsdelivr.net/npm/@editorjs/checklist@latest',
        'https://cdn.jsdelivr.net/npm/@editorjs/quote@latest',
        'https://cdn.jsdelivr.net/npm/@editorjs/code@latest',
        'https://cdn.jsdelivr.net/npm/@editorjs/embed@latest',
        'https://cdn.jsdelivr.net/npm/@editorjs/table@latest',
        'https://cdn.jsdelivr.net/npm/@editorjs/link@latest',
        'https://cdn.jsdelivr.net/npm/@editorjs/warning@latest',
        'https://cdn.jsdelivr.net/npm/@editorjs/marker@latest',
        'https://cdn.jsdelivr.net/npm/@editorjs/inline-code@latest',
        '/vendor/exit11/extend-form/editorjs/editor.js',
    ];
    
    protected static $css = [
        '/vendor/exit11/extend-form/editorjs/editor.css',
    ];
    
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
    
    var editorjsValue = document.getElementById("inputEditorjs").value;
    var editorjsData;
    if(editorjsValue == "" || editorjsValue == null || editorjsValue == undefined || ( editorjsValue != null && typeof editorjsValue == "object" && !Object.keys(editorjsValue).length)){
        editorjsData = {};
    } else {
        editorjsData = JSON.parse(editorjsValue);
    }

    /**
     * To initialize the Editor, create a new instance with configuration object
     * @see docs/installation.md for mode details
     */
    var editor = new EditorJS({
      /**
       * Wrapper of Editor
       */
      holder: 'editorjs',

      /**
       * Tools list
       */
      tools: {
        /**
         * Each Tool is a Plugin. Pass them via 'class' option with necessary settings {@link docs/tools.md}
         */
        header: {
          class: Header,
          inlineToolbar: ['link'],
          config: {
            placeholder: 'Header'
          },
          shortcut: 'CMD+SHIFT+H'
        },

        /**
         * Or pass class directly without any configuration
         */
        image: {
          class: SimpleImage,
          inlineToolbar: ['link'],
        },

        list: {
          class: List,
          inlineToolbar: true,
          shortcut: 'CMD+SHIFT+L'
        },

        checklist: {
          class: Checklist,
          inlineToolbar: true,
        },

        quote: {
          class: Quote,
          inlineToolbar: true,
          config: {
            quotePlaceholder: 'Enter a quote',
            captionPlaceholder: 'Quote\'s author',
          },
          shortcut: 'CMD+SHIFT+O'
        },

        warning: Warning,

        marker: {
          class:  Marker,
          shortcut: 'CMD+SHIFT+M'
        },

        code: {
          class:  CodeTool,
          shortcut: 'CMD+SHIFT+C'
        },

        delimiter: Delimiter,

        inlineCode: {
          class: InlineCode,
          shortcut: 'CMD+SHIFT+C'
        },

        linkTool: LinkTool,

        embed: Embed,

        table: {
          class: Table,
          inlineToolbar: true,
          shortcut: 'CMD+ALT+T'
        },

      },

      /**
       * This Tool will be used as default
       */
      // initialBlock: 'paragraph',

      /**
       * Initial Editor data
       */
      data: editorjsData,
      onReady: function(){
      
      },
      onChange: function() {
        editor.save().then((savedData) => {
            editorjsValue = JSON.stringify(savedData);
        });
      }
    });
    
EOT;
        return parent::render();
    }
    
}