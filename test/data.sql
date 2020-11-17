-- Mock Data for logining

INSERT INTO roles (access_level, role_name)
VALUES (1, 'Admin'),
       (2, 'Supervisor'),
       (3, 'Doctor'),
       (4, 'Caregiver'),
       (5, 'Patient'),
       (6, 'Family_member');

INSERT INTO users (Fname, Lname, Role_id, email, phone, Birth_date, password, approved)
VALUES ('Thomas', 'Smith', 1, 'example@gmail.com', '(717)-345-3455', '1988-01-07', 'qwerty', true),
       ('Brendan', 'Horst', 2, 'qwerty@gmail.com', '(717)-223-2325', '1999-03-19', 'password', true),
       ('Walter', 'Moore', 3, 'walter@yahoo.com', '(616)-232-9844', '1978-01-04', 'monday1', true),
       ('Joe', 'Pekarek', 3, 'pushupguy@gmail.com', '(443)-224-2398', '1993-03-22', 'nowayjose', true),
       ('Bob', 'Jerry', 4, 'jerry@aol.com', '(612)-347-9879', '1996-03-11', 'whatyousaid', true),
       ('Benhat', 'Mahala', 4, 'mahala@gmail.com', '(717)-233-9889', '1993-04-03', 'whathesaid', true),
       ('Cammy', 'Price', 4, 'cameron@aol.com', '(616)-233-9889', '1999-07-17', 'whatshesaid', true),
       ('Brian', 'dogood', 4, 'dogood@yahoo.com', '(612)-273-3289', '1994-12-11', 'whatitsaid', true),
       ('Arafat', 'Hassan', 5, 'hassan@gmail.com', '(717)-347-2222', '1968-05-25', 'aswdf6', true),
       ('Sam', 'Hassan', 6, 'sam@gmail.com', '(717)-355-2312', '1988-02-11', 'cooldude', true),
       ('bob', 'Hassan', 6, 'bob@gmail.com', '(717)-355-2312', '1988-02-11', 'okaybro', false);

INSERT INTO patients_info (user_id, family_code, emergency_contact, Relation_Contact, admission_date, patient_group, balance_due)
VALUES (5, '123456', 'Same Hassan', 'son', '2020-11-06', 1, 1000)
