<x-layout>
    <x-slot:title>Preguntas Frecuentes - TechSolutions</x-slot:title>

    <div class="bg-slate-50">

        {{-- Header de la sección --}}
        <div class="px-8 pt-10 pb-6">
            <h1 class="text-3xl font-bold text-slate-800">FAQ</h1>
            <p class="text-lg font-semibold text-slate-700 mt-1">Preguntas Frecuentes</p>
            <p class="text-slate-500 mt-2">
                Por favor, te invitamos a leer nuestro portal de preguntas frecuentes y en caso de
                no poder resolver tus dudas puedes contactarnos mediante nuestro
                <a href="{{ asset('/contacto') }}" class="font-semibold text-slate-700 hover:underline">contacto</a>.
            </p>
        </div>

        {{-- Card blanca contenedora del acordion --}}
        <div class="mx-8 mb-10 bg-white rounded-lg shadow-sm border border-slate-200 pb-4">

            <div class="px-6 py-5 border-b border-slate-200">
                <h2 class="text-xl font-bold text-slate-800">Preguntas Frecuentes</h2>
                <p class="text-slate-500 mt-1 text-sm">Haz clic en una pregunta para ver la respuesta.</p>
            </div>

            {{-- Accordion con Alpine ~ lo volvemos a utilizar iwal que con la navbar de celu --}}
            <div class="divide-y divide-slate-200 pb-2" x-data="{ open: null }">
                @php
                    $faqs = [
                        [
                            'pregunta' => '¿Qué servicios ofrece Techsolution?',
                            'respuesta' => 'Ofrecemos soluciones de desarrollo de software, soporte técnico e infraestructura tecnológica adaptadas a las necesidades de tu empresa.',
                        ],
                        [
                            'pregunta' => '¿Cuál es el tiempo de respuesta a una solicitud?',
                            'respuesta' => 'Normalmente respondemos dentro de las primeras 24 horas hábiles luego de recibir tu mensaje a través del formulario de contacto.',
                        ],
                        [
                            'pregunta' => '¿Tienen cobertura a nivel nacional?',
                            'respuesta' => 'Sí, contamos con cobertura en las principales regiones del país. Puedes revisar el detalle en la sección Cobertura.',
                        ],
                        [
                            'pregunta' => '¿Cómo puedo solicitar soporte técnico?',
                            'respuesta' => 'Puedes escribirnos mediante el formulario de Contacto seleccionando el asunto "Soporte Técnico", o llamando directamente a nuestra línea de atención.',
                        ],
                    ];
                @endphp

                @foreach ($faqs as $index => $faq)
                    <div>
                        <button
                            type="button"
                            @click="open = (open === {{ $index }}) ? null : {{ $index }}"
                            class="w-full flex items-center justify-between px-6 py-4 text-left hover:bg-slate-50 transition-colors"
                        >
                            <span class="font-medium text-slate-800">{{ $faq['pregunta'] }}</span>
                            <svg
                                class="w-5 h-5 text-slate-400 shrink-0 ml-4 transition-transform duration-200"
                                :class="{ 'rotate-180': open === {{ $index }} }"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div
                            x-show="open === {{ $index }}"
                            x-collapse
                            class="px-6 pb-4 -mt-1"
                        >
                            <p class="text-slate-600 text-sm leading-relaxed">
                                {{ $faq['respuesta'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-layout>