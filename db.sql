/* Создание таблицы с артистами */
create table artists (
	artist_id int PRIMARY KEY,
    artist_name varchar(200) not null,
    artist_sub_count int not null DEFAULT 0,
    artist_listeners_amount int not null DEFAULT 0,
    artist_albums_amount int not null default 0
);

/* Создание таблицы с песнями */
create table tracks (
    track_id int AUTO_INCREMENT PRIMARY KEY,
    track_name varchar(200) not null,
    track_duration float not null,
    track_artist_id int not null,
    FOREIGN KEY (track_artist_id)
    REFERENCES artists (artist_id)
);