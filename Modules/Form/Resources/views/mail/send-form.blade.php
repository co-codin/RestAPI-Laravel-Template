@php
    /* @var \Modules\Form\Forms\Form $form  */
@endphp

{!! $form->getComments() !!}

@if(($utm = $form->getUtm()))
    <h3>UTM метки: </h3>
    @foreach($utm as $key => $value)
        <p><b>{{ $key }}:</b> {{ $value }}</p>
    @endforeach
@endif
