--
-- Table structure for table `categories_db`
--

CREATE TABLE `categories_db` (
  `id` int(6) unsigned NOT NULL auto_increment,
  `name` varchar(32) collate utf8_unicode_ci NOT NULL,
  `contains` int(6) NOT NULL,
  PRIMARY KEY  (`id`)
);


--
-- Table sturcture of diner_db the diner databse
--

CREATE TABLE diner_db (
  id INT(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL, 
  location INT(4));

--------------------------------------------------------------------
--------------------------------------------------------------------
--
-- Table Structure for cuisine_db , the menu database
--

Menu Database - cuisine_db
CREATE TABLE cuisine_db (
  id INT(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  diner_id INT(3) NOT NULL,
    FOREIGN KEY (diner_id) REFERENCES diner_db(id),
  name VARCHAR (50) NOT NULL,
  price FLOAT(4,2) NOT NULL,
  category int(6) NOT NULL,
  description VARCHAR (300),
  option_vegi BOOL ,
  option_light BOOL ,
  option_hot BOOL 
);

--------------------------------------------------------------------

--
-- Table structure for user_db, the user database
--


CREATE TABLE user_db (
  id INT(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  email VARCHAR(50) NOT NULL,
  password VARCHAR(50) NOT NULL,
  gender VARCHAR(10) ,
  fname VARCHAR(30) NOT NULL,
  lname VARCHAR(30) NOT NULL,
  join_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--
--Insert Query example
--
 INSERT INTO user_db
 (email,password,gender,fname,lname) 
 VALUES ('admin','admin','Male','Zhou','Jacob'); 

--------------------------------------------------------------------



--
--Rating Database - rating———for collaborative filtering
--

CREATE TABLE rating_db(user_id INT(3)  
  NOT NULL,FOREIGN KEY (user_id) REFERENCES user_db(id),cuisine_id INT(3) NOT NULL,
  FOREIGN KEY (cuisine_id) REFERENCES cuisine_db(id),rating INT NOT NULL,
  date_stamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (user_id ,cuisine_id)); 

    CREATE TABLE IF NOT EXISTS `rating_db` (
      `user_id` int(3) NOT NULL,FOREIGN KEY (uc_users) REFERENCES user_db(id),
      `cuisine_id` int(3) NOT NULL,FOREIGN KEY (cuisine_id) REFERENCES cuisine_db(id),
      `rating` decimal(11,2) NOT NULL default '0.00',
      KEY `item_id` (`cuisine_id`),
      KEY `user_id` (`user_id`,`cuisine_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8; 

--    
--Insert Query Example:
--
 INSERT INTO rating (user_id,cuisine_id,rating) values (2,55,4); 

--------------------------------------------------------------------

--
--Visit Record - visit_db
--

CREATE TABLE visit_db (
  id INT(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
  user_id INT(3) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user_db(id),
<<<<<<< HEAD
=======
  diner_id INT(3) NOT NULL,
    FOREIGN KEY (diner_id) REFERENCES diner_db(id),
>>>>>>> FETCH_HEAD
  cuisine_id INT(3) NOT NULL,
    FOREIGN KEY (cuisine_id) REFERENCES cuisine_db(id)
); 


<<<<<<< HEAD
CREATE TABLE history_db (
  visit_id INT(3) NOT NULL PRIMARY KEY,
    FOREIGN KEY (visit_id) REFERENCES visit_db(id),
  user_id int(3) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user_db(id),
  cuisine_id INT(3) NOT NULL,
    FOREIGN KEY (cuisine_id) REFERENCES cuisine_db(id)
  date TIMESTAMP de
);
=======
>>>>>>> FETCH_HEAD

--------------------------------------------------------------------

--
--Develop database - dev
--

CREATE TABLE dev(itemID1 int (11) NOT NULL default ’0 ’ , itemID2 int (11) NOT NULL default ’0 ’ , count int (11) NOT NULL default ’0 ’ , sum int(11) NOT NULL default ’0’,PRIMARY KEY ( itemID1 , itemID2 ));

   CREATE TABLE IF NOT EXISTS `slope_one` (
      `item_id1` int(3) NOT NULL, FOREIGN KEY(item_id1) REFERENCES cuisine_db(id),
      `item_id2` int(3) NOT NULL, FOREIGN KEY (item_id2) REFERENCES cuisine_db(id),
      `times` int(11) NOT NULL,
      `rating` decimal(11,2) NOT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8; 
 
 --------------------------------------------------------------------