CREATE TABLE IF NOT EXISTS bewertungen (
                                           id INT8 PRIMARY KEY AUTO_INCREMENT,
                                           bemerkung VARCHAR(200) CHECK ( LENGTH(bemerkung) >= 5 ),
                                           sterne_bewertung ENUM('sehr gut', 'gut', 'schlecht', 'sehr schlecht'),
                                           bewertungszeitpunkt DATETIME,
                                           hervorgehoben BOOLEAN DEFAULT FALSE,
                                           benutzer_id INT8 REFERENCES benutzer(id) ON UPDATE CASCADE ON DELETE CASCADE,
                                           gericht_id INTEGER REFERENCES gericht(id) ON UPDATE CASCADE ON DELETE CASCADE
);