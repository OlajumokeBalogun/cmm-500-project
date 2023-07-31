CREATE TABLE Patient (
 Patient_Id int(20)Auto_Increment PRIMARY KEY,
Firstname varchar(40) DEFAULT NULL,
    Middlename varchar(40) DEFAULT NULL,
     Lastname varchar(40) DEFAULT NULL,
dob date DEFAULT NULL,
  age int DEFAULT NULL,
 email varchar(200) DEFAULT NULL,
 bloodgroup varchar(10) DEFAULT NULL,
  weight varchar(20) DEFAULT NULL,
   height varchar(20) DEFAULT NULL,
   address varchar(200) DEFAULT NULL,
    gender varchar(10) DEFAULT NULL,
    Date_joined  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   Actions varchar(10)  NULL
) ;

CREATE TABLE Staff (
 Staff_Id int(20)Auto_Increment PRIMARY KEY,
 Staff_Firstname varchar(40)  NULL,
     Staff_Middlename varchar(40) NULL,
      Staff_Lastname varchar(40)  NULL,
  Staff_dob date  NULL,
 Staff_email varchar(200) NULL,
    Staff_role varchar(20)NULL,
 `password` varchar(200)   NOT NULL,
    Staff_gender varchar(10) NOT NULL,
    `otp` varchar(6) DEFAULT NULL,
  `otp_expiration` datetime DEFAULT NULL,
    Staff_joined  datetime NOT NULL DEFAULT current_timestamp(),
   Actions varchar(10) NULL
) ;


CREATE TABLE Test (
 Test_id int(20) Auto_Increment PRIMARY KEY,
   Patient_Id int(20)   NULL,
   Staff_Id int(20)  NULL,
  Test_name text,
Test_results text,
 Test_date timestamp  NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 Actions varchar(10) NULL,
 FOREIGN KEY(Patient_Id) REFERENCES Patient(Patient_Id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY(Staff_Id) REFERENCES Staff(Staff_Id) ON DELETE CASCADE ON UPDATE CASCADE
) ;

CREATE TABLE Billing (
 Billing_id int(20) Auto_Increment PRIMARY KEY,
   Patient_Id int(20)  DEFAULT NULL,
   Amount int DEFAULT NULL,
  Payment_mode text,
  Payment_status varchar(10) DEFAULT NULL,
 Billing_date timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 Actions varchar(10)  NULL,
 FOREIGN KEY(Patient_Id) REFERENCES Patient(Patient_Id) ON DELETE CASCADE ON UPDATE CASCADE
) ;

CREATE TABLE Drug(
Drug_id int(20) Auto_Increment PRIMARY KEY,
 Drug_name text,
 Actions varchar(10)  NULL
) ;

CREATE TABLE Prescription (
Prescription_id int(20) Auto_Increment PRIMARY KEY,
   Patient_Id int(20)  DEFAULT NULL,
   Staff_Id int(20) DEFAULT NULL,
   Drug_Id int(20) DEFAULT NULL,
  Doctor_note text,
 Prescription_date timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 Actions varchar(10) NULL,
 FOREIGN KEY(Patient_Id) REFERENCES Patient(Patient_Id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY(Staff_Id) REFERENCES Staff(Staff_Id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY(Drug_Id) REFERENCES Drug(Drug_Id) ON DELETE CASCADE ON UPDATE CASCADE
) ;

CREATE TABLE Appointment (
Appointment_id int(20) Auto_Increment PRIMARY KEY,
   Patient_Id int(20)  DEFAULT NULL,
   Staff_Id int(20) DEFAULT NULL,
 Appointment_date date NULL ,
 Appointment_time time NULL,
 Actions varchar(10)  NULL,
 FOREIGN KEY(Patient_Id) REFERENCES Patient(Patient_Id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY(Staff_Id) REFERENCES Staff(Staff_Id) ON DELETE CASCADE ON UPDATE CASCADE
) ;