<div id="eltiptap">
  @include('admin::form.error')
  <textarea id="eltiptapContent" name="{{$name}}" class="{{$class}}" style="display:none;" {!! $attributes
    !!}>{{ old($column, $value) }}</textarea>
  @include('admin::form.help-block')
  <editor-wrap></editor-wrap>
</div>