/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/SQLTemplate.sql to edit this template
 */
/**
 * Author:  linaalharbi
 * Created: Feb 25, 2024
 */


CREATE TABLE Designer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    emailAddress VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    brandName VARCHAR(100) NOT NULL,
    logoImgFileName VARCHAR(255) NOT NULL
);

CREATE TABLE DesignerSpeciality (
    designerID INT,
    designCategoryID INT,
    FOREIGN KEY (designerID) REFERENCES Designer(id),
    FOREIGN KEY (designCategoryID) REFERENCES DesignCategory(id)
);

CREATE TABLE Client (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    emailAddress VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL
);

CREATE TABLE DesignPortfolioProject (
    id INT AUTO_INCREMENT PRIMARY KEY,
    designerID INT,
    projectName VARCHAR(100) NOT NULL,
    projectImgFileName VARCHAR(255) NOT NULL,
    description TEXT,
    designCategoryID INT,
    FOREIGN KEY (designerID) REFERENCES Designer(id),
    FOREIGN KEY (designCategoryID) REFERENCES DesignCategory(id)
);

CREATE TABLE DesignConsultationRequest (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clientID INT,
    designerID INT,
    roomTypeID INT,
    designCategoryID INT,
    roomWidth DECIMAL(10, 2) NOT NULL,
    roomLength DECIMAL(10, 2) NOT NULL,
    colorPreferences VARCHAR(100),
    date DATE NOT NULL,
    statusID INT,
    FOREIGN KEY (clientID) REFERENCES Client(id),
    FOREIGN KEY (designerID) REFERENCES Designer(id),
    FOREIGN KEY (roomTypeID) REFERENCES RoomType(id),
    FOREIGN KEY (designCategoryID) REFERENCES DesignCategory(id),
    FOREIGN KEY (statusID) REFERENCES RequestStatus(id)
);

CREATE TABLE DesignConsultation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    requestID INT,
    consultation TEXT,
    consultationImgFileName VARCHAR(255),
    FOREIGN KEY (requestID) REFERENCES DesignConsultationRequest(id)
);

CREATE TABLE DesignCategory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(100) NOT NULL
);

CREATE TABLE RoomType (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(100) NOT NULL
);

CREATE TABLE RequestStatus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    status VARCHAR(100) NOT NULL
);

-- Add sample data
INSERT INTO Designer (firstName, lastName, emailAddress, password, brandName, logoImgFileName)
VALUES
    ('John', 'Doe', 'john@example.com', 'password', 'JD Designs', 'logo1.png'),
    ('Jane', 'Smith', 'jane@example.com', 'password', 'JS Interiors', 'logo2.png'),
    ('Michael', 'Johnson', 'michael@example.com', 'password', 'MJ Studios', 'logo3.png');

INSERT INTO DesignerSpeciality (designerID, designCategoryID)
VALUES
    (1, 1),
    (2, 2),
    (3, 3);

INSERT INTO Client (firstName, lastName, emailAddress, password)
VALUES
    ('Alice', 'Brown', 'alice@example.com', 'password'),
    ('Bob', 'White', 'bob@example.com', 'password'),
    ('Carol', 'Green', 'carol@example.com', 'password');

INSERT INTO DesignPortfolioProject (designerID, projectName, projectImgFileName, description, designCategoryID)
VALUES
    (1, 'Living Room Redesign', 'project1.jpg', 'Description for project 1', 1),
    (2, 'Bedroom Renovation', 'project2.jpg', 'Description for project 2', 2),
    (3, 'Kitchen Makeover', 'project3.jpg', 'Description for project 3', 3);

INSERT INTO DesignConsultationRequest (clientID, designerID, roomTypeID, designCategoryID, roomWidth, roomLength, colorPreferences, date, statusID)
VALUES
    (1, 1, 1, 1, 4.5, 5.5, 'Beige', '2024-09-02', 1),
    (2, 2, 2, 2, 6.2, 4.8, 'Blue', '2024-09-03', 1),
    (3, 3, 3, 3, 3.9, 7.1, 'Green', '2024-09-04', 1);

INSERT INTO DesignConsultation (requestID, consultation, consultationImgFileName)
VALUES
    (1, 'Consultation details for request 1', 'consultation1.jpg'),
    (2, 'Consultation details for request 2', 'consultation2.jpg'),
    (3, 'Consultation details for request 3', 'consultation3.jpg');

INSERT INTO DesignCategory (category)
VALUES
    ('Modern'),
    ('Country'),
    ('Coastal');

INSERT INTO RoomType (type)
VALUES
    ('Living Room'),
    ('Bedroom'),
    ('Kitchen');

INSERT INTO RequestStatus (status)
VALUES
    ('Pending Consultation'),
    ('Consultation Declined'),
    ('Consultation Provided');
