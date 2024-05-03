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
            [*CBID*],
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
        [13],
        [30],
        [10],
        [40],
        [10],
        [1],
        [4],

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
    caption: [Course[M] (3 attributes)],
    gap: 1.25em,
    table(
        columns: 4,
        inset: 10pt,
        align: horizon,
        header(
            [],
            [*CourseID*],
            [*CourseName*],
            [*Duration*],
        ),

        [*Datatype*],
        [varchar],
        [varchar],
        [tinyint],

        [*Size*],
        [3],
        [25],
        [1],

        [*Constraint*],
        [*PK*],
        [NOT NULL],
        [NOT NULL, UNSIGNED],
    ),
)


#linebreak()

#figure(
    caption: [Branch[M] (3 attributes)],
    gap: 1.25em,
    table(
        columns:4,
        inset: 10pt,
        align: horizon,
        table.header(
            [],
            [*BranchID*],
            [*BranchName*],
            [*Capacity*],
        ),

        [*Datatype*],
        [varchar],
        [varchar],
        [tinyint],

        [*Size*],
        [3],
        [20],
        [3],

        [*Constraint*],
        [*PK*],
        [NOT NULL],
        [NOT NULL, UNSIGNED],

    ),
)

#pagebreak()

#figure(
    caption: [CourseToBranch[W] (3 attributes)],
    gap: 1.25em,
    table(
        columns:4,
        inset: 10pt,
        align: horizon,
        table.header(
            [],
            [*CBID*],
            [*CourseID*],
            [*BranchID*],
        ),

        [*Datatype*],
        [tinyint],
        [varchar],
        [varchar],

        [*Size*],
        [3],
        [3],
        [3],

        [*Constraint*],
        [*PK*],
        [*FK*],
        [*FK*],
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
            [*CBID*],
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
        [1],
        [3],
        [1],
        [1],

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
        [13],
        [9],
        [4],
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

- #underline[StudentID] Format: Admission Year(4) + Course Initials(3) + '/' + Branch Initials(3) + Serial No.(2) \
    Example: 2023BT/ETE19 #text(rgb("#6c757d"))[(2023 year + B.Tech + ETE Dept. + 19)]

- #underline[CourseID] Format: Course Initials(3) \
    Example: BT #text(rgb("#6c757d"))[(B.Tech)]

- #underline[BranchID] Format: Branch Initials(3) \
    Example: MCA

- #underline[PaperCode] Format: Course Initials(3) + Branch Initials(3) + Semester(1) + Type(1) + Paper No.(1) \
    Example: BTMEC2P3 #text(rgb("#6c757d"))[(B.Tech + Mechanical + 2ndSem + Pactical + 3rd Paper)]

#pagebreak()

#show figure.caption: it => [
    Figure: #it.body
]

#figure(
    gap: 20pt,
    rect(stroke: 0.5pt + gray)[#image("assets/er_diagram02.png", height: 65%)],
    caption: [ER Diagram for the Student Academic Records Database]
),
