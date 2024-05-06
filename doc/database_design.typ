= Laboratory Assignment 7

== #pad(bottom: 5pt, [Group 1 (DB6)])

#[
    #set text(size: 12.5pt)
    Amlanjyoti Lahkar(01), Chinmoy Saikia(07), Himajyoti Deka(14), Tiniba Mazumdar(30)
]

#pad(y:10pt, line(length: 100%, stroke: 1pt))


#align(center, [
    == DB: Student Academic Records
    === Involving 4 Master Tables and 2 Weak Entity Tables
])

#linebreak()

#import table: cell, header

#show figure.where(
    kind: table
): set figure.caption(position: top)

#set table(
    stroke: 0.5pt + black,
    fill: (_, y) =>
        if y == 0 { luma(230) },
)

#show table: set text(8.5pt)
#figure(
    caption: [Student[M] (7 attributes)],
    gap: 1.25em,
    table(
        columns: 8,
        inset: 10pt,
        align: horizon,
        table.header(
            [],
            [*StudentID*],
            [*Name*],
            [*DOB*],
            [*Address*],
            [*PhoneNo*],
            [*BCID*],
            [*YOA*],
        ),

        [*Datatype*],
        [varchar],
        [varchar],
        [Date],
        [varchar],
        [varchar],
        [tinyint],
        [year],

        [*Size*],
        [11],
        [30],
        [],
        [40],
        [10],
        [length 5],
        [],

        [*Constraint*],
        [*PK*],
        [NOT NULL],
        [NOT NULL, UNSIGNED],
        [NOT NULL],
        [NOT NULL],
        [*FK*],
        [NOT NULL],
    ),
)

#linebreak()

#figure(
    caption: [Course[M] (2 attributes)],
    gap: 1.25em,
    table(
        columns: 3,
        inset: 10pt,
        align: horizon,
        header(
            [],
            [*CourseID*],
            [*CourseName*],
        ),

        [*Datatype*],
        [varchar],
        [varchar],

        [*Size*],
        [2],
        [40],

        [*Constraint*],
        [*PK*],
        [NOT NULL],
    ),
)


#linebreak()

#figure(
    caption: [Branch[M] (2 attributes)],
    gap: 1.25em,
    table(
        columns: 3,
        inset: 10pt,
        align: horizon,
        table.header(
            [],
            [*BranchID*],
            [*BranchName*],
        ),

        [*Datatype*],
        [varchar],
        [varchar],

        [*Size*],
        [3],
        [50],

        [*Constraint*],
        [*PK*],
        [NOT NULL],

    ),
)

#pagebreak()

#figure(
    caption: [BranchToCourse[W] (5 attributes)],
    gap: 1.25em,
    table(
        columns: 6,
        inset: 10pt,
        align: horizon,
        table.header(
            [],
            [*BCID*],
            [*BranchID*],
            [*CourseID*],
            [*Capacity*],
            [*Duration*],
        ),

        [*Datatype*],
        [tinyint],
        [varchar],
        [varchar],
        [tinyint],
        [tinyint],

        [*Size*],
        [],
        [3],
        [2],
        [(length 2)],
        [(length 1)],

        [*Constraint*],
        [*PK*],
        [*FK*],
        [*FK*],
        [NOT NULL, UNSIGNED],
        [NOT NULL, UNSIGNED]
    ),
)

#linebreak()

#figure(
    caption: [Paper[M] (6 attributes)],
    gap: 1.25em,
    table(
        columns:7,
        inset: 10pt,
        align: horizon,
        table.header(
            [],
            [*PaperCode*],
            [*PaperName*],
            [*Type*],
            [*BCID*],
            [*Semester*],
            [*Credit*],
        ),

        [*Datatype*],
        [varchar],
        [varchar],
        [char],
        [varchar],
        [tinyint],
        [tinyint],

        [*Size*],
        [9],
        [20],
        [],
        [5],
        [(length 1)],
        [(length 2)],

        [*Constraint*],
        [*PK*],
        [NOT NULL],
        [NOT NULL],
        [*FK*],
        [NOT NULL, UNSIGNED],
        [NOT NULL, UNSIGNED],
    ),
)

#linebreak()

#figure(
    caption: [StudentScore[W] (6 attributes)],
    gap: 1.25em,
    table(
        columns:7,
        inset: 10pt,
        align: horizon,
        table.header(
            [],
            [*StudentID*],
            [*PaperCode*],
            [*AppearingYear*],
            [*ESE*],
            [*CE*],
            [#underline(stroke: (thickness: 0.7pt, dash: "densely-dotted"), [*Grade*])],
        ),

        [*Datatype*],
        [varchar],
        [varchar],
        [year],
        [decimal],
        [decimal],
        [varchar],

        [*Size*],
        [11],
        [9],
        [],
        [(4,2)],
        [(4,2)],
        [2],

        [*Constraint*],
        [*FK*],
        [*FK*],
        [NOT NULL],
        [NOT NULL, UNSIGNED],
        [NOT NULL, UNSIGNED],
        [NOT NULL],
    ),
)

#pad(y:10pt, line(length: 100%, stroke: 0.2pt))

#pad(y: 3pt, [=== Unique Key Formats])

- #underline[StudentID] Format: Admission Year(4) + BCID(5) + Serial No.(2) \
    Example: 2024ETE0119 #text(rgb("#6c757d"))[(2024 year + ETE branch + B.Tech course + 19#super[th] student)]

- #underline[CourseID] Format: Course Codes(2) #text(rgb("#6c757d"))[(B.Tech = 01, M.Tech = 02, MCA = 03)]

- #underline[BranchID] Format: Branch Initials(3) \
    Example: ETE

- #underline[BCID] Format: BranchID(3) + CourseID(2) \
    Example: CA03 #text(rgb("#6c757d"))[(Computer Applications(CA) Branch + MCA course)]

- #underline[PaperCode] Format: BCID(5) + Semester(1) + Type(1) + Paper No.(2) \
    Example: ETE012P03 #text(rgb("#6c757d"))[(ETE branch + B.Tech course + 2nd Semester + Pactical + 3#super[rd] Paper)]

#pagebreak()

#show figure.caption: it => [
    Figure: #it.body
]

#figure(
    gap: 20pt,
    rect(stroke: 0.5pt + gray)[#image("assets/er_diagram02.png", height: 60%)],
    caption: [ER Diagram for the Student Academic Records Database]
)
