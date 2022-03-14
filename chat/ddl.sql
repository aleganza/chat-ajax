CREATE TABLE utenti(
    Id integer unsigned AUTO_INCREMENT,
    nome varchar(50),
    password varchar(50),

    primary key(Id)
)

CREATE TABLE chat(
    Id integer unsigned AUTO_INCREMENT,
    utente1Id integer unsigned,
    utente2Id integer unsigned,

    primary key(Id),
    foreign key(utente1Id) references utenti(Id),
    foreign key(utente2Id) references utenti(Id)
)

CREATE TABLE messaggi(
    Id integer unsigned,
    chatId integer unsigned,
    utenteId integer unsigned,
    testo varchar(1000),

    primary key(Id),
    foreign key(chatId) references chat(Id),
    foreign key(utenteId) references utenti(Id)
)