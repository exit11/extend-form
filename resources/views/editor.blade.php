<div class="editorjs-wrap">
    <div class="header">
        <h4>{{ $label }}</h4>
        <div class="header-btns">
            <button type="button" class="btn btn-sm btn-editor-preview btn-info" data-toggle="modal" data-target="#dialogEditorPreview"><i class="fa fa-search"></i> 미리보기 </button>
        </div>
    </div>
    <div class="editor-wrapper">
        @include('admin::form.error')
        <textarea id="inputEditorjs" name="{{$name}}" class="{{$class}}" style="display:none;" {!! $attributes !!}>{{ old($column, $value) }}</textarea>
        <div id="editorjs"></div>
        @include('admin::form.help-block')
    </div>
</div>

<div id="dialogEditorPreview" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
        <div class="modal-body">
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->