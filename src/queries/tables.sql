CREATE TABLE IF NOT EXISTS Course (
    CourseID varchar(2) NOT NULL,
    CourseName varchar(40) NOT NULL,
    PRIMARY KEY (CourseID)
);

CREATE TABLE IF NOT EXISTS Branch (
    BranchID varchar(3) NOT NULL,
    BranchName varchar(50) NOT NULL,
    PRIMARY KEY (BranchID)
);

CREATE TABLE IF NOT EXISTS CourseToBranch (
    CBID varchar(5) NOT NULL,
    CourseID varchar(2) NOT NULL,
    BranchID varchar(3) NOT NULL,
    Capacity tinyint UNSIGNED NOT NULL DEFAULT 0,
    Duration tinyint UNSIGNED NOT NULL DEFAULT 4,
    CONSTRAINT fk_cb_cid FOREIGN KEY (CourseID) REFERENCES Course (CourseID),
    CONSTRAINT fk_cb_bid FOREIGN KEY (BranchID) REFERENCES Branch (BranchID),
    PRIMARY KEY (CBID)
);

-- generate a new CBID by concatenating
-- BranchID and CourseID each time a new row in inserted into CourseToBranch table
CREATE TRIGGER gen_cbid BEFORE INSERT ON CourseToBranch FOR EACH ROW
SET
    NEW.CBID = CONCAT (NEW.BranchID, NEW.CourseID);

CREATE TABLE IF NOT EXISTS Student (
    StudentID varchar(13) NOT NULL,
    Name varchar(30) NOT NULL,
    DOB date NOT NULL,
    Address varchar(40) NOT NULL,
    PhoneNo varchar(10) NOT NULL UNIQUE,
    CBID varchar(5) NOT NULL,
    YOA YEAR NOT NULL DEFAULT (CURDATE ()),
    CONSTRAINT fk_st_cbid FOREIGN KEY (CBID) REFERENCES CourseToBranch (CBID),
    PRIMARY KEY (StudentID)
);

CREATE TABLE IF NOT EXISTS Paper (
    PaperCode varchar(9) NOT NULL,
    PaperName varchar(20) NOT NULL,
    Type char NOT NULL,
    CBID varchar(5) NOT NULL,
    Semester tinyint UNSIGNED NOT NULL,
    Credit tinyint UNSIGNED NOT NULL,
    CONSTRAINT fk_pa_cbid FOREIGN KEY (CBID) REFERENCES CourseToBranch (CBID),
    PRIMARY KEY (PaperCode)
);

CREATE TABLE IF NOT EXISTS StudentScore (
    StudentID varchar(13) NOT NULL,
    PaperCode varchar(9) NOT NULL,
    AppearingYear YEAR NOT NULL,
    ESE decimal(4, 2) UNSIGNED NOT NULL,
    CE decimal(4, 2) UNSIGNED NOT NULL,
    Grade varchar(2) NOT NULL,
    CONSTRAINT fk_ss_stid FOREIGN KEY (StudentID) REFERENCES Student (StudentID),
    CONSTRAINT fk_ss_paid FOREIGN KEY (PaperCode) REFERENCES Paper (PaperCode)
);
