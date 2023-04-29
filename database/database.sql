DROP TABLE IF EXISTS Admin;
DROP TABLE IF EXISTS Agent;
DROP TABLE IF EXISTS Client;
DROP TABLE IF EXISTS Ticket;
DROP TABLE IF EXISTS Department;
DROP TABLE IF EXISTS Agent_Department;
DROP TABLE IF EXISTS Tag;
DROP TABLE IF EXISTS Ticket_Tag;
DROP TABLE IF EXISTS Ticket_Document;

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

CREATE TABLE Ticket_Document
(
    TicketID int NOT NULL,
    Path varchar NOT NULL,
    FOREIGN KEY (TicketID) REFERENCES Ticket(TicketID)
);

-- populate database

-- Populating Department table
INSERT INTO Department (DepartmentID, Name) VALUES (1, 'Informática');
INSERT INTO Department (DepartmentID, Name) VALUES (2, 'Mecância');
INSERT INTO Department (DepartmentID, Name) VALUES (3, 'Minas');

-- Populating Client table
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (1, 'John Doe', 'johndoe', 'johndoe@example.com', '$2y$12$iE8ekpQTxYrSH8ob6CAHrOTRRE9BYaVps3kILpKPgjdNVUdJOnwlm');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (2, 'Jane Smith', 'janesmith', 'janesmith@example.com', '$2y$12$iE8ekpQTxYrSH8ob6CAHrOTRRE9BYaVps3kILpKPgjdNVUdJOnwlm');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (3, 'Triple H', 'tripleHHH', 'hhh@gmail.com', '$2y$12$iE8ekpQTxYrSH8ob6CAHrOTRRE9BYaVps3kILpKPgjdNVUdJOnwlm');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (4, 'admin', 'admin', 'admin@admin.com', '$2y$12$iE8ekpQTxYrSH8ob6CAHrOTRRE9BYaVps3kILpKPgjdNVUdJOnwlm');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (5, 'Bob Johnson', 'bjohnson', 'bjohnson@example.com', '$2y$12$iE8ekpQTxYrSH8ob6CAHrOTRRE9BYaVps3kILpKPgjdNVUdJOnwlm');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (6, 'Alice Lee', 'alee', 'alee@example.com', '$2y$12$iE8ekpQTxYrSH8ob6CAHrOTRRE9BYaVps3kILpKPgjdNVUdJOnwlm');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (7, 'David Kim', 'dkim', 'dkim@example.com', '$2y$12$iE8ekpQTxYrSH8ob6CAHrOTRRE9BYaVps3kILpKPgjdNVUdJOnwlm');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (8, 'Sarah Park', 'spark', 'spark@example.com', '$2y$12$iE8ekpQTxYrSH8ob6CAHrOTRRE9BYaVps3kILpKPgjdNVUdJOnwlm');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (9, 'Tom Davis', 'tdavis', 'tdavis@example.com', '$2y$12$iE8ekpQTxYrSH8ob6CAHrOTRRE9BYaVps3kILpKPgjdNVUdJOnwlm');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (10, 'Emily Brown', 'ebrown', 'ebrown@example.com', '$2y$12$iE8ekpQTxYrSH8ob6CAHrOTRRE9BYaVps3kILpKPgjdNVUdJOnwlm');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (11, 'Mike Wilson', 'mwilson', 'mwilson@example.com', '$2y$12$iE8ekpQTxYrSH8ob6CAHrOTRRE9BYaVps3kILpKPgjdNVUdJOnwlm');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (12, 'Olivia Green', 'ogreen', 'ogreen@example.com', '$2y$12$iE8ekpQTxYrSH8ob6CAHrOTRRE9BYaVps3kILpKPgjdNVUdJOnwlm');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (13, 'Sophie Taylor', 'staylor', 'staylor@example.com', '$2y$12$iE8ekpQTxYrSH8ob6CAHrOTRRE9BYaVps3kILpKPgjdNVUdJOnwlm');

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
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES 
(1, "Unable to access my account", "When a user is having trouble logging in to their account, or their account is locked or suspended for some reason. This could be due to a forgotten username or password, a technical issue with the website, or other account-related issues that prevent the user from accessing their account.", 'Open', 1, 3, 1, '2023-04-01 12:00:00');

INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES 
(2, "Lost password", "When a user forgets their password and needs assistance resetting it. This could involve a password reset email not being received, the reset link not working, or other technical issues that prevent the user from resetting their password and accessing their account.", 'Closed', 2, 3, 2, '2023-01-02 12:00:00');

INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES 
(3, "Payment not processing" , "When a user is trying to make a payment on the site but it's not going through, or they're experiencing other payment-related issues. This could be due to technical issues with the payment gateway, errors with the user's payment information, or other issues preventing the payment from being processed.", 'Open', 4, 5, 1, '2023-01-03 12:00:00');

INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES 
(4, "Website is down", "When a user is trying to make a payment on the site but it's not going through, or they're experiencing other payment-related issues. This could be due to technical issues with the payment gateway, errors with the user's payment information, or other issues preventing the payment from being processed.", 'Open', 2, 4, 3, '2023-01-04 12:00:00');

INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES 
(5, "Product is out of stock", "When the website is completely inaccessible or not loading properly. This could be due to technical issues with the website's hosting, maintenance or updates being performed, or other issues preventing the site from functioning as expected.", 'Closed', 7, 7, 1, '2023-01-05 12:00:00');

INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES 
(6, "Item arrived damaged", "When a user attempts to purchase a product that is no longer available or out of stock. This could be due to inventory issues, product discontinuation, or other factors that prevent the product from being sold.", 'Closed', 1, 6, 1, '2022-01-05 12:00:00');

INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES 
(7, "Order not delivered", "When a user's order does not arrive at the expected delivery date or is lost in transit. This could be due to issues with the shipping carrier, incorrect shipping information, or other factors preventing the order from being delivered.", 'Closed', 1, 6, 1, '2022-01-05 12:00:00');

INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES 
(8, "Poor customer service", "When a user has had a negative experience with customer service, such as rude or unhelpful representatives, long wait times, or other issues that prevent them from receiving adequate support.", 'Closed', 12, 6, 1, '2022-01-05 12:00:00');

INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES 
(9, "Missing order items", "When a user's order is missing one or more items that they have purchased. This could be due to issues with inventory management or order fulfillment.", 'Closed', 5, 4, 1, '2023-01-05 12:00:00');

INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES 
(10, "Incorrect order received", "When a user receives an order that is different from what they expected or what they purchased. This could be due to errors in order fulfillment, incorrect product listings on the website, or other issues.", 'Open', 13, 5, 1, '2022-01-05 12:00:00');

INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES 
(11, "Account hacked or compromised", "When a user's account has been accessed by an unauthorized person, resulting in theft or misuse of personal information or account funds.", 'Open', 6, 6, 1, '2023-01-05 12:00:00');

INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES 
(12, "Difficulty navigating the website", "When a user has trouble finding what they're looking for on the website or navigating the site's features. This could be due to poor website design, confusing layouts, or other factors.", 'Closed', 5, 7, 1, '2023-01-05 12:00:00');

INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES 
(13, "Slow website performance", "When the website is slow to load, causing delays or frustration for users. This could be due to technical issues with the website's hosting, poor website design, or other factors that slow down the site's performance.", 'Closed', 4, 4, 1, '2019-01-05 12:00:00');

INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES 
(14, "Website is not mobile-friendly", "When the website is difficult to use on mobile devices, causing frustration for users who primarily access the site on their smartphones or tablets.", 'Open', 6, 7, 1, '2017-01-05 12:00:00');

INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES 
(15, "Emails not being received", "When users are not receiving important emails from the website, such as order confirmations or password reset emails. This could be due to technical issues with the email server or problems with the user's email provider.", 'Closed', 2, 3, 1, '2022-01-05 12:00:00');

INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES 
(16, "Website security issues", "When there are concerns about the security of the website, such as potential data breaches, malware or hacking, users should submit a ticket to report the issue and alert the website's administrators immediately. This is crucial to prevent further damage and protect user data from being compromised. The ticket should include details about the suspected security breach, any unusual activity or changes noticed on the website, and any relevant information that may help identify the source of the breach. The website's administrators can then investigate the issue, take necessary actions to address the breach, and notify affected users as needed to ensure their safety and security.", 'Closed', 3, 4, 1, '2023-04-23 03:50:00');

INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES 
(17, "Promo code not working", "When a user attempts to use a promotional code or discount but it is not being applied properly to their order. This could be due to expired codes, restrictions on usage, or technical issues with the website's promo code system.", 'Open', 9, 5, 1, '2023-04-23 02:44:00');

INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES 
(18, "Unsatisfactory product quality", "When a user receives a product that does not meet their expectations in terms of quality or performance. This could be due to issues with manufacturing or quality control processes, or inaccurate product descriptions on the website.", 'Open', 8, 6, 1, '2023-04-23 02:40:00');

INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES 
(19, "Difficulty canceling an order", "When a user wants to cancel an order but is having trouble doing so through the website or customer service channels. This could be due to a lack of clear cancellation policies, technical issues with the website's order management system, or unresponsive customer service.", 'Closed', 11, 7, 1, '2023-04-23 01:50:00');

INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) VALUES 
(20, "Account deletion requests", "When a user requests to have their account deleted but is having trouble doing so. This could be due to unclear account deletion policies, technical issues with the website's account management system, or unresponsive customer service.", 'Open', 12, 5, 1, '2022-01-05 12:00:00');

-- Populating Ticket_Tag table
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (1, 1);
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (1, 2);
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (1, 3);
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (2, 2);
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (3, 1);
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (4, 3);
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (5, 4);

-- Populating Ticket_Document table
INSERT INTO Ticket_Document (TicketID, Path) VALUES (1, 'docs/tickets-docs/CNV000009.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (3, 'docs/tickets-docs/CNV000010.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (10, 'docs/tickets-docs/CNV000011.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (12, 'docs/tickets-docs/CNV000020.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (4, 'docs/tickets-docs/CNV000023.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (5, 'docs/tickets-docs/CNV000025.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (7, 'docs/tickets-docs/CNV000030.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (7, 'docs/tickets-docs/CNV000031.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (1, 'docs/tickets-docs/CNV000032.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (1, 'docs/tickets-docs/CNV000033.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (6, 'docs/tickets-docs/CNV000035.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (6, 'docs/tickets-docs/CNV000036.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (6, 'docs/tickets-docs/CNV000037.JPG');









