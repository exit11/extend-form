<?php

namespace Exit11\ExtendForm\Http\Controllers;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use OpenGraph;

class EditorController extends Controller
{
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
}