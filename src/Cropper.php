<?php

namespace Exit11\ExtendForm;

use Encore\Admin\Form\Field\ImageField;
use Encore\Admin\Form\Field\File;
use Encore\Admin\Admin;
use Illuminate\Support\Facades\Storage;

class Cropper extends File
{
    //use Field\UploadField;
    use ImageField;

    protected $basename = null;

    private $ratioW = 100;

    private $ratioH = 100;

    protected $view = 'extend-form::cropper';

    protected static $css = [
        '/vendor/exit11/extend-form/cropper/cropper.min.css',
    ];

    protected static $js = [
        '/vendor/exit11/extend-form/cropper/cropper.min.js',
        '/vendor/exit11/extend-form/cropper/layer/layer.js'
    ];

    protected function preview()
    {
        return $this->objectUrl($this->value);
    }

    /**
     * @author Mike <zhengzhe94@gmail.com>
     * @param $base64ImageContent
     * @return bool
     */
    private function storeBase64Image($base64ImageContent)
    {
        //그림의 서식을 맞추다
        if (! preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64ImageContent, $result)) {
            return false;
        }

        $extension    = $result[2];
        $directory    = ltrim($this->getDirectory(), '/');
        $file_name    = $this->getStoreBasename() . '.' . $extension;
        $file_content = base64_decode(str_replace($result[1], '', $base64ImageContent));
        $file_path    = $directory . '/' . $file_name;

        Storage::disk(config('admin.upload.disk'))->put($file_path ,  $file_content);

        return $file_path ;
    }

    /**
     * @author Mike <zhengzhe94@gmail.com>
     * @param $basename
     * @return $this
     */
    public function basename($basename)
    {
        if ($basename) {
            $this->basename = $basename;
        }

        return $this;
    }

    /**
     * @author Mike <zhengzhe94@gmail.com>
     * @return mixed|null|string
     */
    protected function getStoreBasename()
    {
        if ($this->basename instanceof \Closure) {
            return $this->basename->call($this);
        }

        if (is_string($this->basename)) {
            return $this->basename;
        }

        return md5(uniqid());
    }

    /**
     * @author Mike <zhengzhe94@gmail.com>
     * @param array|\Symfony\Component\HttpFoundation\File\UploadedFile $base64
     * @return array|bool|mixed|string|\Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function prepare($base64)
    {
        //base64 인코딩 여부 점검
        if (preg_match('/data:image\/.*?;base64/is',$base64)) {
            $imagePath = $this->storeBase64Image($base64);
            $this->destroy();
            $this->callInterventionMethods($imagePath);
            return $imagePath;
        } else {
            $directory = ltrim($this->getDirectory(), '/');
            $directory = str_replace('/',"\/",$directory);
            preg_match('/' . $directory . '\/.*/is',$base64,$matches);
            return isset($matches[0]) ? $matches[0] : $base64;
        }
    }


    public function cRatio($width,$height)
    {
        if (!empty($width) and is_numeric($width)) {
            $this->attributes['data-w'] = $width;
        } else {
            $this->attributes['data-w'] = $this->ratioW;
        }
        if (!empty($height) and is_numeric($height)) {
            $this->attributes['data-h'] = $height;
        } else {
            $this->attributes['data-h'] = $this->ratioH;
        }
        return $this;
    }

    public function render()
    {
        $this->name = $this->formatName($this->column);

        if (!empty($this->value)) {
            $this->value = filter_var($this->preview());
        }
        
        $title = trans("extend-form::extend-form.edited_image_area");
        $btn1 = trans("extend-form::extend-form.selected_image_area");
        $btn2 = trans("extend-form::extend-form.original_image");
        $btn3 = trans("extend-form::extend-form.clear");

        $this->script = <<<EOT

//이미지 유형 예제
var cropperMIME = '';

function getMIME(base64)
{
    var preg = new RegExp('data:(.*);base64','i');
    var result = preg.exec(base64);
    return result[1];
}

function cropper(imgSrc,id,w,h)
{
    
    var cropperImg = '<div id="cropping-div"><img id="cropping-img" src="'+imgSrc+'"><\/div>';
    
    
    //레이어 모듈 생성
    layer.open({
        type: 1,
        skin: 'layui-layer-demo', //스킨명
        area: ['90%', '90%'],
        closeBtn: 2, //두 번째 닫기 버튼
        anim: 2,
        resize: false,
        shadeClose: false, //커버 닫기
        title: '{$title}',
        content: cropperImg,
        btn: ['{$btn1}','{$btn2}','{$btn3}'],
        btn1: function(){
            var cas = cropper.getCroppedCanvas({
                width: w,
                height: h
            });
            var base64url = cas.toDataURL(cropperMIME);
            $('#'+id+'-img').attr('src',base64url);
            $('#'+id+'-input').val(base64url);
            cropper.destroy();
            layer.closeAll('page');
        },
        btn2:function(){
            cropper.destroy();
        },
        btn3:function(){
            cropper.destroy();
            layer.closeAll('page');
            $('#'+id+'-img').removeAttr('src');
            $('#'+id+'-input').val('');
            $('#'+id+'-file').val('');
        }
    });

    var image = document.getElementById('cropping-img');
    var cropper = new Cropper(image, {
        aspectRatio: w / h,
        //aspectRatio: 16 / 9,
        viewMode: 2,
    });
}

$('.cropper-btn').click(function(){
    var id = $(this).attr('data-id');
    $('#'+id+'-file').click();
});


$('.cropper-file').change(function(){
    var id = $(this).attr('data-id');
    var w = $(this).attr('data-w');
    var h = $(this).attr('data-h');
    
    var file = $(this)[0].files[0];
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function(e){
        $('#'+id+'-img').attr('src',e.target.result);
        cropperMIME = getMIME(e.target.result);
        cropper(e.target.result,id,w,h);
        $('#'+id+'-input').val(e.target.result);
    };
});

$('.cropper-img').click(function(){
    var id = $(this).attr('data-id');
    var w = $(this).attr('data-w');
    var h = $(this).attr('data-h');
    cropper($(this).attr('src'),id,w,h);
});

EOT;

        if (!$this->display) {
            return '';
        }

        Admin::script($this->script);

        return view($this->getView(), $this->variables());
    }

}