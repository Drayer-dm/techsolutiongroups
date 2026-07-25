@props([
'imagen',
'leyenda',
'link' => null,
])

<div class=" flex flex-col items-start w-full">
    <div class="w-full border border-gray-200 p-1 bg-white shadow-sm mb-3 h-40 flex items-center justify-center overflow-hidden">
        <img src=" {{ asset($imagen) }}" alt="{{ $leyenda }}" class=" max-w-full object-cover" loading="lazy">
    </div>
    <p class="text-[13px] text-gray-500 leading-tight"> {{ $leyenda }}</p>


    @if ($link)
    <a href="{{ $link }}" target="_blank" rel="noopener noreferrer" class="text-[13px] hover:text-yellow-600 font-medium mt-1 transition-colors">
        VerSitio Web ->
    </a>    
    @endif
</div>