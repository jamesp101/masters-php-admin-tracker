USE ctr_db;


ALTER table personsqr_tbl
Drop Column MobileNumber;


ALTER TABLE personsqr_tbl
ADD MobileNumber text,
ADD status text,
ADD dateUpdated datetime;



CREATE TABLE history (
    id INTEGER PRIMARY KEY AUTO_INCREMENT  NOT NULL,
    user_id TEXT,
    status TEXT,
    date_updated datetime
)
