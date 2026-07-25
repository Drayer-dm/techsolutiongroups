<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceProjectController extends Controller
{
    /**
     * Retorna la vista fusionada de Servicios y Proyectos con datos estáticos.
     */
    public function index()
    {
        $servicios = [
            'Servicio informático Puerto Montt',
            'Cámaras seguridad Puerto Montt',
            'Cableado estructurado',
            'Outsorcing informático',
            'Sistema respaldo en línea',
            'Hardware/Software (Reparación, Ventas, Presupuesto etc.)',
            'Proyectos eléctricos',
            'Diseño y Desarrollo web'
        ];

        // 🔒 FIX: Se añade '/' al inicio de cada ruta de imagen para forzar la resolución desde el Document Root.
        $proyectos = [
            [
                'titulo' => 'Proyecto Instalación Cámaras en Planta Proceso',
                'descripcion' => 'Se realiza la toma de requerimiento por cliente, luego se procede a la instalación de cámaras según ubicación entregada por cliente considerando aspectos de respaldo en DVR, luego se configura aplicación para grabar localmente y finalmente se configura para acceder vía internet desde fuera de la planta.',
                'galeria' => [
                    ['imagen' => '/images/proyectosTechSolutions/camara/imagen-camara1.jpg', 'leyenda' => 'Instalación de cámara interna.'],
                    ['imagen' => '/images/proyectosTechSolutions/camara/imagen-camara2.jpg', 'leyenda' => 'Conectores.'],
                    ['imagen' => '/images/proyectosTechSolutions/camara/imagen-camara3.png', 'leyenda' => 'Instalación de cámara externa.']
                ]
            ],
            [
                'titulo' => 'Proyecto Cableado Estructurado',
                'descripcion' => 'Se realiza Renovación de cableado estructurado en sucursal conexión a Patch Panel, Instalación de Rosetas y enchufe en Rack.<br><br>Se repite procedimiento en varias sucursales de la zona sur por renovación cableado, proyecto macro.',
                'galeria' => [
                    ['imagen' => '/images/proyectosTechSolutions/cableado/imagen-cableado-1.jpg', 'leyenda' => 'Finalizado rotulado con cable UTP.'],
                    ['imagen' => '/images/proyectosTechSolutions/cableado/imagen-cableado-2.jpg', 'leyenda' => 'Rack Rotulado puerta instalada.'],
                    ['imagen' => '/images/proyectosTechSolutions/cableado/imagen-cableado-3.jpg', 'leyenda' => 'Colocacion PX y VX.']
                ]
            ],
            [
                'titulo' => 'Servicio Outsorcing',
                'descripcion' => 'Se realiza asistencia en terreno ante las incidencias generadas por cliente. Esta asistencia se presta sólo en caso de que soporte remoto no lo pueda solventar.',
                'galeria' => [
                    ['imagen' => '/images/proyectosTechSolutions/outsorcing/imagen-outsorcing-1.jpg', 'leyenda' => 'Camaras IP/CCTV'],
                    ['imagen' => '/images/proyectosTechSolutions/outsorcing/imagen-outsorcing-2.jpg', 'leyenda' => 'Cableado Estructurado'],
                    ['imagen' => '/images/proyectosTechSolutions/outsorcing/imagen-outsorcing-3.jpg', 'leyenda' => 'Mantenimiento de Infraestructura']
                ]
            ],
            [
                'titulo' => 'Diseño y Desarrollo Web',
                'descripcion' => '- Diseño y desarrollo Web a medida.<br>- Rediseño y optimización de su sitio Web actual.<br>- Landing pages y micrositios.<br>- Blogs y sitios comerciales.<br>- Diseños sobre Content Managements Systems (WordPress, Drupal, Joomla, etc.)',
                'galeria' => [
                    ['imagen' => '/images/proyectosTechSolutions/desarrollo/sachoedicionespage.jpg', 'leyenda' => 'Sachoediciones.cl', 'link' => '#'],
                    ['imagen' => '/images/proyectosTechSolutions/desarrollo/visionampliapage.jpg', 'leyenda' => 'Visionamplia.cl', 'link' => '#'],
                    ['imagen' => '/images/proyectosTechSolutions/desarrollo/mantec-mtpage.jpg', 'leyenda' => 'Mantec-mt.cl', 'link' => '#']
                ]
            ]
        ];

        return view('servicios-proyectos', compact('servicios', 'proyectos'));
    }
}