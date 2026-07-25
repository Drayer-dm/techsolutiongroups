<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceProjectController extends Controller
{

    public function index()
    {
        // 1. Servicios
        $servicios = [
            ['titulo' => 'Servicio informático', 'icono' => '💻'],
            ['titulo' => 'Cámaras de seguridad', 'icono' => '📹'],
            ['titulo' => 'Cableado estructurado', 'icono' => '🔌'],
            ['titulo' => 'Outsorcing informático', 'icono' => '🤝'],
            ['titulo' => 'Sistema respaldo en línea', 'icono' => '☁️'],
            ['titulo' => 'Hardware / Software', 'icono' => '⚙️'],
            ['titulo' => 'Proyectos eléctricos', 'icono' => '⚡'],
            ['titulo' => 'Diseño y Desarrollo web', 'icono' => '🌐']
        ];

        // 2. Proyectos
        $proyectos = [
            [
                'titulo' => 'Instalación Cámaras en Planta Proceso',
                'descripcion' => 'Levantamiento de requerimientos, instalación estratégica de cámaras, configuración de respaldo DVR y acceso remoto seguro.',
                'galeria' => [
                    ['imagen' => '/images/proyectosTechSolutions/camara/imagen-camara1.jpg', 'leyenda' => 'Instalación interna.'],
                    ['imagen' => '/images/proyectosTechSolutions/camara/imagen-camara2.jpg', 'leyenda' => 'Conexionado.'],
                    ['imagen' => '/images/proyectosTechSolutions/camara/imagen-camara3.png', 'leyenda' => 'Instalación externa.']
                ]
            ],
            [
                'titulo' => 'Cableado Estructurado Corporativo',
                'descripcion' => 'Renovación integral de cableado UTP, conexión a Patch Panel, instalación de rosetas y ordenamiento de Rack en múltiples sucursales.',
                'galeria' => [
                    ['imagen' => '/images/proyectosTechSolutions/cableado/imagen-cableado-1.jpg', 'leyenda' => 'Cableado UTP.'],
                    ['imagen' => '/images/proyectosTechSolutions/cableado/imagen-cableado-2.jpg', 'leyenda' => 'Rack organizado.'],
                    ['imagen' => '/images/proyectosTechSolutions/cableado/imagen-cableado-3.jpg', 'leyenda' => 'Puntos de red.']
                ]
            ],
            [
                'titulo' => 'Servicio de Outsourcing IT',
                'descripcion' => 'Asistencia técnica en terreno para resolución de incidencias críticas que superan el alcance del soporte remoto estándar.',
                'galeria' => [
                    ['imagen' => '/images/proyectosTechSolutions/outsorcing/imagen-outsorcing-1.jpg', 'leyenda' => 'CCTV Avanzado.'],
                    ['imagen' => '/images/proyectosTechSolutions/outsorcing/imagen-outsorcing-2.jpg', 'leyenda' => 'Tableros de control.'],
                    ['imagen' => '/images/proyectosTechSolutions/outsorcing/imagen-outsorcing-3.jpg', 'leyenda' => 'Mantenimiento hardware.']
                ]
            ],
            [
                'titulo' => 'Diseño y Desarrollo Web',
                'descripcion' => 'Creación de sitios web a medida, optimización, landing pages y sistemas CMS adaptados a la necesidad comercial del cliente.',
                'galeria' => [
                    ['imagen' => '/images/proyectosTechSolutions/desarrollo/sachoedicionespage.jpg', 'leyenda' => 'Sacho Ediciones', 'link' => '#'],
                    ['imagen' => '/images/proyectosTechSolutions/desarrollo/visionampliapage.jpg', 'leyenda' => 'Visión Amplia', 'link' => '#'],
                    ['imagen' => '/images/proyectosTechSolutions/desarrollo/mantec-mtpage.jpg', 'leyenda' => 'Mantec MT', 'link' => '#']
                ]
            ]
        ];

        // 3. Clientes 
        $clientes = [
            ['nombre' => 'Banco Estado', 'logo' => '/images/proyectosTechSolutions/clientes/banco-estado.jpg'],
            ['nombre' => 'Entel', 'logo' => '/images/proyectosTechSolutions/clientes/entel-logo.png'],
            ['nombre' => 'Geositel', 'logo' => '/images/proyectosTechSolutions/clientes/geositel-logo.gif'],
            ['nombre' => 'HP', 'logo' => '/images/proyectosTechSolutions/clientes/hp-logo.webp'],
            ['nombre' => 'Lenovo', 'logo' => '/images/proyectosTechSolutions/clientes/lenovo-logo.webp'],
            ['nombre' => 'Servipag', 'logo' => '/images/proyectosTechSolutions/clientes/servipag-logo.png'],
        ];

        return view('servicios-proyectos', compact('servicios', 'proyectos', 'clientes'));
    }
}