CREATE DATABASE football;

USE football;

CREATE TABLE matches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team1 VARCHAR(255),
    team2 VARCHAR(255),
    score1 INT,
    score2 INT,
    match_date DATE
);
