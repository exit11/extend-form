@php
    switch ($level) {
        case '1':
        case '3':
        case '4':
        case '5':
        case '6':
            $tag = 'h' . $level;
            break;
        default:
            $tag = 'h2';
    };
@endphp

<!-- Create block tag -->
<{{$tag}}>{{$text}}</{{$tag}}>
    