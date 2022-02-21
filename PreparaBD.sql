CREATE TABLE Usuarios (
	Id Int PRIMARY KEY AUTO_INCREMENT,
	Apelido VarChar(50),
	Nome VarChar(50)
);

CREATE TABLE Notificacoes (
	Id Int PRIMARY KEY AUTO_INCREMENT,
	Tipo VarChar(10),
	Usuario VarChar(50),
	Mensagem VarChar(200),
	Apontamento Int,
	Lido TinyInt(1) DEFAULT 0,
	DataHora DateTime DEFAULT Now(),
	FOREIGN KEY(Usuario) REFERENCES Usuarios(Apelido)   
);   

INSERT INTO Usuarios (Apelido, Nome) VALUES
	('informago','Luciano Reis'),
	('upezao','Gabriel Reis'),
	('dida','Myllena Reis')
