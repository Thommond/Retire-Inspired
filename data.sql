



CREATE TABLE roles (
id integer NOT NULL AUTO_INCREMENT,
access_level integer NOT NULL,
role_name varchar(100),
PRIMARY KEY (id)
)

CREATE TABLE user (
id integer NOT NULL AUTO_INCREMENT,
Fname varchar(100) NOT NULL,
Lname varchar(100) NOT NULL,
Role_id integer REFERENCES roles (id),
email varchar(100) NOT NULL,
phone varchar(100) NOT NULL,
Birth_date date NOT NULL,
Password varchar(100) NOT NULL,
PRIMARY KEY (id)
)

CREATE TABLE patients_info (
id integer NOT NULL AUTO_INCREMENT,
user_id integer REFERENCES user (id),
family_code integer NOT NULL UNIQUE,
emergency_contact varchar(100) NOT NULL,
Relation_Contact varchar(100) NOT NULL,
admission_date date NOT NULL,
group integer NOT NULL,
balance_due integer NOT NULL
PRIMARY KEY (id)
)
