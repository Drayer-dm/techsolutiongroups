<x-layout>
    <x-slot:title>Sobre Nosotros - TechSolutions</x-slot:title>
   

    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Sobre Nosotros</h1>
        <p class="text-slate-600 mt-2 text-lg">Conoce más sobre TechSolutions y nuestra misión de modernizar la gestión de proyectos tecnológicos.</p>

      
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h2 class="text-xl font-bold text-slate-700 mb-2">Nuestra Misión</h2>
                <p class="text-slate-600">
                    Proveer soluciones de software innovadoras y eficientes que optimicen la administración y el control de proyectos para empresas en constante crecimiento.
                </p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h2 class="text-xl font-bold text-slate-700 mb-2">Nuestra Visión</h2>
                <p class="text-slate-600">
                    Ser líderes en el desarrollo de plataformas web corporativas, reconocidos por la calidad de nuestros sistemas y la adaptabilidad a las nuevas tecnologías.
                </p>
            </div>
        </div>

        <div class="mt-10">
            <h2 class="text-2xl font-bold text-slate-800 mb-4">Nuestros Valores</h2>
            <ul class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <li class="bg-slate-50 p-4 rounded-lg border border-slate-200 text-center font-medium text-slate-700">Innovación Continua</li>
                <li class="bg-slate-50 p-4 rounded-lg border border-slate-200 text-center font-medium text-slate-700">Compromiso y Calidad</li>
                <li class="bg-slate-50 p-4 rounded-lg border border-slate-200 text-center font-medium text-slate-700">Trabajo en Equipo</li>
            </ul>
        </div>
    </div>
</x-layout>

{{-- Vista Nosotros pendiente de revisión visual, requisitos:
- Esta vista no tiene clases dark: como el resto del sitio, revisar si debe soportar modo oscuro para mantener consistencia
- Colores institucionales deben tomarse de https://www.techsolution.cl/ --}}
