<?php

namespace Exit11\ExtendForm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

use EditorJS\EditorJS;
use EditorJS\EditorJSException;

class Editor extends Model
{
    
    public static function drawEditorBlocks($content)
    {
        
        $editor = new EditorJS($content, self::getEditorConfig());
        
        $blocks = $editor->getBlocks();
        $renderedBlocks = [];
        
        /**
         * Using PHP renderer for Editor Content
         */
        foreach($blocks as $block) {
            $type = $block['type'];
            $data = $block['data'];
            $renderedBlocks[] = view('extend-form::plugins.'.$type, $data)->render();
        }
        
        return self::renderedBlock($renderedBlocks);
        
    }

    /**
     * Render EditorBlocks.
     *
     * @return string
     */
    protected static function renderedBlock($renderedBlocks)
    {
        ob_start();

        echo '<div class="editorjs-preview-wrap">';
        
        foreach ($renderedBlocks as $renderedBlock) {
            echo $renderedBlock;
        }
        
        echo '</div>';
        
        $contents = ob_get_contents();

        ob_end_clean();

        return $contents;
    }
    
    /**
     * Gets config for CodeX Editor, containing rules for validation Editor Tools data
     * @return string - Editor's config data
     * @throws Exceptions_ConfigMissedException - Failed to get Editorjs config data
     */
    protected static function getEditorConfig()
    {
        try {
            return file_get_contents(__DIR__.'/../../resources/json/editorjs-config.json');
        } catch (Exception $e) {
            throw new Exceptions_ConfigMissedException("EditorJS config not found");
        }
    }
}