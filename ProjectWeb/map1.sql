create table IF NOT EXISTS product (
productid int(11),
title varchar(100),
category varchar(100),
description varchar(2000) 
);
INSERT INTO `product`(`productid`, `title`, `category`, `description`) 
VALUES (NULL,'iMac','Desktop','With its enhanced, big and beautiful display, the new Apple iMac M-D093-B/A 21.5 Desktop Computer renders your movies, photos, web pages and other graphics in truly jaw-dropping detail.'),
VALUES (NULL,'iMac','Desktop','With its enhanced, big and beautiful display, the new Apple iMac M-D093-B/A 21.5 Desktop Computer renders your movies, photos, web pages and other graphics in truly jaw-dropping detail.');