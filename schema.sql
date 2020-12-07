CREATE DATABASE IF NOT EXISTS  `retire`
USE `retire`;


DROP TABLE IF EXISTS roles;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS appointments;
DROP TABLE IF EXISTS prescriptions;
DROP TABLE IF EXISTS rosters;
DROP TABLE IF EXISTS schedules;
DROP TABLE IF EXISTS patients_info;



CREATE TABLE roles (
id integer NOT NULL AUTO_INCREMENT,
access_level integer NOT NULL,
role_name varchar(100),
PRIMARY KEY (id)
);

CREATE TABLE users (
  id integer NOT NULL AUTO_INCREMENT,
  Fname varchar(100) NOT NULL,
  Lname varchar(100) NOT NULL,
  Role_id integer REFERENCES roles (id),
  email varchar(100) NOT NULL UNIQUE,
  phone varchar(100) NOT NULL,
  Birth_date date NOT NULL,
  Password varchar(100) NOT NULL,
  approved boolean NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE appointments (
  id integer NOT NULL AUTO_INCREMENT,
  patient_id integer REFERENCES user (id),
  doctor_id integer REFERENCES user (id),
  day datetime NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE prescriptions (
  id integer NOT NULL AUTO_INCREMENT,
  appt_day datetime NOT NULL REFERENCES appointments (day),
  patient_id integer REFERENCES user (id),
  comment varchar(100),
  morning_med varchar(100),
  afternoon_med varchar(100),
  night_med varchar(100),
  PRIMARY KEY (id)
);

CREATE TABLE rosters (
  id integer NOT NULL AUTO_INCREMENT,
  day date NOT NULL,
  supervisor integer REFERENCES user (id),
  doctor integer REFERENCES user (id),
  caretaker_1 integer REFERENCES user (id),
  caretaker_2 integer REFERENCES user (id),
  caretaker_3 integer REFERENCES user (id),
  caretaker_4 integer REFERENCES user (id),
  PRIMARY KEY (id)
);

CREATE TABLE schedules (
  id integer NOT NULL AUTO_INCREMENT,
  user_id integer REFERENCES user (id),
  morning_med boolean,
  afternoon_med boolean,
  night_med boolean,
  day date NOT NULL,
  comment varchar(100),
  breakfast boolean,
  lunch boolean,
  dinner boolean,
  PRIMARY KEY (id)
);

CREATE TABLE patients_info (
id integer NOT NULL AUTO_INCREMENT,
user_id integer REFERENCES user (id),
family_code varchar(100) NOT NULL,
emergency_contact varchar(100) NOT NULL,
Relation_Contact varchar(100) NOT NULL,
admission_date date NOT NULL,
patient_group integer NOT NULL,
balance_due integer NOT NULL,
PRIMARY KEY (id)
);

SELECT u.Lname, u.Fname, u.id, p.patient_group, s.morning_med, s.afternoon_med, s.night_med, s.breakfast, s.lunch, s.dinner, a.day FROM users as u JOIN patients_info as p ON (u.id=p.user_id) JOIN schedules as s ON (u.id=s.user_id) JOIN appointments as a ON (u.id=a.patient_id) WHERE 0 IN (morning_med, afternoon_med, night_med, breakfast, lunch, dinner) AND s.day LIKE '2020-12-07'
