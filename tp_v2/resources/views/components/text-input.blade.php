@props(['disabled' => false])

<input @if($disabled) disabled @endif {!! $attributes->merge(['class' => 'form-control border-gray-300']) !!}>

