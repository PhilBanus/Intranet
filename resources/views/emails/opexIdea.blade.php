@component('mail::layout')
{{-- Header --}}
@slot('header')
@endslot

#  {{$Subject}} from {{$Name}}



{{$Body}}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} HOCHTIEF (UK) Construction Ltd. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent