@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

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
{{--            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.--}}
            &copy; کلیه حقوق مادی و معنوی این وب سایت متعلق به وب سایت {{__('content.site_name')}} میباشد.
        @endcomponent
    @endslot
@endcomponent
