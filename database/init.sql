CREATE DATABASE IF NOT EXISTS lab1;

USE lab1;

CREATE TABLE requests (
    request_id      INT             NOT NULL AUTO_INCREMENT,
    request_time    DATETIME        NOT NULL,
    x               FLOAT           NOT NULL,
    y               FLOAT           NOT NULL,
    r               FLOAT           NOT NULL,    
    is_correct      BOOLEAN         NOT NULL,
    PRIMARY KEY (request_id)
);