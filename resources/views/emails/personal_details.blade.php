@component('mail::layout')
{{-- Header --}}
@slot('header')
@endslot

#  User Personal Details Updated



{{$user}} has updated their Personal info.

@component('mail::button', ['url' => url('/').'/HR/UserAmmendments?ID='.$id])
Click here View
@endcomponent


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