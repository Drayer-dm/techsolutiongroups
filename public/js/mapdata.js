var simplemaps_countrymap_mapdata={
  main_settings: {
   //General settings
    width: "responsive", //'700' or 'responsive'
    background_color: "#FFFFFF",
    background_transparent: "yes",
    border_color: "#ffffff",
    
    //State defaults
    state_description: "State description",
    state_color: "#88A4BC",
    state_hover_color: "#3B729F",
    state_url: "",
    border_size: 1.5,
    all_states_inactive: "no",
    all_states_zoomable: "yes",
    
    //Location defaults
    location_description: "Location description",
    location_url: "",
    location_color: "#FF0067",
    location_opacity: 0.8,
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
    label_size: 16,
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
    CLAI: {
      name: "Aisén del General Carlos Ibáñez del Campo",
      color: "#edfb4a"
    },
    CLAN: {
      name: "Antofagasta",
      color: "#029602"
    },
    CLAP: {
      name: "Arica y Parinacota",
      color: "#f20000"
    },
    CLAR: {
      name: "La Araucanía",
      color: "#f4efd0"
    },
    CLAT: {
      name: "Atacama",
      color: "#c3480b"
    },
    CLBI: {
      name: "Bío-Bío",
      color: "#ee99d4"
    },
    CLCO: {
      name: "Coquimbo",
      color: "#be8a71"
    },
    CLLI: {
      name: "Libertador General Bernardo O'Higgins",
      color: "#8048f0"
    },
    CLLL: {
      name: "Los Lagos",
      color: "#985d4c"
    },
    CLLR: {
      name: "Los Ríos",
      color: "#2faf12"
    },
    CLMA: {
      name: "Magallanes y Antártica Chilena",
      color: "#8de369"
    },
    CLML: {
      name: "Maule",
      color: "#beb249"
    },
    CLNB: {
      name: "Ñuble",
      color: "#da18cb"
    },
    CLRM: {
      name: "Región Metropolitana de Santiago",
      color: "#f8fa9e"
    },
    CLTA: {
      name: "Tarapacá",
      color: "#faea53"
    },
    CLVS: {
      name: "Valparaíso",
      color: "#71be06"
    }
  },
  locations: {
    "0": {
      name: "Santiago",
      lat: "-33.45",
      lng: "-70.666667"
    }
  },
  labels: {
    CLAI: {
      name: "Aisén del General Carlos Ibáñez del Campo",
      parent_id: "CLAI"
    },
    CLAN: {
      name: "Antofagasta",
      parent_id: "CLAN"
    },
    CLAP: {
      name: "Arica y Parinacota",
      parent_id: "CLAP"
    },
    CLAR: {
      name: "La Araucanía",
      parent_id: "CLAR"
    },
    CLAT: {
      name: "Atacama",
      parent_id: "CLAT"
    },
    CLBI: {
      name: "Bío-Bío",
      parent_id: "CLBI"
    },
    CLCO: {
      name: "Coquimbo",
      parent_id: "CLCO"
    },
    CLLI: {
      name: "Libertador General Bernardo O'Higgins",
      parent_id: "CLLI"
    },
    CLLL: {
      name: "Los Lagos",
      parent_id: "CLLL"
    },
    CLLR: {
      name: "Los Ríos",
      parent_id: "CLLR"
    },
    CLMA: {
      name: "Magallanes y Antártica Chilena",
      parent_id: "CLMA"
    },
    CLML: {
      name: "Maule",
      parent_id: "CLML"
    },
    CLNB: {
      name: "Ñuble",
      parent_id: "CLNB"
    },
    CLRM: {
      name: "Región Metropolitana de Santiago",
      parent_id: "CLRM"
    },
    CLTA: {
      name: "Tarapacá",
      parent_id: "CLTA"
    },
    CLVS: {
      name: "Valparaíso",
      parent_id: "CLVS"
    }
  },
  legend: {
    entries: []
  },
  regions: {}
};