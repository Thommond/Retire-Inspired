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
       ('Bob', 'Jones', 5, 'jones@yahoo.com', '(313)-331-3789', '1957-06-21', 'whymommy?', true),
       ('John', 'Horton', 5, 'hort@gmail.com', '(216)-221-9090', '1948-02-13', 'whydaddy?', true),
       ('Jim', 'Smith', 5, 'Smith@gmail.com', '(717)-575-5281', '1952-04-12', 'helloisitme', true),
       ('Niomi', 'Kring', 5, 'Kring@aol.com', '(818)-442-5412', '1939-12-03', 'iamoldone', true),
       ('Smith', 'Jimmy', 5, 'jimmy@gmail.com', '(312)-400-1123', '1949-08-21', 'whatdoesthefox', true),
       ('Sam', 'Hassan', 6, 'sam@gmail.com', '(717)-355-2312', '1988-02-11', 'cooldude', true),
       ('bob', 'Hassan', 6, 'bob@gmail.com', '(717)-355-2312', '1988-02-11', 'okaybro', false);

INSERT INTO patients_info (user_id, family_code, emergency_contact, Relation_Contact, admission_date, patient_group, balance_due)
VALUES (9, '123456', 'Same Hassan', 'son', '2020-11-06', 1, 1000);

INSERT INTO appointments (patient_id, doctor_id, day)
VALUES (9, 3, '2020-11-19'),
       (9, 3, '2020-11-17'),
       (9, 3, '2020-10-10'),
       (10, 3, '2020-11-19'),
       (11, 3, '2020-11-07'),
       (11, 4, '2020-11-20'),
       (11, 4, '2020-11-13'),
       (12, 4, '2020-11-20'),
       (13, 3, '2020-11-01'),
       (13, 4, '2020-10-28'),
       (14, 3, '2020-10-27'),
       (14, 4, '2020-12-01'),
       (14, 3, '2020-12-03');

INSERT INTO prescriptions (patient_id, appt_day, `comment`, morning_med, afternoon_med, night_med)
VALUES (9, '2020-11-19', 'Great patient', 'Vicodin', 'Asprin', 'Vicodin'),
       (9, '2020-10-10', 'Great again', 'Asprin', 'Vicodin', 'Asprin'),
       (10, '2020-11-19', 'Horrible patient', 'Vodka', 'Vodka', 'Vodka'),
       (11, '2020-11-07', 'He is okay', 'Asprin', 'Asprin', 'Asprin'),
       (11, '2020-11-20', 'Placebo he is fine', 'Placebo', 'Placebo', 'Placebo'),
       (11, '2020-11-13', 'Okay, not cool', 'Oxicotin', 'Oxicotin', 'Oxicotin'),
       (12, '2020-11-20', 'Not so good', 'Dremamine', 'Dremamine', 'Dremamine'),
       (12, '2020-11-23', 'Same deal', 'Dremamine', 'Dremamine', 'Dremamine'),
       (13, '2020-11-01', 'Okay he is fine', 'Placebo', 'Asprin', 'Placebo'),
       (13, '2020-10-28', 'Still fine', 'Asprin', 'Placebo', 'Asprin'),
       (14, '2020-10-27', 'Eh', NULL, NULL, NULL),
       (14, '2020-12-01', 'Okay he needs milk', 'Milk', 'Milk', 'Milk'),
       (14, '2020-12-03', 'Wow, he needs asprin', 'Asprin', 'Asprin', 'Asprin');


INSERT INTO rosters (day, supervisor, doctor, caretaker_1, caretaker_2, caretaker_3, caretaker_4)
VALUES ('2020-11-19', 2, 3, 5, 6, 7, 8)
       ('2020-11-17', 2, 3, 5, 6, 7, 8),
       ('2020-10-10', 2, 3, 8, 7, 6, 5),
       ('2020-11-07', 2, 3, 7, 6, 5, 8),
       ('2020-11-20', 2, 4, 8, 6, 7, 5),
       ('2020-11-13', 2, 4, 8, 7, 6, 5),
       ('2020-11-01', 2, 3, 8, 7, 6, 5),
       ('2020-10-28', 2, 4, 7, 8, 5, 6),
       ('2020-10-27', 2, 3, 5, 8, 6, 7),
       ('2020-12-01', 2, 4, 5, 8, 7, 6),
       ('2020-12-03', 2, 3, 8, 5, 7, 6);
