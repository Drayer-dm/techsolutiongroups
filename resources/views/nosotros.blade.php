<x-layout>

    <x-slot:title>Sobre Nosotros - TechSolutions</x-slot:title>

    <div class="pt-32 pb-20 px-4 max-w-7xl mx-auto">
        <div class="max-w-4xl mx-auto py-6 px-4 transition-colors duration-300">
            
            <!-- Título Principal -->
            <h1 class="text-center text-3xl md:text-4xl font-extrabold text-[#113f59] dark:text-white tracking-tight">
               Sobre Nosotros
            </h1>
            <div class="h-1 w-20 bg-orange-500 mt-3 mx-auto rounded-full mb-6"></div>
         
            <p class="text-slate-600 dark:text-slate-300 mt-4 text-base md:text-lg text-center leading-relaxed">
               Fundada en Chile en 2014, somos una compañía de servicios integrales orientada a convertirnos en el socio estratégico que tu empresa necesita. Combinamos experiencia técnica, flexibilidad y un profundo entendimiento de los objetivos de negocio, potenciando cada proyecto a través de estándares de calidad, buenas prácticas y un proceso de mejora continua.
            </p>

            <!-- Tarjetas de Misión y Visión -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-12">
                <div class="bg-white dark:bg-[#113f59]/30 p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-[#113f59] transition-colors duration-300">
                    <h2 class="text-xl font-bold text-[#113f59] dark:text-white mb-3">Nuestra Misión</h2>
                    <p class="text-slate-600 dark:text-slate-300 text-sm md:text-base">
                        Proveer soluciones de software innovadoras y eficientes que optimicen la administración y el control de proyectos para empresas en constante crecimiento.
                    </p>
                </div>
                <div class="bg-white dark:bg-[#113f59]/30 p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200 dark:border-[#113f59] transition-colors duration-300">
                    <h2 class="text-xl font-bold text-[#113f59] dark:text-white mb-3">Nuestra Visión</h2>
                    <p class="text-slate-600 dark:text-slate-300 text-sm md:text-base">
                        Ser líderes en el desarrollo de plataformas web corporativas, reconocidos por la calidad de nuestros sistemas y la adaptabilidad a las nuevas tecnologías.
                    </p>
                </div>
            </div>

            <!-- Sección de Valores Interactiva Adaptable -->
            <div class="mt-20" x-data="{ active: 2 }">
                <h2 class="text-2xl md:text-3xl font-bold text-[#113f59] dark:text-white mb-4 text-center">Nuestros Valores</h2>
                <p class="text-slate-500 dark:text-slate-400 text-xs md:text-sm text-center mb-10">Toca o selecciona una tarjeta para explorar</p>
                
                <!-- 
                  EN MÓVILES (< md): Se muestra un grid vertical limpio de 1 columna para evitar superposiciones feas.
                  EN ESCRITORIO (>= md): Se activa el contenedor absoluto con el efecto interactivo horizontal.
                -->
                
                <!-- Versión Móvil (Grid Vertical) -->
                <div class="grid grid-cols-1 gap-6 md:hidden">
                    <!-- Valor 1 -->
                    <div @click="active = 1" :class="active === 1 ? 'border-orange-500 ring-2 ring-orange-500/20' : 'border-slate-200 dark:border-[#113f59]'" class="bg-white dark:bg-[#113f59]/30 border rounded-2xl p-6 flex flex-col items-center text-center transition-all cursor-pointer shadow-sm">
                        <div class="w-12 h-12 rounded-full bg-orange-500/10 flex items-center justify-center text-orange-500 mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#113f59] dark:text-white">Innovación Continua</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-2">Adaptamos tecnologías de vanguardia para ofrecer soluciones eficientes.</p>
                    </div>

                    <!-- Valor 2 -->
                    <div @click="active = 2" :class="active === 2 ? 'border-orange-500 ring-2 ring-orange-500/20' : 'border-slate-200 dark:border-[#113f59]'" class="bg-white dark:bg-[#113f59]/30 border rounded-2xl p-6 flex flex-col items-center text-center transition-all cursor-pointer shadow-sm">
                        <div class="w-12 h-12 rounded-full bg-orange-500/10 flex items-center justify-center text-orange-500 mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#113f59] dark:text-white">Compromiso y Calidad</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-2">Garantizamos excelencia y cumplimiento riguroso en cada proyecto.</p>
                    </div>

                    <!-- Valor 3 -->
                    <div @click="active = 3" :class="active === 3 ? 'border-orange-500 ring-2 ring-orange-500/20' : 'border-slate-200 dark:border-[#113f59]'" class="bg-white dark:bg-[#113f59]/30 border rounded-2xl p-6 flex flex-col items-center text-center transition-all cursor-pointer shadow-sm">
                        <div class="w-12 h-12 rounded-full bg-orange-500/10 flex items-center justify-center text-orange-500 mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#113f59] dark:text-white">Trabajo en Equipo</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-2">Colaboramos de manera sinérgica para alcanzar metas ambiciosas.</p>
                    </div>
                </div>

                <!-- Versión Escritorio/Tablet (Efecto Carrusel Dinámico Superpuesto) -->
                <div class="hidden md:flex relative justify-center items-center min-h-[360px] w-full py-6">
                    
                    <!-- Tarjeta 1: Innovación Continua -->
                    <div 
                        @click="active = 1"
                        :class="{
                            'z-30 scale-105 rotate-0 translate-x-0 shadow-2xl border-orange-500 dark:border-orange-400': active === 1,
                            'z-10 -translate-x-40 -rotate-6 opacity-80 hover:opacity-100 shadow-xl border-slate-200 dark:border-[#113f59]': active !== 1
                        }"
                        class="absolute w-72 h-64 bg-white dark:bg-[#113f59] border rounded-3xl p-6 flex flex-col items-center justify-center text-center transition-all duration-500 ease-in-out cursor-pointer"
                    >
                        <div class="w-12 h-12 rounded-full bg-orange-500/10 dark:bg-orange-500/20 flex items-center justify-center text-orange-500 mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#113f59] dark:text-white">Innovación Continua</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-200 mt-2">Adaptamos tecnologías de vanguardia para ofrecer soluciones eficientes.</p>
                    </div>

                    <!-- Tarjeta 2: Compromiso y Calidad -->
                    <div 
                        @click="active = 2"
                        :class="{
                            'z-30 scale-105 rotate-0 translate-x-0 shadow-2xl border-orange-500 dark:border-orange-400': active === 2,
                            'z-20 translate-x-40 rotate-6 opacity-80 hover:opacity-100 shadow-xl border-slate-200 dark:border-[#113f59]': active === 1,
                            'z-20 -translate-x-40 -rotate-6 opacity-80 hover:opacity-100 shadow-xl border-slate-200 dark:border-[#113f59]': active === 3
                        }"
                        class="absolute w-72 h-64 bg-white dark:bg-[#113f59] border rounded-3xl p-6 flex flex-col items-center justify-center text-center transition-all duration-500 ease-in-out cursor-pointer"
                    >
                        <div class="w-12 h-12 rounded-full bg-orange-500/10 dark:bg-orange-500/20 flex items-center justify-center text-orange-500 mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#113f59] dark:text-white">Compromiso y Calidad</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-200 mt-2">Garantizamos excelencia y cumplimiento riguroso en cada proyecto.</p>
                    </div>

                    <!-- Tarjeta 3: Trabajo en Equipo -->
                    <div 
                        @click="active = 3"
                        :class="{
                            'z-30 scale-105 rotate-0 translate-x-0 shadow-2xl border-orange-500 dark:border-orange-400': active === 3,
                            'z-10 translate-x-40 rotate-6 opacity-80 hover:opacity-100 shadow-xl border-slate-200 dark:border-[#113f59]': active !== 3
                        }"
                        class="absolute w-72 h-64 bg-white dark:bg-[#113f59] border rounded-3xl p-6 flex flex-col items-center justify-center text-center transition-all duration-500 ease-in-out cursor-pointer"
                    >
                        <div class="w-12 h-12 rounded-full bg-orange-500/10 dark:bg-orange-500/20 flex items-center justify-center text-orange-500 mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#113f59] dark:text-white">Trabajo en Equipo</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-200 mt-2">Colaboramos de manera sinérgica para alcanzar metas ambiciosas.</p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-layout>

{{-- Vista Nosotros pendiente de revisión visual, requisitos:
- Esta vista no tiene clases dark: como el resto del sitio, revisar si debe soportar modo oscuro para mantener consistencia
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}
