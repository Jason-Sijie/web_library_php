# Web Library System

A web library system implemented in PHP and Apache24 interacting with MySQL database. The web interface is writen in HTML/CSS and JavaScript. The system has login, search book, card manager, administer manager, borrow and return book functions.


## Function

* login
    * check the administer's id and password in the database
    * use PHP session() to create connection
* search book
    * use without administer privilege
    * search by book's attribute
* administer manager
    * create new administer
    * search basic administer information
* card manager
    * create new card
    * search basic card user's information
* book manager
    * insert one book
    * insert books by uploading 'csv' file
    * delete book
* borrow and return book
    * store the borrowing and returning information in 'record'
    * keep the information of stock and total number

## Database Structure

### book
```
CREATE TABLE Book (    
    book_id INT PRIMARY KEY,
    book_name VARCHAR(40) NOT NULL,
    type VARCHAR(30),
    publisher VARCHAR(40),
    author VARCHAR(30),
    price FLOAT,
    year INT,
    stock INT CHECK (stock >= 0),
    total_number INT CHECK (total_number >= stock)
);
```

### manager
```
create table manager(
    manager_id int primary key,
    manager_name varchar(30) not null,
    password 	text,
    phone 	numeric(11)
);
```

### card
```
CREATE TABLE card (
    card_id INT PRIMARY KEY,
    card_name VARCHAR(30) NOT NULL,
    department VARCHAR(40),
    type VARCHAR(20)
);
```
Card's type can only be 'student' or 'teacher'. It is checked by the server not the database.

### record
```
create table record(
	card_id int not null,
    book_id int not null,
	cur_date date,
    return_date date,
	primary key (card_id, book_id),
    foreign key (card_id) references card(card_id),
    foreign key (book_id) references book(book_id)
);
```
