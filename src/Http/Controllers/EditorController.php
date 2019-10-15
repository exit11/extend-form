<?php

namespace Exit11\ExtendForm\Http\Controllers;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use OpenGraph;

use Exit11\ExtendForm\Models\Editor;

class EditorController extends Controller
{
    
    
    public function drawEditorBlocks(Request $request)
    {
        $content = $request->content;
        
        return Editor::drawEditorBlocks($content);
        
    }
    
    /**
     * Editorjs Link 플러그인
     * @param  [[Type]] Request $request [[Description]]
     * @return [[Type]] [[Description]]
     */
    public function fetchURL(Request $request)
    {
        $data = OpenGraph::fetch($request->url);
        //dd($data);
        $result = [
            'success' => 1,
            'meta' => [
                'title' => $data['title'] ?? '',
                'site_name' => $data['site_name'] ?? '',
                'description' => $data['description'] ?? '',
                'image' => [
                    'url' => $data['image'] ?? '',
                ]
            ],
        ];
        return response()->json($result, 200);
    }
    
    /**
     * Editorjs Image 플러그인 파일업로드
     * @param  [[Type]] Request $request [[Description]]
     * @return [[Type]] [[Description]]
     */
    public function uploadImage(Request $request)
    {
        $file = $request->image;
        $path = Storage::disk('admin')->getAdapter()->getPathPrefix();
        if(is_file($file)){
            $filename = round(microtime(true)*1000).'_'.filter_var($file->getClientOriginalName(), FILTER_SANITIZE_URL);
            Storage::disk('admin')->putFileAs('editor_images', $file, $filename, 'public');
            
            // 이미지가 가로 1140px보다 클 경우 1140px로 줄임
            \Image::make($path.'editor_images/'.$filename)->widen(1140, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            })->save()->destroy();
        }
        
        $result = [
            'success' => 1,
            'file' => [
                'url' => Storage::disk('admin')->url('editor_images/'.$filename),
            ],
        ];
        
        return response()->json($result, 200);
    }
    
    /**
     * Editorjs Image 플러그인 파일URL
     * @param  [[Type]] Request $request [[Description]]
     * @return [[Type]] [[Description]]
     */
    public function fetchImageUrl(Request $request)
    {
        $result = [
            'success' => 1,
            'file' => [
                'url' => $request->url,
            ],
        ];
        
        return response()->json($result, 200);
    }
    
}