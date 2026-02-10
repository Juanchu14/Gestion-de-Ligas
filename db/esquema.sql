
CREATE DATABASE IF NOT EXISTS gestion_ligas;
USE gestion_ligas;

-- Tabla de Ligas
CREATE TABLE IF NOT EXISTS ligas (
    id_liga INT AUTO_INCREMENT PRIMARY KEY, 
    nombre VARCHAR(100) NOT NULL,            
    fecha_inicio DATE,                      
    tipo_liga VARCHAR(50),                  
    reglas TEXT                             
) ENGINE=InnoDB;

-- Tabla de Equipos
CREATE TABLE IF NOT EXISTS equipos (
    id_equipo INT AUTO_INCREMENT PRIMARY KEY, 
    nombre VARCHAR(100) NOT NULL,             
    id_liga INT,
    FOREIGN KEY (id_liga) REFERENCES ligas(id_liga) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabla de Clasificación
CREATE TABLE IF NOT EXISTS clasificaciones (
    id_clasificacion INT AUTO_INCREMENT PRIMARY KEY, 
    id_equipo INT,
    puntos INT DEFAULT 0,  
    pj INT DEFAULT 0,      -- Partidos jugados
    pg INT DEFAULT 0,      -- Partidos ganados
    pe INT DEFAULT 0,      -- Partidos empatados
    pp INT DEFAULT 0,      -- Partidos perdidos
    FOREIGN KEY (id_equipo) REFERENCES equipos(id_equipo) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabla de Partidos
CREATE TABLE IF NOT EXISTS partidos (
    id_partido INT AUTO_INCREMENT PRIMARY KEY, 
    id_liga INT,
    id_equipo_local INT,
    id_equipo_visitante INT,
    fecha DATETIME,                           
    resultado VARCHAR(20) DEFAULT '0-0',      
    estado VARCHAR(20) DEFAULT 'pendiente',    
    FOREIGN KEY (id_liga) REFERENCES ligas(id_liga) ON DELETE CASCADE,
    FOREIGN KEY (id_equipo_local) REFERENCES equipos(id_equipo),
    FOREIGN KEY (id_equipo_visitante) REFERENCES equipos(id_equipo)
) ENGINE=InnoDB;

-- Tabla de Estadísticas 
CREATE TABLE IF NOT EXISTS estadisticas (
    id_estadistica INT AUTO_INCREMENT PRIMARY KEY,  
    id_partido INT,
    goles INT DEFAULT 0,                           
    tarjeta_amarilla INT DEFAULT 0,                
    tarjeta_roja INT DEFAULT 0,                     
    FOREIGN KEY (id_partido) REFERENCES partidos(id_partido) ON DELETE CASCADE
) ENGINE=InnoDB;