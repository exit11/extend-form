<div class="editorjs-wrap">
    <div class="header">
        <h4>{{ $label }}</h4>
    </div>
    <div class="editor-wrapper">
        @include('admin::form.error')
        <textarea id="inputEditorjs" name="{{$name}}" class="{{$class}}" style="display:none;" {!! $attributes !!}>{{ old($column, $value) }}</textarea>
        <div id="editorjs"></div>
        @include('admin::form.help-block')
    </div>
</div>