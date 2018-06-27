USE tournoi;

CREATE TABLE `player` (
    uuid VARCHAR(36) NOT NULL,
    name VARCHAR(100) NOT NULL,
    ranking_points SMALLINT UNSIGNED,
    PRIMARY KEY (uuid)
);

CREATE TABLE `tournament` (
    uuid VARCHAR(36) NOT NULL,
    name VARCHAR(100) NOT NULL,
    PRIMARY KEY (uuid)
);

CREATE TABLE `stage` (
    uuid VARCHAR(36) NOT NULL,
    tournament_uuid VARCHAR(36) NOT NULL,
    type VARCHAR(20),
    places_number_in_group SMALLINT UNSIGNED,
    PRIMARY KEY (uuid),
    FOREIGN KEY (tournament_uuid) REFERENCES `tournament` (uuid) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `group` (
    uuid VARCHAR(36) NOT NULL,
    stage_uuid VARCHAR(36) NOT NULL,
    label VARCHAR(100),
    places_number SMALLINT UNSIGNED,
    PRIMARY KEY (uuid),
    FOREIGN KEY (stage_uuid) REFERENCES `stage` (uuid) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `registration` (
    player_uuid VARCHAR(36) NOT NULL,
    tournament_uuid VARCHAR(36) NOT NULL,
    registration_date DATETIME,
    PRIMARY KEY (player_uuid, tournament_uuid),
    FOREIGN KEY (player_uuid) REFERENCES `player` (uuid) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (tournament_uuid) REFERENCES `tournament` (uuid) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `group_player` (
    group_uuid VARCHAR(36) NOT NULL,
    player_uuid VARCHAR(36) NOT NULL,
    PRIMARY KEY (group_uuid, player_uuid),
    FOREIGN KEY (group_uuid) REFERENCES `group` (uuid) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (player_uuid) REFERENCES `player` (uuid) ON DELETE CASCADE ON UPDATE CASCADE
);
