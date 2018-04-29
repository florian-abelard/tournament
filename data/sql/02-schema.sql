USE tournoi;

CREATE TABLE player (
    uuid VARCHAR(36) NOT NULL,
    name VARCHAR(100) NOT NULL,
    PRIMARY KEY (uuid)
);
