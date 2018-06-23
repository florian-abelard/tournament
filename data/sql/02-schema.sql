USE tournoi;

CREATE TABLE player (
    uuid VARCHAR(36) NOT NULL,
    name VARCHAR(100) NOT NULL,
    ranking_points SMALLINT UNSIGNED,
    PRIMARY KEY (uuid)
);

CREATE TABLE tournament (
    uuid VARCHAR(36) NOT NULL,
    name VARCHAR(100) NOT NULL,
    PRIMARY KEY (uuid)
);

CREATE TABLE registration (
    player_uuid VARCHAR(36) NOT NULL,
    tournament_uuid VARCHAR(36) NOT NULL,
    registration_date DATETIME,
    PRIMARY KEY (player_uuid, tournament_uuid),
    FOREIGN KEY (player_uuid) REFERENCES player (uuid) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (tournament_uuid) REFERENCES tournament (uuid) ON DELETE CASCADE ON UPDATE CASCADE
)
