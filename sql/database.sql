-- Create scheme of tables --
CREATE TABLE role(
    id INTEGER PRIMARY KEY NOT NULL,
    name TEXT NOT NULL
);

CREATE TABLE account(
    username TEXT PRIMARY KEY NOT NULL,
    password TEXT NOT NULL,
    validity INTEGER NOT NULL,
    role INTEGER NOT NULL,
    FOREIGN KEY(role) REFERENCES role(id)
);

CREATE TABLE message(
    id INTEGER PRIMARY KEY NOT NULL,
    recieveDate TEXT NOT NULL,
    sender TEXT NOT NULL,
    reciever TEXT NOT NULL,
    subject TEXT NOT NULL,
    message TEXT NOT NULL,
    FOREIGN KEY(sender) REFERENCES account(username),
    FOREIGN KEY(reciever) REFERENCES account(username)
);

-- Insert values to tables --
INSERT INTO role(id, name) VALUES 
(NULL,'Collaborateur'), 
(NULL,'Administrateur');

INSERT INTO account(username, password, validity, role) VALUES 
('admin@sti.ch', '277bd398664ea2dfcab76d9a3955bff2f09ceabadf280c013e5b1b8109736046', 1, 2), -- password: admin2019
('collaborateur1@sti.ch', 'eeff84539a71d1161041c7e764fc96397d56d0c97300d12c6e2c6c557deabcd2', 1, 1), -- password: collaborateur2019
('collaborateur2@sti.ch', 'eeff84539a71d1161041c7e764fc96397d56d0c97300d12c6e2c6c557deabcd2', 1, 1); -- password: collaborateur2019

INSERT INTO message(id, recieveDate, sender, reciever, subject, message) VALUES 
(NULL, '2019-10-01', 'admin@sti.ch', 'collaborateur1@sti.ch', 'Bande passante', 'Arrête d''utiliser toute la bande passante !'),
(NULL, '2019-09-20', 'collaborateur1@sti.ch', 'collaborateur2@sti.ch', 'Projet d''octobre', 'Il faut qu''on parle du prochain projet sinon Mr. Smith ne sera pas content.'),
(NULL, '2019-10-01', 'collaborateur2@sti.ch', 'collaborateur1@sti.ch', 'Re: Projet d''octobre', 'Compris. Je veux pas avoir peur de lui quand il s''énerve');