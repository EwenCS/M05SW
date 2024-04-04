USE CirparkEwen;

CREATE TABLE IF NOT EXISTS Capteur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255),
    type VARCHAR(255),
    numero VARCHAR(255)


);

    
CREATE TABLE IF NOT EXISTS Configurations (
    idconfiguration INT AUTO_INCREMENT PRIMARY KEY,
    idcapteur INT,
    mode VARCHAR(255),
    potentiometre INT,
    hauteur INT,
    eclairage INT,
    POK INT,
    PNOK INT,
    POUT INT,
    InP INT,
    detection VARCHAR(15),
    version VARCHAR(15),
    FOREIGN KEY (idcapteur) REFERENCES Capteur(id)

);

CREATE TABLE etat
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    idcapteur INT,
    date DATETIME,
    etat VARCHAR(20),
    FOREIGN KEY (idcapteur) REFERENCES Capteur(id)                  
);