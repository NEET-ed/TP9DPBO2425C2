-- Create database
CREATE DATABASE IF NOT EXISTS mvp_db;
USE mvp_db;

-- Create table pembalap
CREATE TABLE IF NOT EXISTS pembalap (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    tim VARCHAR(255) NOT NULL,
    negara VARCHAR(255) NOT NULL,
    poinMusim INT DEFAULT 0,
    jumlahMenang INT DEFAULT 0
);

CREATE TABLE tim_balap (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    markas VARCHAR(100) NOT NULL,
    tahunBerdiri YEAR(4) NOT NULL
);

-- Insert data
INSERT INTO pembalap (nama, tim, negara, poinMusim, jumlahMenang) VALUES
('Lewis Hamilton', 'Mercedes', 'United Kingdom', 347, 11),
('Max Verstappen', 'Red Bull', 'Netherlands', 335, 10),
('Valtteri Bottas', 'Mercedes', 'Finland', 203, 2),
('Sergio Perez', 'Red Bull', 'Mexico', 190, 1),
('Carlos Sainz', 'Ferrari', 'Spain', 150, 0),
('Daniel Ricciardo', 'McLaren', 'Australia', 115, 1),
('Charles Leclerc', 'Ferrari', 'Monaco', 95, 0),
('Lando Norris', 'McLaren', 'United Kingdom', 88, 0),
('Pierre Gasly', 'AlphaTauri', 'France', 75, 0),
('Fernando Alonso', 'Alpine', 'Spain', 65, 0);

INSERT INTO tim_balap (nama, markas, tahunBerdiri) VALUES
('Thunder Racing Team', 'Jakarta', 2005),
('Garuda Speed Crew', 'Bandung', 2010),
('Nusantara Drift Squad', 'Surabaya', 2012),
('Borneo Rally Masters', 'Samarinda', 2008),
('Sumatra Velocity', 'Medan', 2015),
('Eastern Cyclone Racing', 'Makassar', 2011),
('Java Street Racers', 'Yogyakarta', 2007),
('Bali Turbo Team', 'Denpasar', 2013),
('Papua Fastline', 'Jayapura', 2016),
('Sulawesi Nitro Force', 'Manado', 2009);
