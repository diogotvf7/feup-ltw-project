DROP TABLE IF EXISTS Admin;
DROP TABLE IF EXISTS Agent;
DROP TABLE IF EXISTS Client;
DROP TABLE IF EXISTS Ticket;
DROP TABLE IF EXISTS Department;
DROP TABLE IF EXISTS Tag;
DROP TABLE IF EXISTS Ticket_Tag;

-- database schema

CREATE TABLE Admin 
(
    Admin ID int NOT NULL,
    Name varchar(255) NOT NULL,
    Username varchar(255) NOT NULL,
    Email varchar(255) NOT NULL,
    Password NVARCHAR(40) NOT NULL,
    CONSTRAINT PK_Admin PRIMARY KEY (AdminID)
);

CREATE TABLE Agent 
(
    AgentID int NOT NULL,
    Name varchar(255) NOT NULL,
    Username varchar(255) NOT NULL,
    Email varchar(255) NOT NULL,
    Password NVARCHAR(40) NOT NULL,
    DepartmentID int NOT NULL,
    CONSTRAINT PK_Agent PRIMARY KEY (AgentID),
    FOREIGN KEY (DepartmentID) REFERENCES Department(DepartmentID)
);

CREATE TABLE Client 
(
    ClientID int NOT NULL,
    Name varchar(255) NOT NULL,
    Username varchar(255) NOT NULL,
    Email varchar(255) NOT NULL,
    Password NVARCHAR(40) NOT NULL,
    CONSTRAINT PK_Client PRIMARY KEY (ClientID)
);

CREATE TABLE Ticket 
(
    TicketID int NOT NULL,
    Title varchar(255) NOT NULL,
    Description varchar(255) NOT NULL,
    Status varchar(255) NOT NULL,
    ClientID int NOT NULL,
    AgentID int NOT NULL,
    DepartmentID int NOT NULL,
    Date datetime NOT NULL,
    CONSTRAINT PK_Ticket PRIMARY KEY (TicketID),
    FOREIGN KEY (ClientID) REFERENCES Client(ClientID),
    FOREIGN KEY (AgentID) REFERENCES Agent(AgentID),
    FOREIGN KEY (DepartmentID) REFERENCES Department(DepartmentID)
);

CREATE TABLE Department 
(   
    DepartmentID int NOT NULL,
    Name varchar(255) NOT NULL,
    CONSTRAINT PK_Department PRIMARY KEY (DepartmentID)
);

CREATE TABLE Tag 
(
    TagID int NOT NULL,
    Name varchar(255) NOT NULL,
    CONSTRAINT PK_Tag PRIMARY KEY (TagID)
);

CREATE TABLE Ticket_Tag  
(
    TicketID int NOT NULL,
    TagID int NOT NULL,
    FOREIGN KEY (TicketID) REFERENCES Ticket(TicketID),
    FOREIGN KEY (TagID) REFERENCES Tag(TagID)
);

-- populate database

-- Admins
INSERT INTO Admin (AdminID, Name, Username, Email, Password) VALUES (1, 'John Doe', 'johndoe', 'johndoe@example.com', 'password123');
INSERT INTO Admin (AdminID, Name, Username, Email, Password) VALUES (2, 'Jane Smith', 'janesmith', 'janesmith@example.com', 'password456');
INSERT INTO Admin (AdminID, Name, Username, Email, Password) VALUES (3, 'admin', 'admin', 'admin@gmail.com', '123456');

-- Agents
INSERT INTO Agent (AgentID, Name, Username, Email, Password, DepartmentID) VALUES (1, 'Alice Jones', 'alicejones', 'alicejones@example.com', 'password789', 1);
INSERT INTO Agent (AgentID, Name, Username, Email, Password, DepartmentID) VALUES (2, 'Bob Smith', 'bobsmith', 'bobsmith@example.com', 'password012', 2);
INSERT INTO Agent (AgentID, Name, Username, Email, Password, DepartmentID) VALUES (3, 'Charlie Brown', 'charliebrown', 'charliebrown@example.com', 'password345', 1);
INSERT INTO Agent (AgentID, Name, Username, Email, Password, DepartmentID) VALUES (4, 'David Lee', 'davidlee', 'davidlee@example.com', 'password678', 3);
INSERT INTO Agent (AgentID, Name, Username, Email, Password, DepartmentID) VALUES (5, 'John Doe', 'johndoe', 'johndoe@example.com', 'password123', 1);
INSERT INTO Agent (AgentID, Name, Username, Email, Password, DepartmentID) VALUES (6, 'Jane Smith', 'janesmith', 'janesmith@example.com', 'password456', 1);
INSERT INTO Agent (AgentID, Name, Username, Email, Password, DepartmentID) VALUES (7, 'agent', 'agent', 'agent@gmail.com', '123456', 3);

-- Clients
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (1, 'Emily Davis', 'emilydavis', 'emilydavis@example.com', 'password901');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (2, 'Frank Green', 'frankgreen', 'frankgreen@example.com', 'password234');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (3, 'Grace Hernandez', 'gracehernandez', 'gracehernandez@example.com', 'password567');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (4, 'Henry Johnson', 'henryjohnson', 'henryjohnson@example.com', 'password890');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (5, 'John Doe', 'johndoe', 'johndoe@example.com', 'password123');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (6, 'Jane Smith', 'janesmith', 'janesmith@example.com', 'password456');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (7, 'Alice Jones', 'alicejones', 'alicejones@example.com', 'password789');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (8, 'Bob Smith', 'bobsmith', 'bobsmith@example.com', 'password012');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (9, 'Charlie Brown', 'charliebrown', 'charliebrown@example.com', 'password345');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (10, 'David Lee', 'davidlee', 'davidlee@example.com', 'password678');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (11, 'client', 'client', 'client@gmail.com', '123456');

-- Departments
INSERT INTO Department (DepartmentID, Name) VALUES (1, 'Sales');
INSERT INTO Department (DepartmentID, Name) VALUES (2, 'Support');
INSERT INTO Department (DepartmentID, Name) VALUES (3, 'Marketing');

-- Tags
INSERT INTO Tag (TagID, Name) VALUES (1, 'Urgent');
INSERT INTO Tag (TagID, Name) VALUES (2, 'Billing');
INSERT INTO Tag (TagID, Name) VALUES (3, 'Technical');

-- Tickets
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (1, 'Problem with Payment', 'I cannot seem to process my payment on your website.', 'Open', 1, 2, 1, '2022-01-01 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (2, 'Need Help with Installation', 'I need assistance installing your software on my computer.', 'Open', 2, 3, 2, '2022-01-02 13:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (3, 'Issue with Website', 'There seems to be a problem with your website. I cannot access it.', 'Open', 3, 1, 1, '2022-01-03 14:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (4, 'Problem with My Account', 'I am having trouble accessing my account. Can you help me?', 'Open', 4, 4, 3, '2022-01-04 15:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (5, 'Product Inquiry', 'I would like to learn more about your new product.', 'Open', 1, 2, 1, '2022-01-05 16:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (6, 'Billing Question', 'I have a question about my recent bill.', 'Open', 2, 3, 2, '2022-01-06 17:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (7, 'Technical Support', 'I need help troubleshooting an issue with your software.', 'Open', 3, 1, 1, '2022-01-07 18:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES (8, 'Website Feedback', 'I have some feedback about your website.', 'Open', 4, 4, 3, '2022-01-08 19:00:00');