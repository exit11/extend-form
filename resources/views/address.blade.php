<div class="{{$viewClass['form-group']}} {!! !$errors->has($errorKey) ? '' : 'has-error' !!}">

    <label for="{{$id}}" class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')
        
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-map-marker"></i>
            </span>
            <input type="text" class="form-control {{$class}}" id="{{$id}}" name="{{$name}}" placeholder="{{ $placeholder }}" {!! $attributes !!} value="{{ old($column, $value) }}">
            <span class="input-group-btn clearfix">
                <button type="button" class="btn btn-daum-address btn-info" type="button"><i class="fa fa-search"></i> {{admin_trans('admin.search')}} </button>
            </span>
        </div>

        @include('admin::form.help-block')

    </div>
</div>