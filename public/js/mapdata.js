var simplemaps_countrymap_mapdata={
  main_settings: {
   //General settings
    width: "responsive", //'700' or 'responsive'
    background_color: "#FFFFFF",
    background_transparent: "yes",
    border_color: "#ffffff",
    
    //State defaults
    state_description: "Región con presencia operacional de TechSolutions",
    state_color: "#113f59",
    state_hover_color: "#f97316",
    state_url: "",
    border_size: 1.5,
    all_states_inactive: "no",
    all_states_zoomable: "yes",
    
    //Location defaults
    location_description: "Casa Matriz - Santiago",
    location_url: "",
    location_color: "#f97316",
    location_opacity: 0.9,
    location_hover_opacity: 1,
    location_size: 25,
    location_type: "square",
    location_image_source: "frog.png",
    location_border_color: "#FFFFFF",
    location_border: 2,
    location_hover_border: 2.5,
    all_locations_inactive: "no",
    all_locations_hidden: "no",
    
    //Label defaults
    label_color: "#ffffff",
    label_hover_color: "#ffffff",
    label_size: 14,
    label_font: "Arial",
    label_display: "auto",
    label_scale: "yes",
    hide_labels: "no",
    hide_eastern_labels: "no",
   
    //Zoom settings
    zoom: "yes",
    manual_zoom: "yes",
    back_image: "no",
    initial_back: "no",
    initial_zoom: "-1",
    initial_zoom_solo: "no",
    region_opacity: 1,
    region_hover_opacity: 0.6,
    zoom_out_incrementally: "yes",
    zoom_percentage: 0.99,
    zoom_time: 0.5,
    
    //Popup settings
    popup_color: "white",
    popup_opacity: 0.9,
    popup_shadow: 1,
    popup_corners: 5,
    popup_font: "12px/1.5 Verdana, Arial, Helvetica, sans-serif",
    popup_nocss: "no",
    
    //Advanced settings
    div: "map",
    auto_load: "yes",
    url_new_tab: "no",
    images_directory: "default",
    fade_time: 0.1,
    link_text: "View Website",
    popups: "detect",
    state_image_url: "",
    state_image_position: "",
    location_image_url: ""
  },
  state_specific: {
    // --- COBERTURA ALTA (Verde: #10b981) ---
    CLRM: {
      name: "Región Metropolitana de Santiago",
      description: "Cobertura Alta - Central de Operaciones y Soporte",
      color: "#10b981"
    },
    CLVS: {
      name: "Valparaíso",
      description: "Cobertura Alta - Sucursal y Proyectos Activos",
      color: "#10b981"
    },
    CLLL: {
      name: "Los Lagos",
      description: "Cobertura Alta - Operaciones Zona Sur",
      color: "#10b981"
    },
    CLAN: {
      name: "Antofagasta",
      description: "Cobertura Alta - Enlace Minero e Industrial",
      color: "#10b981"
    },
    CLBI: {
      name: "Bío-Bío",
      description: "Cobertura Alta - Cobertura Regional Completa",
      color: "#10b981"
    },

    // --- COBERTURA MEDIA (Ámbar/Naranja: #f59e0b) ---
    CLCO: {
      name: "Coquimbo",
      description: "Cobertura Media - Soporte Técnico Programado",
      color: "#f59e0b"
    },
    CLLI: {
      name: "Libertador General Bernardo O'Higgins",
      description: "Cobertura Media - Atención a Industrias y Agro",
      color: "#f59e0b"
    },
    CLML: {
      name: "Maule",
      description: "Cobertura Media - Proyectos de Redes Activos",
      color: "#f59e0b"
    },
    CLAR: {
      name: "La Araucanía",
      description: "Cobertura Media - Enlaces y Soporte",
      color: "#f59e0b"
    },
    CLLR: {
      name: "Los Ríos",
      description: "Cobertura Media - Cobertura Zona Sur",
      color: "#f59e0b"
    },
    CLNB: {
      name: "Ñuble",
      description: "Cobertura Media - Servicios Tecnológicos",
      color: "#f59e0b"
    },

    // --- COBERTURA BAJA (Rojo: #f43f5e) ---
    CLAP: {
      name: "Arica y Parinacota",
      description: "Cobertura Baja - Servicio bajo demanda",
      color: "#f43f5e"
    },
    CLTA: {
      name: "Tarapacá",
      description: "Cobertura Baja - Servicio bajo demanda",
      color: "#f43f5e"
    },
    CLAT: {
      name: "Atacama",
      description: "Cobertura Baja - Servicio bajo demanda",
      color: "#f43f5e"
    },
    CLAI: {
      name: "Aisén del General Carlos Ibáñez del Campo",
      description: "Cobertura Baja - Conectividad Remota",
      color: "#f43f5e"
    },
    CLMA: {
      name: "Magallanes y Antártica Chilena",
      description: "Cobertura Baja - Conectividad Remota y Austral",
      color: "#f43f5e"
    }
  },
  locations: {
    "0": {
      name: "Santiago (Casa Matriz)",
      lat: "-33.45",
      lng: "-70.666667",
      description: "Oficina Central TechSolutions"
    }
  },
  labels: {
    CLAI: { name: "Aisén", parent_id: "CLAI" },
    CLAN: { name: "Antofagasta", parent_id: "CLAN" },
    CLAP: { name: "Arica", parent_id: "CLAP" },
    CLAR: { name: "Araucanía", parent_id: "CLAR" },
    CLAT: { name: "Atacama", parent_id: "CLAT" },
    CLBI: { name: "Bío-Bío", parent_id: "CLBI" },
    CLCO: { name: "Coquimbo", parent_id: "CLCO" },
    CLLI: { name: "O'Higgins", parent_id: "CLLI" },
    CLLL: { name: "Los Lagos", parent_id: "CLLL" },
    CLLR: { name: "Los Ríos", parent_id: "CLLR" },
    CLMA: { name: "Magallanes", parent_id: "CLMA" },
    CLML: { name: "Maule", parent_id: "CLML" },
    CLNB: { name: "Ñuble", parent_id: "CLNB" },
    CLRM: { name: "R. Metropolitana", parent_id: "CLRM" },
    CLTA: { name: "Tarapacá", parent_id: "CLTA" },
    CLVS: { name: "Valparaíso", parent_id: "CLVS" }
  },
  legend: {
    entries: []
  },
  regions: {}
};