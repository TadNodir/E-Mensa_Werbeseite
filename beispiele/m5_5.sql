CREATE PROCEDURE incrementLogin (IN user_id INT8)
BEGIN
    UPDATE benutzer SET anzahlanmeldungen = anzahlanmeldungen + 1 WHERE id = user_id;
END;