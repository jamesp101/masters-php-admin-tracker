USE ctr_db;


ALTER table personsqr_tbl
Drop Column MobileNumber;


ALTER TABLE personsqr_tbl
ADD MobileNumber text,
ADD status text,
ADD dateUpdated datetime;
