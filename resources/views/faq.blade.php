<x-layout>
    <x-slot:title>Preguntas Frecuentes - Techsolutions</x-slot:title>

    <main class="w-full bg-slate-50 dark:bg-[#0d1b2a] pt-32 pb-24 transition-colors duration-300">
        <section class="mx-auto w-full max-w-5xl px-4 sm:px-6 lg:px-8">
            
            {{-- Header de la sección --}}
            <div class="text-center md:text-left mb-10">
                <h1 class="text-3xl sm:text-4xl font-bold text-[#113f59] dark:text-white tracking-tight">FAQ</h1>
                <div class="h-1 w-16 bg-orange-500 mt-3 mx-auto md:mx-0 rounded-full"></div>
                <p class="text-lg font-semibold text-slate-700 dark:text-slate-200 mt-4">Preguntas Frecuentes</p>
                <p class="text-slate-600 dark:text-slate-300 mt-2 max-w-2xl">
                    Por favor, te invitamos a leer nuestro portal de preguntas frecuentes y en caso de
                    no poder resolver tus dudas puedes contactarnos mediante nuestro
                    <a href="{{ asset('/contacto') }}" class="font-semibold text-orange-500 hover:underline">contacto</a>.
                </p>
            </div>

            {{-- Card contenedora del acordeón (Nativo con HTML y Tailwind) --}}
            <div class="bg-white dark:bg-[#113f59]/30 rounded-2xl shadow-sm border border-slate-200 dark:border-[#113f59] overflow-hidden transition-colors duration-300">

                <div class="px-6 sm:px-8 py-6 border-b border-slate-200 dark:border-[#113f59]">
                    <h2 class="text-xl font-bold text-[#113f59] dark:text-white">Preguntas Frecuentes</h2>
                    <p class="text-slate-500 dark:text-slate-300 mt-1 text-sm">Haz clic en una pregunta para ver la respuesta.</p>
                </div>

                {{-- Acordeón puramente nativo usando <details> y <summary> --}}
                <div class="divide-y divide-slate-200 dark:divide-[#113f59]/60">
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

                    @foreach ($faqs as $faq)
                        <details class="group transition-colors">
                            <summary class="w-full flex items-center justify-between px-6 sm:px-8 py-4 text-left cursor-pointer list-none hover:bg-slate-50 dark:hover:bg-[#113f59]/40 transition-colors">
                                <span class="font-medium text-[#113f59] dark:text-white pr-4">{{ $faq['pregunta'] }}</span>
                                <span class="bg-orange-500/10 p-2 rounded-xl text-orange-500 shrink-0 transition-transform duration-200 group-open:rotate-180">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </summary>

                            <div class="px-6 sm:px-8 pb-5 pt-1">
                                <p class="text-slate-600 dark:text-slate-300 text-sm sm:text-base leading-relaxed">
                                    {{ $faq['respuesta'] }}
                                </p>
                            </div>
                        </details>
                    @endforeach
                </div>
            </div>

        </section>
    </main>
</x-layout>

{{-- Vista de FAQ pendiente de rediseño, requisitos:
- El acordeón actualmente depende de Alpine.js (x-data, x-show, x-collapse), se debe quitar esa dependencia y dejar la interacción resuelta solo con elementos oficiales de trabajo (Tailwindcss o CSS vanilla)
- Revisar contraste y colores en modo oscuro
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}