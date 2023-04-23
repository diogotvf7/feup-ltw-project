DROP TABLE IF EXISTS Admin;
DROP TABLE IF EXISTS Agent;
DROP TABLE IF EXISTS Client;
DROP TABLE IF EXISTS Ticket;
DROP TABLE IF EXISTS Department;
DROP TABLE IF EXISTS Agent_Department;
DROP TABLE IF EXISTS Tag;
DROP TABLE IF EXISTS Ticket_Tag;

-- database schema

CREATE TABLE Admin 
(
    AdminID INTEGER PRIMARY KEY AUTOINCREMENT,
    FOREIGN KEY (AdminID) REFERENCES Client(ClientID)
);

CREATE TABLE Agent 
(
    AgentID INTEGER PRIMARY KEY AUTOINCREMENT,
    FOREIGN KEY (AgentID) REFERENCES Client(ClientID)
);

CREATE TABLE Client 
(
    ClientID INTEGER PRIMARY KEY AUTOINCREMENT, 
    Name varchar(255),
    Username varchar(255) NOT NULL,
    Email varchar(255) NOT NULL,
    Password NVARCHAR(40) NOT NULL
);

CREATE TABLE Ticket 
(
    TicketID INTEGER PRIMARY KEY AUTOINCREMENT,
    Title varchar(255) NOT NULL,
    Description varchar(255) NOT NULL,
    Status varchar(255) NOT NULL,
    ClientID int NOT NULL,
    AgentID int NOT NULL,
    DepartmentID int NOT NULL,
    Date datetime NOT NULL,
    FOREIGN KEY (ClientID) REFERENCES Client(ClientID),
    FOREIGN KEY (AgentID) REFERENCES Agent(AgentID),
    FOREIGN KEY (DepartmentID) REFERENCES Department(DepartmentID)
);

CREATE TABLE Department 
(   
    DepartmentID INTEGER PRIMARY KEY AUTOINCREMENT,
    Name varchar(255) NOT NULL
);

CREATE TABLE Agent_Department 
(
    AgentID int NOT NULL,
    DepartmentID int NOT NULL,
    FOREIGN KEY (AgentID) REFERENCES Agent(AgentID),
    FOREIGN KEY (DepartmentID) REFERENCES Department(DepartmentID)
);

CREATE TABLE Tag 
(
    TagID INTEGER PRIMARY KEY AUTOINCREMENT,
    Name varchar(255) NOT NULL
);

CREATE TABLE Ticket_Tag  
(
    TicketID int NOT NULL,
    TagID int NOT NULL,
    FOREIGN KEY (TicketID) REFERENCES Ticket(TicketID),
    FOREIGN KEY (TagID) REFERENCES Tag(TagID)
);

-- populate database

-- Populating Department table
INSERT INTO Department (DepartmentID, Name) VALUES (1, 'Informática');
INSERT INTO Department (DepartmentID, Name) VALUES (2, 'Mecância');
INSERT INTO Department (DepartmentID, Name) VALUES (3, 'Minas');

-- Populating Client table
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (1, 'John Doe', 'johndoe', 'johndoe@example.com', 'mypassword123');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (2, 'Jane Smith', 'janesmith', 'janesmith@example.com', 'abc123');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (3, 'Triple H', 'tripleHHH', 'hhh@gmail.com', '123456');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (4, 'admin', 'admin', 'admin@admin.com', '123456');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (5, 'Bob Johnson', 'bjohnson', 'bjohnson@example.com', '123456');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (6, 'Alice Lee', 'alee', 'alee@example.com', '123456');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (7, 'David Kim', 'dkim', 'dkim@example.com', '123456');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (8, 'Sarah Park', 'spark', 'spark@example.com', '123456');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (9, 'Tom Davis', 'tdavis', 'tdavis@example.com', '123456');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (10, 'Emily Brown', 'ebrown', 'ebrown@example.com', '123456');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (11, 'Mike Wilson', 'mwilson', 'mwilson@example.com', '123456');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (12, 'Olivia Green', 'ogreen', 'ogreen@example.com', '123456');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (13, 'Sophie Taylor', 'staylor', 'staylor@example.com', '123456');

-- Populating Agent table
INSERT INTO Agent (AgentID) VALUES (3);
INSERT INTO Agent (AgentID) VALUES (4);
INSERT INTO Agent (AgentID) VALUES (5);
INSERT INTO Agent (AgentID) VALUES (6);
INSERT INTO Agent (AgentID) VALUES (7);

-- Populating Admin table
INSERT INTO Admin (AdminID) VALUES (3);
INSERT INTO Admin (AdminID) VALUES (4);

-- Populating Agent_Department table
INSERT INTO Agent_Department (AgentID, DepartmentID) VALUES (3, 1);
INSERT INTO Agent_Department (AgentID, DepartmentID) VALUES (3, 2);
INSERT INTO Agent_Department (AgentID, DepartmentID) VALUES (4, 3);
INSERT INTO Agent_Department (AgentID, DepartmentID) VALUES (4, 2);
INSERT INTO Agent_Department (AgentID, DepartmentID) VALUES (5, 1);
INSERT INTO Agent_Department (AgentID, DepartmentID) VALUES (6, 1);
INSERT INTO Agent_Department (AgentID, DepartmentID) VALUES (7, 1);
INSERT INTO Agent_Department (AgentID, DepartmentID) VALUES (7, 2);
INSERT INTO Agent_Department (AgentID, DepartmentID) VALUES (7, 3);

-- Populating Tag table
INSERT INTO Tag (TagID, Name) VALUES (1, 'Technical');
INSERT INTO Tag (TagID, Name) VALUES (2, 'Billing');
INSERT INTO Tag (TagID, Name) VALUES (3, 'Product');
INSERT INTO Tag (TagID, Name) VALUES (4, 'Sales');

-- Populating Ticket table
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (1, 'Issue with product', 'I am having trouble with my product', 'Open', 1, 3, 1, '2023-04-01 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (2, 'Billing inquiry', 'I have a question about my bill', 'Closed', 2, 3, 2, '2023-01-02 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (3, 'Technical issue', 'My product is not working as expected', 'Open', 4, 5, 1, '2023-01-03 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (4, 'Product feedback', 'I have a suggestion for a new product feature', 'Open', 2, 4, 3, '2023-01-04 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (5, 'Sales inquiry', 'I want to know more about a product', 'Closed', 7, 7, 1, '2023-01-05 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (7, 'JUNI vs. NI', 'O ni ganhou obviamente', 'Closed', 1, 6, 1, '2022-01-05 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (8, 'JUNI vs. NI rematch', 'O ni ganhou outra vez!', 'Closed', 12, 6, 1, '2022-01-05 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (9, 'T01', 'Texto do T01', 'Closed', 5, 4, 1, '2023-01-05 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (10, 'T02', 'Texto do T02', 'Open', 13, 5, 1, '2022-01-05 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (11, 'T03', 'Texto do T03', 'Open', 6, 6, 1, '2023-01-05 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (12, 'T04', 'Texto do T04', 'Closed', 5, 7, 1, '2023-01-05 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (13, 'T05', 'Texto do T05', 'Closed', 4, 4, 1, '2019-01-05 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (14, 'T06', 'Texto do T06', 'Open', 6, 7, 1, '2017-01-05 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (15, 'T07', 'Texto do T07', 'Closed', 2, 3, 1, '2022-01-05 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (16, 'T08', 'Texto do T08', 'Closed', 3, 4, 1, '2023-04-23 03:50:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (17, 'T09', 'Texto do T09', 'Open', 9, 5, 1, '2023-04-23 02:44:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (18, 'T10', 'Texto do T10', 'Open', 8, 6, 1, '2023-04-23 02:40:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (19, 'T11', 'Texto do T11', 'Closed', 11, 7, 1, '2023-04-23 01:50:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (20, 'T12', 'Texto do T12', 'Open', 12, 5, 1, '2022-01-05 12:00:00');

-- Populating Ticket_Tag table
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (1, 1);
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (1, 2);
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (1, 3);
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (2, 2);
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (3, 1);
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (4, 3);
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (5, 4);