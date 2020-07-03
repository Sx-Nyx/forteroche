CREATE TABLE novel (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL UNIQUE,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description MEDIUMTEXT NOT NULL,
    created_at DATETIME NOT NULL,
    PRIMARY KEY (id)
);
CREATE TABLE chapter (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL UNIQUE,
    slug VARCHAR(255) NOT NULL UNIQUE,
    novel_id INT UNSIGNED NOT NULL,
    CONSTRAINT fk_novel
        FOREIGN KEY (novel_id)
        REFERENCES novel(id)
        ON DELETE CASCADE,
    content LONGTEXT NOT NULL,
    created_at DATETIME NOT NULL,
    PRIMARY KEY (id)
);
CREATE TABLE comment (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    author VARCHAR(255) NOT NULL,
    chapter_id INT UNSIGNED NOT NULL,
    CONSTRAINT fk_chapter
        FOREIGN KEY (chapter_id)
        REFERENCES chapter(id)
        ON DELETE CASCADE,
    content MEDIUMTEXT NOT NULL,
    reported SMALLINT NOT NULL,
    created_at DATETIME NOT NULL,
    PRIMARY KEY (id)
);
