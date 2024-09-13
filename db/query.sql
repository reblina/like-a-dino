CREATE TABLE comments (
    commentID INT AUTO_INCREMENT PRIMARY KEY,
    siteID VARCHAR(255),
    comment TEXT,
    username VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

select * from comments;

delete from comments where username = "yeller";

drop table comments;

select * from comments;

delete from comments where commentID = 5;

CREATE TABLE starReviews (
    reviewID INT AUTO_INCREMENT PRIMARY KEY, 
    commentID INT,                           
    siteID VARCHAR(255),
    rating INT,                              
    FOREIGN KEY (commentID) REFERENCES comments(commentID) ON DELETE SET NULL
);

create table siteRatings (
    siteID varchar(255),
    average int
);

ALTER TABLE siteRatings MODIFY COLUMN average FLOAT;

drop table siteRatings;
select * from siteRatings;
select * from starReviews;

select avg(rating) from starReviews;


use db;
select * from comments;

use db;
drop comments;

use db;
CREATE TABLE comments (
    commentID INT AUTO_INCREMENT PRIMARY KEY,
    siteID VARCHAR(255),
    comment TEXT,
    username VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);


