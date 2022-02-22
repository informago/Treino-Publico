CREATE TABLE Usuarios (
	Id Int PRIMARY KEY AUTO_INCREMENT,
	Apelido VarChar(50) NOT NULL DEFAULT '',
	Nome VarChar(50) NOT NULL DEFAULT ''
);

CREATE TABLE Notificacoes (
	Id Int PRIMARY KEY AUTO_INCREMENT,
	Tipo VarChar(10) NOT NULL DEFAULT '',
	Usuario VarChar(50) NOT NULL DEFAULT '',
	Mensagem VarChar(200) NOT NULL DEFAULT '',
	Apontamento Int NOT NULL DEFAULT 0,
	Lido TinyInt(1) NOT NULL DEFAULT 0,
	DataHora DateTime NOT NULL DEFAULT Now(),
	FOREIGN KEY(Usuario) REFERENCES Usuarios(Apelido)
);   

CREATE TABLE Postagens (
	Id Int PRIMARY KEY AUTO_INCREMENT,
	Texto VarChar(250) NOT NULL DEFAULT ''
);

CREATE TABLE Comentarios (
	Id Int PRIMARY KEY AUTO_INCREMENT,
	Post Int,
	Autor VarChar(100) NOT NULL DEFAULT '',
	Texto VarChar(250) NOT NULL DEFAULT ''
);

INSERT INTO Usuarios (Apelido, Nome) VALUES
	('informago','Luciano Reis'),
	('upezao','Gabriel Reis'),
	('dida','Myllena Reis');

INSERT INTO Postagens (Texto) VALUES
	('Exemplo 01'),
	('Exemplo 02');

INSERT INTO Comentarios (Post, Autor, Texto) VALUES
	( 1, 'Pessoa A','Gostei do artigo'),
	( 1, 'Pessoa B','Podia melhorar'),
	( 2, 'Pessoa A','Já desse eu não gostei');
