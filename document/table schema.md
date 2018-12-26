# Database table schema

## book
```
CREATE TABLE book (    
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

## manager
```
create table manager(
    manager_id int primary key,
    manager_name varchar(30) not null,
    password 	text,
    phone 	numeric(11)
);
```

## card
```
CREATE TABLE card (
    card_id INT PRIMARY KEY,
    card_name VARCHAR(30) NOT NULL,
    department VARCHAR(40),
    type VARCHAR(20)
);
```
Card's type can only be 'student' or 'teacher'. It is checked by the server not the database.

## record
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
There is a weird error. If the attribute name is 'current_date', then it has error 1604.