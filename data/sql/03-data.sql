USE tournoi;

DELETE FROM tournament;
INSERT INTO tournament (uuid, name, status)
VALUES ('859772a8-07bf-4e9c-8733-83f3bf806b09', 'Tournoi d\'Orvault', 'upcoming'),
       ('fd0125f1-2f43-46c4-833d-86d98600610d', 'Tournoi de la Chapelaine', 'upcoming'),
       ('422d591b-4cac-45be-adf5-1a231e83ff52', 'Les 24 heures du Pallet', 'upcoming');

DELETE FROM player;
INSERT INTO player (uuid, name, ranking_points)
VALUES ('1da757a7-5d93-417e-8baa-49749a436f68', 'Florian Abélard', 1510),
       ('9a462cd6-e935-4e2c-8b51-e5e746025488', 'Antoine Tomaszek', 1628),
       ('e3ff4320-703f-4598-9a58-464f0e9675d2', 'Mickaël Beaurepaire', 1035),
       ('39d30dd1-7453-40fb-9d40-634f3b529201', 'Matthias Desson', 1171),
       ('e782b600-69ce-43d9-bcbe-0d0449d9f7e5', 'Maud Lasterre', null),
       ('07246b0b-da85-462c-b518-457fe2cac8d0', 'Roxane Abélard', null),
       ('856e28e9-d035-4498-88b5-1fb6685ed3d5', 'Philippe Gobin', 1430),
       ('73dd9a8e-561f-41c3-82a6-6fcec70cc523', 'Aurélien Martin', 1411),
       ('aff17e04-a54d-416d-9ef8-283faebddf5d', 'Elisa Vaccara', 1390),
       ('ceaacfc5-4d5f-43d2-93ef-e3b086175a01', 'Samuel Claveau', 1359),
       ('88e6b82f-aeb8-4f18-abe4-c496935030e1', 'Julien Rondeau', 1311),
       ('544739d7-0421-4d59-a410-e75d0e9cabd7', 'Aurélien Durand', 1302);

DELETE FROM registration;
INSERT INTO registration (tournament_uuid, player_uuid, registration_date)
VALUES ('859772a8-07bf-4e9c-8733-83f3bf806b09', '1da757a7-5d93-417e-8baa-49749a436f68', '2018-04-24 02:23:00'),
       ('859772a8-07bf-4e9c-8733-83f3bf806b09', '9a462cd6-e935-4e2c-8b51-e5e746025488', '2018-05-12 09:12:28');
