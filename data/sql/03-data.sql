USE tournoi;

DELETE FROM tournament;
INSERT INTO tournament (uuid, name)
VALUES ('859772a8-07bf-4e9c-8733-83f3bf806b09', 'Tournoi d\'Orvault'),
       ('fd0125f1-2f43-46c4-833d-86d98600610d', 'Tournoi de la Chapelaine'),
       ('422d591b-4cac-45be-adf5-1a231e83ff52', 'Les 24 heures du Pallet');

DELETE FROM player;
INSERT INTO player (uuid, name)
VALUES ('1da757a7-5d93-417e-8baa-49749a436f68', 'Florian Abélard'),
       ('9a462cd6-e935-4e2c-8b51-e5e746025488', 'Antoine Tomaszek'),
       ('e3ff4320-703f-4598-9a58-464f0e9675d2', 'Mickaël Beaurepaire'),
       ('39d30dd1-7453-40fb-9d40-634f3b529201', 'Matthias Desson'),
       ('544739d7-0421-4d59-a410-e75d0e9cabd7', 'Aurélien Durand');

DELETE FROM tournament_player;
INSERT INTO tournament_player (tournament_uuid, player_uuid)
VALUES ('859772a8-07bf-4e9c-8733-83f3bf806b09', '1da757a7-5d93-417e-8baa-49749a436f68'),
       ('859772a8-07bf-4e9c-8733-83f3bf806b09', '9a462cd6-e935-4e2c-8b51-e5e746025488');
