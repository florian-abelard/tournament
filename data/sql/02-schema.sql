USE tournoi;

CREATE TABLE player (
    uuid VARCHAR(36) NOT NULL,
    name VARCHAR(100) NOT NULL,
    PRIMARY KEY (uuid)
);

CREATE TABLE tournament (
    uuid VARCHAR(36) NOT NULL,
    name VARCHAR(100) NOT NULL,
    PRIMARY KEY (uuid)
);

CREATE TABLE tournament_player (
    tournament_uuid VARCHAR(36) NOT NULL,
    player_uuid VARCHAR(36) NOT NULL,
    PRIMARY KEY (tournament_uuid, player_uuid),
    FOREIGN KEY (tournament_uuid) REFERENCES tournament (uuid) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (player_uuid) REFERENCES player (uuid) ON DELETE CASCADE ON UPDATE CASCADE
)
