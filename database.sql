-- ══════════════════════════════════════════
-- COOK WITH SOUMI — database.sql
-- Run this script once to set up the database
-- ══════════════════════════════════════════

CREATE DATABASE IF NOT EXISTS cook_with_soumi
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE cook_with_soumi;

CREATE TABLE IF NOT EXISTS users (
    id            INT UNSIGNED  NOT NULL AUTO_INCREMENT,
    username      VARCHAR(80)   NOT NULL,
    email         VARCHAR(255)  NOT NULL,
    password_hash VARCHAR(255)  NOT NULL,
    created_at    DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at    DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP
                                ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
