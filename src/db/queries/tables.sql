CREATE TABLE IF NOT EXISTS Course(
    CourseID varchar(2),
    CourseName varchar(40) NOT NULL,
    PRIMARY KEY(CourseID)
);

CREATE TABLE IF NOT EXISTS Branch(
    BranchID varchar(3),
    BranchName varchar(50) NOT NULL,
    PRIMARY KEY(BranchID)
);

CREATE TABLE IF NOT EXISTS BranchToCourse(
    BCID varchar(5),
    BranchID varchar(3) NOT NULL,
    CourseID varchar(2) NOT NULL,
    Capacity tinyint UNSIGNED NOT NULL DEFAULT 0,
    Duration tinyint UNSIGNED NOT NULL DEFAULT 4,
    CONSTRAINT fk_cb_cid FOREIGN KEY(CourseID) REFERENCES Course(CourseID),
    CONSTRAINT fk_cb_bid FOREIGN KEY(BranchID) REFERENCES Branch(BranchID),
    PRIMARY KEY(BCID)
);

-- generate a new BCID by concatenating
-- BranchID and CourseID each time a new row in inserted into BranchToCourse table
CREATE TRIGGER gen_cbid BEFORE INSERT ON BranchToCourse FOR EACH ROW
SET
  NEW.BCID = CONCAT(NEW.BranchID, NEW.CourseID);

CREATE TABLE IF NOT EXISTS Student(
    StudentID varchar(11) NOT NULL,
    Name varchar(30) NOT NULL,
    DOB date NOT NULL,
    Address varchar(40) NOT NULL,
    PhoneNo varchar(10) NOT NULL,
    BCID varchar(5) NOT NULL,
    YOA year NOT NULL DEFAULT(YEAR(CURDATE())),
    CONSTRAINT fk_st_cbid FOREIGN KEY(BCID) REFERENCES BranchToCourse(BCID),
    PRIMARY KEY(StudentID)
);

CREATE TABLE IF NOT EXISTS Paper(
    PaperCode varchar(9) NOT NULL,
    PaperName varchar(20) NOT NULL,
    Type char NOT NULL,
    BCID tinyint UNSIGNED NOT NULL,
    Semester tinyint UNSIGNED NOT NULL,
    Credit tinyint UNSIGNED NOT NULL,
    CONSTRAINT fk_pa_cbid FOREIGN KEY(BCID) REFERENCES BranchToCourse(BCID),
    PRIMARY KEY(PaperCode)
);

CREATE TABLE IF NOT EXISTS StudentScore(
    StudentID varchar(11) NOT NULL,
    PaperCode varchar(9) NOT NULL,
    AppearingYear year NOT NULL,
    ESE decimal(4,2) UNSIGNED NOT NULL,
    CE decimal(4,2) UNSIGNED NOT NULL,
    Grade varchar(2) NOT NULL,
    CONSTRAINT fk_ss_stid FOREIGN KEY(StudentID) REFERENCES Student(StudentID),
    CONSTRAINT fk_ss_paid FOREIGN KEY(PaperCode) REFERENCES Paper(PaperCode)
);
