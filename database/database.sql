DROP TABLE IF EXISTS Admin;
DROP TABLE IF EXISTS Agent;
DROP TABLE IF EXISTS Client;
DROP TABLE IF EXISTS Ticket;
DROP TABLE IF EXISTS Department;
DROP TABLE IF EXISTS Agent_Department;
DROP TABLE IF EXISTS Tag;
DROP TABLE IF EXISTS Ticket_Tag;
DROP TABLE IF EXISTS Ticket_Document;
DROP TABLE IF EXISTS Ticket_Comment;
DROP TABLE IF EXISTS Ticket_Update;
DROP TABLE IF EXISTS Comment_Document;
DROP TABLE IF EXISTS FAQ;

-- database schema

CREATE TABLE Admin 
(
    ClientID INTEGER PRIMARY KEY AUTOINCREMENT,
    FOREIGN KEY (ClientID) REFERENCES Client(ClientID)
);

CREATE TABLE Agent 
(
    ClientID INTEGER PRIMARY KEY AUTOINCREMENT,
    FOREIGN KEY (ClientID) REFERENCES Client(ClientID)
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
    AgentID int ,
    DepartmentID int,
    Date datetime NOT NULL,
    FOREIGN KEY (ClientID) REFERENCES Client(ClientID),
    FOREIGN KEY (AgentID) REFERENCES Agent(ClientID),
    FOREIGN KEY (DepartmentID) REFERENCES Department(DepartmentID)
);

CREATE TABLE Department 
(   
    DepartmentID INTEGER PRIMARY KEY,
    Name varchar(255) NOT NULL
);

CREATE TABLE Agent_Department 
(
    AgentID int NOT NULL,
    DepartmentID int NOT NULL,
    FOREIGN KEY (AgentID) REFERENCES Agent(ClientID),
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

CREATE TABLE Ticket_Comment
(
    CommentID INTEGER PRIMARY KEY AUTOINCREMENT,
    TicketID int NOT NULL,
    ClientID int NOT NULL,
    Comment varchar(255) NOT NULL,
    Date datetime NOT NULL,
    FOREIGN KEY (TicketID) REFERENCES Ticket(TicketID),
    FOREIGN KEY (ClientID) REFERENCES Client(ClientID)
);

CREATE TABLE Ticket_Update
(
    UpdateID INTEGER PRIMARY KEY AUTOINCREMENT,
    TicketID int NOT NULL,
    Type varchar(10) NOT NULL,
    Message varchar(255) NOT NULL,
    Date datetime NOT NULL,
    FOREIGN KEY (TicketID) REFERENCES Ticket(TicketID)
);

CREATE TABLE Comment_Document
(
    CommentID int NOT NULL,
    Path varchar NOT NULL,
    FOREIGN KEY (CommentID) REFERENCES Ticket_Comment(CommentID)
);

CREATE TABLE FAQ
(
    FAQID INTEGER PRIMARY KEY,
    Question varchar(255) NOT NULL,
    Answer varchar(255) NOT NULL
);

-- populate database

-- Populating Department table
INSERT INTO Department (DepartmentID, Name) VALUES (1, 'Informática');
INSERT INTO Department (DepartmentID, Name) VALUES (2, 'Mecânica');
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
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (14, 'No Ticket Man', 'notickets', 'notickets@example.com', '$2y$12$iE8ekpQTxYrSH8ob6CAHrOTRRE9BYaVps3kILpKPgjdNVUdJOnwlm');
INSERT INTO Client (ClientID, Name, Username, Email, Password) VALUES (15, 'No Dep Man', 'nodep', 'nodep@example.com', '$2y$12$iE8ekpQTxYrSH8ob6CAHrOTRRE9BYaVps3kILpKPgjdNVUdJOnwlm');

-- Populating Agent table
INSERT INTO Agent (ClientID) VALUES (3);
INSERT INTO Agent (ClientID) VALUES (4);
INSERT INTO Agent (ClientID) VALUES (5);
INSERT INTO Agent (ClientID) VALUES (6);
INSERT INTO Agent (ClientID) VALUES (7);

-- Populating Admin table
INSERT INTO Admin (ClientID) VALUES (3);
INSERT INTO Admin (ClientID) VALUES (4);

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
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) 
VALUES (1, "Unable to access my account", "When a user is having trouble logging in to their account, or their account is locked or suspended for some reason. This could be due to a forgotten username or password, a technical issue with the website, or other account-related issues that prevent the user from accessing their account.", 'Open', 1, 3, 1, '2023-04-01 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) 
VALUES (2, "Lost password", "When a user forgets their password and needs assistance resetting it. This could involve a password reset email not being received, the reset link not working, or other technical issues that prevent the user from resetting their password and accessing their account.", 'Closed', 2, 3, 2, '2023-01-02 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) 
VALUES (3, "Payment not processing" , "When a user is trying to make a payment on the site but it's not going through, or they're experiencing other payment-related issues. This could be due to technical issues with the payment gateway, errors with the user's payment information, or other issues preventing the payment from being processed.", 'Open', 4, 5, 1, '2023-01-03 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) 
VALUES (4, "Website is down", "When a user is trying to make a payment on the site but it's not going through, or they're experiencing other payment-related issues. This could be due to technical issues with the payment gateway, errors with the user's payment information, or other issues preventing the payment from being processed.", 'Open', 2, 4, 3, '2023-01-04 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) 
VALUES (5, "Product is out of stock", "When the website is completely inaccessible or not loading properly. This could be due to technical issues with the website's hosting, maintenance or updates being performed, or other issues preventing the site from functioning as expected.", 'Closed', 7, 7, 1, '2023-01-05 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) 
VALUES (6, "Item arrived damaged", "When a user attempts to purchase a product that is no longer available or out of stock. This could be due to inventory issues, product discontinuation, or other factors that prevent the product from being sold.", 'Closed', 1, 6, 1, '2022-01-05 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) 
VALUES (7, "Order not delivered", "When a user's order does not arrive at the expected delivery date or is lost in transit. This could be due to issues with the shipping carrier, incorrect shipping information, or other factors preventing the order from being delivered.", 'Closed', 1, 6, 1, '2022-01-05 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) 
VALUES (8, "Poor customer service", "When a user has had a negative experience with customer service, such as rude or unhelpful representatives, long wait times, or other issues that prevent them from receiving adequate support.", 'Closed', 12, 6, 1, '2022-01-05 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) 
VALUES (9, "Missing order items", "When a user's order is missing one or more items that they have purchased. This could be due to issues with inventory management or order fulfillment.", 'Closed', 5, 4, 1, '2023-01-05 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) 
VALUES (10, "Incorrect order received", "When a user receives an order that is different from what they expected or what they purchased. This could be due to errors in order fulfillment, incorrect product listings on the website, or other issues.", 'Open', 13, 5, 1, '2022-01-05 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) 
VALUES (11, "Account hacked or compromised", "When a user's account has been accessed by an unauthorized person, resulting in theft or misuse of personal information or account funds.", 'Open', 6, 6, 1, '2023-01-05 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) 
VALUES (12, "Difficulty navigating the website", "When a user has trouble finding what they're looking for on the website or navigating the site's features. This could be due to poor website design, confusing layouts, or other factors.", 'Closed', 5, 7, 1, '2023-01-05 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) 
VALUES (13, "Slow website performance", "When the website is slow to load, causing delays or frustration for users. This could be due to technical issues with the website's hosting, poor website design, or other factors that slow down the site's performance.", 'Closed', 4, 4, 1, '2019-01-05 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) 
VALUES (14, "Website is not mobile-friendly", "When the website is difficult to use on mobile devices, causing frustration for users who primarily access the site on their smartphones or tablets.", 'Open', 6, 7, 1, '2017-01-05 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) 
VALUES (15, "Emails not being received", "When users are not receiving important emails from the website, such as order confirmations or password reset emails. This could be due to technical issues with the email server or problems with the user's email provider.", 'Closed', 2, 3, 1, '2022-01-05 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) 
VALUES (16, "Website security issues", "When there are concerns about the security of the website, such as potential data breaches, malware or hacking, users should submit a ticket to report the issue and alert the website's administrators immediately. This is crucial to prevent further damage and protect user data from being compromised. The ticket should include details about the suspected security breach, any unusual activity or changes noticed on the website, and any relevant information that may help identify the source of the breach. The website's administrators can then investigate the issue, take necessary actions to address the breach, and notify affected users as needed to ensure their safety and security.", 'Closed', 3, 4, 1, '2023-04-23 03:50:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) 
VALUES (17, "Promo code not working", "When a user attempts to use a promotional code or discount but it is not being applied properly to their order. This could be due to expired codes, restrictions on usage, or technical issues with the website's promo code system.", 'Open', 9, 5, 1, '2023-04-23 02:44:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) 
VALUES (18, "Unsatisfactory product quality", "When a user receives a product that does not meet their expectations in terms of quality or performance. This could be due to issues with manufacturing or quality control processes, or inaccurate product descriptions on the website.", 'Open', 8, 6, 1, '2023-04-23 02:40:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) 
VALUES (19, "Difficulty canceling an order", "When a user wants to cancel an order but is having trouble doing so through the website or customer service channels. This could be due to a lack of clear cancellation policies, technical issues with the website's order management system, or unresponsive customer service.", 'Closed', 11, 7, 1, '2023-04-23 01:50:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) 
VALUES (20, "Account deletion requests", "When a user requests to have their account deleted but is having trouble doing so. This could be due to unclear account deletion policies, technical issues with the website's account management system, or unresponsive customer service.", 'Open', 12, 5, 1, '2022-01-05 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) 
VALUES (21, "Issues using website with mobile data", "When I am connected to mobile data my connection to the website takes considerably longer.", 'Open', 15, NULL, NULL, '2022-01-05 12:00:00');
INSERT INTO Ticket (TicketID, Title, Description, Status, ClientID, AgentID, DepartmentID, Date) 
VALUES (22, "Ticket full of images", "This ticket's content isn't really important. I just want to test the css in cases where the ticket has a lot of images. Hope it works OK!", 'Open', 15, NULL, 3, '1999-01-05 06:20:33');

-- Populating Ticket_Tag table
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (1, 1);
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (1, 2);
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (1, 3);
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (2, 2);
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (3, 1);
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (4, 3);
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (5, 4);
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (21, 2);
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (21, 3);
INSERT INTO Ticket_Tag (TicketID, TagID) VALUES (21, 4);

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
INSERT INTO Ticket_Document (TicketID, Path) VALUES (22, 'docs/tickets-docs/CNV000009.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (22, 'docs/tickets-docs/CNV000010.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (22, 'docs/tickets-docs/CNV000011.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (22, 'docs/tickets-docs/CNV000020.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (22, 'docs/tickets-docs/CNV000023.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (22, 'docs/tickets-docs/CNV000025.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (22, 'docs/tickets-docs/CNV000030.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (22, 'docs/tickets-docs/CNV000031.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (22, 'docs/tickets-docs/CNV000032.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (22, 'docs/tickets-docs/CNV000033.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (22, 'docs/tickets-docs/CNV000035.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (22, 'docs/tickets-docs/CNV000036.JPG');
INSERT INTO Ticket_Document (TicketID, Path) VALUES (22, 'docs/tickets-docs/CNV000037.JPG');

-- Populating Ticket_Comment table
INSERT INTO Ticket_Comment (CommentID, TicketID, ClientID, Comment, Date) 
VALUES (1, 1, 3, "Thanks for submitting this ticket! We'll get back to you as soon as possible.", '2022-06-22 15:12:30');
INSERT INTO Ticket_Comment (CommentID, TicketID, ClientID, Comment, Date) 
VALUES (2, 1, 3, "Just checking in to let you know we're still working on this issue.", '2022-06-23 10:23:45');
INSERT INTO Ticket_Comment (CommentID, TicketID, ClientID, Comment, Date) 
VALUES (3, 1, 3, "We're making progress on resolving this issue. Hang tight!", '2022-06-23 18:40:21');
INSERT INTO Ticket_Comment (CommentID, TicketID, ClientID, Comment, Date) 
VALUES (4, 1, 3, "We've identified the problem and are working on a fix. Thanks for your patience.", '2022-06-25 18:56:02');
INSERT INTO Ticket_Comment (CommentID, TicketID, ClientID, Comment, Date) 
VALUES (5, 1, 5, "I'm assigning this ticket to myself and will take ownership of resolving it.", '2022-06-26 11:34:56');
INSERT INTO Ticket_Comment (CommentID, TicketID, ClientID, Comment, Date) 
VALUES (22, 1, 5, "The problem you alerted was fixed! Thanks for the cooperation.", '2022-06-30 14:00:56');
INSERT INTO Ticket_Comment (CommentID, TicketID, ClientID, Comment, Date) 
VALUES (6, 2, 4, "Thanks for reaching out about this issue. We'll investigate and get back to you soon.", '2023-02-04 22:01:10');
INSERT INTO Ticket_Comment (CommentID, TicketID, ClientID, Comment, Date) 
VALUES (7, 3, 6, "I'm escalating this ticket to a higher level of support. We'll keep you updated.", '2022-12-25 05:30:00');
INSERT INTO Ticket_Comment (CommentID, TicketID, ClientID, Comment, Date) 
VALUES (8, 4, 7, "We're investigating the issue and will update you as soon as we have more information.", '2022-08-11 14:45:30');
INSERT INTO Ticket_Comment (CommentID, TicketID, ClientID, Comment, Date) 
VALUES (9, 5, 3, "Thanks for submitting this ticket. We'll look into the issue and get back to you soon.", '2021-06-05 19:20:15');
INSERT INTO Ticket_Comment (CommentID, TicketID, ClientID, Comment, Date) 
VALUES (10, 7, 4, "I'm taking ownership of this ticket and will work on resolving the issue.", '2023-01-18 07:10:05');
INSERT INTO Ticket_Comment (CommentID, TicketID, ClientID, Comment, Date) 
VALUES (11, 7, 5, "Thanks for letting me know about this issue. I'll work with my colleague to resolve it.", '2023-02-01 16:42:20');
INSERT INTO Ticket_Comment (CommentID, TicketID, ClientID, Comment, Date) 
VALUES (12, 8, 7, "We're investigating the issue and will update you as soon as we have more information.", '2023-03-01 12:15:45');
INSERT INTO Ticket_Comment (CommentID, TicketID, ClientID, Comment, Date) 
VALUES (13, 10, 6, 'I have reviewed the details of this ticket and have escalated it to the development team for further investigation.', '2022-07-10 21:59:30');
INSERT INTO Ticket_Comment (CommentID, TicketID, ClientID, Comment, Date) 
VALUES (14, 10, 6, 'The development team has completed their investigation and a fix for the issue has been implemented. Please let us know if you continue to experience any problems.', '2023-01-31 23:59:59');
INSERT INTO Ticket_Comment (CommentID, TicketID, ClientID, Comment, Date) 
VALUES (15, 11, 4, 'Thank you for submitting this ticket. Our support team will review it and provide an update as soon as possible.', '2021-08-27 09:30:00');
INSERT INTO Ticket_Comment (CommentID, TicketID, ClientID, Comment, Date) 
VALUES (16, 12, 3, 'I have reviewed the details of this ticket and have assigned it to our senior support specialist for further assistance.', '2023-02-11 17:05:10');
INSERT INTO Ticket_Comment (CommentID, TicketID, ClientID, Comment, Date) 
VALUES (17, 12, 3, 'Our senior support specialist has reviewed the issue and is working on a resolution. We will keep you updated on the progress.', '2023-01-03 06:45:15');
INSERT INTO Ticket_Comment (CommentID, TicketID, ClientID, Comment, Date) 
VALUES (18, 16, 7, 'Thank you for contacting us. Our support team will review your ticket and provide an update as soon as possible.', '2023-05-14 14:30:20');
INSERT INTO Ticket_Comment (CommentID, TicketID, ClientID, Comment, Date) 
VALUES (19, 16, 7, 'We have investigated the issue and determined that a fix is required. Our development team is working on a resolution and we will update you as soon as possible.', '2022-12-19 10:18:00');
INSERT INTO Ticket_Comment (CommentID, TicketID, ClientID, Comment, Date) 
VALUES (20, 17, 7, 'Thank you for submitting your ticket. Our support team will review it and provide an update as soon as possible.', '2022-07-28 20:50:30');
INSERT INTO Ticket_Comment (CommentID, TicketID, ClientID, Comment, Date) 
VALUES (21, 18, 7, 'Thank you for contacting us. Our support team will review your ticket and provide an update as soon as possible.', '2019-12-20 04:00:00');

-- Populating Ticket_Update table
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (1, 1, 'Status', 'Ticket marked as closed', '2022-05-14 10:30:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (27, 1, 'Status', 'Ticket marked as in progress', '2022-06-25 18:56:52');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (28, 1, 'Status', 'Ticket marked as closed', '2022-06-30 14:01:23');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (2, 1, 'Assignee', 'Ticket assigned to John Doe', '2022-06-26 11:34:56');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (3, 2, 'Status', 'Ticket marked as in progress', '2023-05-13 15:45:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (4, 2, 'Assignee', 'Ticket assigned to Jane Smith', '2023-05-14 09:30:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (5, 3, 'Department', 'Ticket transferred to Billing department', '2023-05-10 11:15:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (6, 4, 'Assignee', 'Ticket assigned to Bob Johnson', '2023-05-14 16:30:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (7, 4, 'Status', 'Ticket marked as closed', '2023-05-14 10:00:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (8, 5, 'Department', 'Ticket transferred to IT department', '2023-05-05 09:00:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (9, 6, 'Assignee', 'Ticket assigned to Sarah Lee', '2023-04-16 14:30:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (10, 6, 'Status', 'Ticket marked as in progress', '2023-04-18 11:00:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (11, 7, 'Department', 'Ticket transferred to HR department', '2019-05-17 13:15:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (12, 8, 'Assignee', 'Ticket assigned to Mark Davis', '2023-05-14 09:30:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (13, 9, 'Status', 'Ticket marked as closed', '2023-05-15 00:23:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (14, 10, 'Assignee', 'Ticket assigned to David Chen', '2023-05-10 11:30:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (15, 10, 'Status', 'Ticket marked as in progress', '2023-05-11 09:45:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (16, 11, 'Department', 'Ticket transferred to Finance department', '2023-05-14 14:00:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (17, 12, 'Status', 'Ticket status changed to In Progress', '2023-04-23 10:30:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (18, 12, 'Assignee', 'Ticket assigned to John Doe', '2023-04-24 09:45:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (19, 13, 'Status', 'Ticket status changed to In Progress', '2023-04-25 11:00:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (20, 13, 'Assignee', 'Ticket assigned to Jane Smith', '2023-04-25 12:30:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (21, 13, 'Status', 'Ticket status changed to Closed', '2023-04-27 14:00:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (22, 14, 'Status', 'Ticket status changed to Open', '2023-04-28 16:15:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (23, 14, 'Department', 'Ticket moved to IT department', '2023-04-28 17:30:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (24, 15, 'Assignee', 'Ticket assigned to John Doe', '2023-04-30 09:00:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (25, 15, 'Status', 'Ticket status changed to In Progress', '2023-05-01 11:15:00');
INSERT INTO Ticket_Update (UpdateID, TicketID, Type, Message, Date) 
VALUES (26, 15, 'Status', 'Ticket status changed to Closed', '2023-05-03 14:30:00');

-- Populating FAQ table
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I reset my password?', 'You can reset your password by clicking on the "forgot password" link on the login page.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What do I do if I forget my username?', 'If you forget your username, please contact our support team for assistance.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I update my billing information?', 'You can update your billing information by going to your account settings and selecting "billing."');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What are the system requirements for your software?', 'The system requirements for our software can be found on our website.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I cancel my subscription?', 'You can cancel your subscription by going to your account settings and selecting "subscriptions."');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What should I do if I am having trouble accessing my account?', 'If you are having trouble accessing your account, please contact our support team for assistance.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I install your software?', 'Instructions for installing our software can be found on our website.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What do I do if I encounter an error message?', 'If you encounter an error message, please take a screenshot and send it to our support team for assistance.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I request a refund?', 'You can request a refund by contacting our support team.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What should I do if I have a question about your product?', 'If you have a question about our product, please contact our support team for assistance.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I upgrade my subscription?', 'You can upgrade your subscription by going to your account settings and selecting "subscriptions."');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What do I do if I have a suggestion for your product?', 'If you have a suggestion for our product, please contact our support team.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I report a bug?', 'You can report a bug by contacting our support team and providing details about the issue.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What do I do if I am having trouble with a feature?', 'If you are having trouble with a feature, please contact our support team for assistance.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I change my account information?', 'You can change your account information by going to your account settings and selecting "account."');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What are the accepted payment methods?', 'The accepted payment methods can be found on our website.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What do I do if I am having trouble with the mobile app?', 'If you are having trouble with the mobile app, please contact our support team for assistance.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I change my password?', 'You can change your password by going to your account settings and selecting "security."');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What do I do if I am not receiving emails from your company?', 'If you are not receiving emails from our company, please check your spam folder and contact our support team for assistance.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I download an invoice for my subscription?', 'You can download an invoice for your subscription by going to your account settings and selecting "invoices."');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What do I do if I need technical support?', 'If you need technical support, please contact our support team for assistance.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I downgrade my subscription?', 'You can downgrade your subscription by going to your account settings and selecting "subscriptions."');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What do I do if I need help with the checkout process?', 'If you need help with the checkout process, please contact our support team for assistance.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I check my account balance?', 'You can check your account balance by going to your account settings and selecting "balance."');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What do I do if I am not satisfied with the product?', 'If you are not satisfied with the product, please contact our support team for assistance.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I delete my account?', 'You can delete your account by going to your account settings and selecting "delete account."');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What do I do if I need to change my payment method?', 'If you need to change your payment method, please contact our support team for assistance.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I view my transaction history?', 'You can view your transaction history by going to your account settings and selecting "transactions."');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What do I do if I need help setting up my account?', 'If you need help setting up your account, please contact our support team for assistance.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I enable two-factor authentication?', 'You can enable two-factor authentication by going to your account settings and selecting "security."');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What do I do if I need to change the email associated with my account?', 'If you need to change the email associated with your account, please contact our support team for assistance.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What is your company''s privacy policy?', 'Our company''s privacy policy can be found on our website.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What forms of payment do you accept?', 'We accept all major credit cards and PayPal.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What should I do if I have a complaint?', 'If you have a complaint, please contact our support team and we will do our best to address the issue.');    
INSERT INTO FAQ (Question, Answer) 
VALUES ('How can I access my account from multiple devices?', 'You can access your account from multiple devices by logging in with your username and password.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What is your privacy policy?', 'Our privacy policy can be found on our website.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I update my email preferences?', 'You can update your email preferences by going to your account settings and selecting "notifications."');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What do I do if I am experiencing slow performance?', 'If you are experiencing slow performance, please contact our support team for assistance.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I customize my account?', 'You can customize your account by going to your account settings and selecting "profile."');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What is your customer support availability?', 'Our customer support is available 24/7 via email and phone.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I access my billing history?', 'You can access your billing history by going to your account settings and selecting "invoices."');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What is your refund policy?', 'Our refund policy can be found on our website.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I change my payment plan?', 'You can change your payment plan by going to your account settings and selecting "subscriptions."');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What do I do if I am having trouble with the website?', 'If you are having trouble with the website, please clear your cache and cookies or contact our support team for assistance.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I contact your sales team?', 'You can contact our sales team by going to our website and clicking "Contact Sales."');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What do I do if I am having trouble with the mobile app?', 'If you are having trouble with the mobile app, please contact our support team for assistance.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I share my account with others?', 'You can share your account with others by creating sub-accounts or by giving them your login credentials.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What is your security policy?', 'Our security policy can be found on our website.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I activate my account?', 'Your account should be activated automatically upon registration. If you are having trouble, please contact our support team for assistance.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I download your mobile app?', 'You can download our mobile app from the App Store or Google Play Store.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What is your company mission?', 'Our company mission is to provide the best possible service to our customers.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I update my company information?', 'You can update your company information by going to your account settings and selecting "company profile."');
INSERT INTO FAQ (Question, Answer) 
VALUES ('What do I do if I am not receiving push notifications?', 'If you are not receiving push notifications, please check your settings or contact our support team for assistance.');
INSERT INTO FAQ (Question, Answer) 
VALUES ('How do I change the language settings?', 'You can change the language settings by going to your account settings and selecting "language."');    
