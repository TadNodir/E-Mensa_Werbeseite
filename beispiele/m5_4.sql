CREATE VIEW view_suppengerichte AS
SELECT * FROM gericht WHERE name LIKE '%suppe%' OR name LIKE '%Suppe%';

CREATE VIEW view_anmeldungen AS
SELECT anzahlanmeldungen FROM benutzer ORDER BY anzahlanmeldungen DESC;

CREATE VIEW view_kategoriegerichte_vegetarisch AS
SELECT gericht.name AS Gericht, kategorie.name AS Kategorie FROM kategorie
LEFT JOIN gericht_hat_kategorie ghk ON kategorie.id = ghk.kategorie_id
LEFT JOIN gericht ON ghk.gericht_id = gericht.id WHERE vegetarisch = 1;