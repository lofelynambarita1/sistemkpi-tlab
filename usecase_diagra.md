@startuml
left to right direction

actor Associate
actor Intermediate
actor Senior
actor Principle
actor Lead
actor "Lead HR" as LeadHR
actor Manager
actor Admin

rectangle "Sistem KPI" {

'====================
' AUTH
'====================

usecase "Login" as UC1
usecase "Logout" as UC2

'====================
' DASHBOARD
'====================

usecase "Lihat Dashboard" as UC3

'====================
' PROFILE
'====================

usecase "Lihat Profile" as UC4
usecase "Ubah Password" as UC5

'====================
' HISTORY
'====================

usecase "Lihat History KPI" as UC6

'====================
' KPI FORM
'====================

usecase "Buat KPI" as UC7
usecase "Edit KPI" as UC8
usecase "Isi KPI Hasil" as UC9
usecase "Isi KPI Perilaku" as UC10
usecase "Submit KPI" as UC11
usecase "Revisi KPI" as UC12
usecase "Lihat Status KPI" as UC13

'====================
' REVIEW KPI
'====================

usecase "Lihat Daftar KPI" as UC14
usecase "Lihat Detail KPI" as UC15
usecase "Review KPI" as UC16
usecase "Approve KPI" as UC17
usecase "Reject KPI" as UC18
usecase "Bulk Approve KPI" as UC19
usecase "Bulk Reject KPI" as UC20
usecase "Import KPI" as UC21

'====================
' USER MANAGEMENT
'====================

usecase "Kelola User" as UC22
usecase "Tambah User" as UC23
usecase "Ubah User" as UC24
usecase "Hapus User" as UC25
usecase "Reset Password User" as UC26
usecase "Import User" as UC27
}

Associate --> UC1
Associate --> UC2
Associate --> UC3
Associate --> UC4
Associate --> UC5
Associate --> UC6
Associate --> UC7
Associate --> UC8
Associate --> UC11
Associate --> UC12
Associate --> UC13

Intermediate --> UC1
Intermediate --> UC2
Intermediate --> UC3
Intermediate --> UC4
Intermediate --> UC5
Intermediate --> UC6
Intermediate --> UC7
Intermediate --> UC8
Intermediate --> UC11
Intermediate --> UC12
Intermediate --> UC13

Senior --> UC1
Senior --> UC2
Senior --> UC3
Senior --> UC4
Senior --> UC5
Senior --> UC6
Senior --> UC7
Senior --> UC8
Senior --> UC11
Senior --> UC12
Senior --> UC13

Principle --> UC1
Principle --> UC2
Principle --> UC3
Principle --> UC4
Principle --> UC5
Principle --> UC6
Principle --> UC7
Principle --> UC8
Principle --> UC11
Principle --> UC12
Principle --> UC13

Lead --> UC1
Lead --> UC2
Lead --> UC3
Lead --> UC4
Lead --> UC5
Lead --> UC6
Lead --> UC7
Lead --> UC8
Lead --> UC11
Lead --> UC14
Lead --> UC15
Lead --> UC16
Lead --> UC17
Lead --> UC18
Lead --> UC19
Lead --> UC20

LeadHR --> UC1
LeadHR --> UC2
LeadHR --> UC3
LeadHR --> UC4
LeadHR --> UC5
LeadHR --> UC6
LeadHR --> UC7
LeadHR --> UC8
LeadHR --> UC11
LeadHR --> UC14
LeadHR --> UC15
LeadHR --> UC16
LeadHR --> UC17
LeadHR --> UC18
LeadHR --> UC19
LeadHR --> UC20

Manager --> UC1
Manager --> UC2
Manager --> UC3
Manager --> UC4
Manager --> UC5
Manager --> UC6
Manager --> UC14
Manager --> UC15
Manager --> UC16
Manager --> UC17
Manager --> UC18
Manager --> UC19
Manager --> UC20
Manager --> UC21

Admin --> UC1
Admin --> UC2
Admin --> UC3
Admin --> UC4
Admin --> UC5
Admin --> UC22

UC22 .> UC23 : <<include>>
UC22 .> UC24 : <<include>>
UC22 .> UC25 : <<include>>
UC22 .> UC26 : <<include>>
UC22 .> UC27 : <<include>>

UC7 .> UC9 : <<include>>
UC7 .> UC10 : <<include>>

UC11 .> UC9 : <<include>>
UC11 .> UC10 : <<include>>

UC16 .> UC15 : <<include>>

UC17 .> UC16 : <<extend>>
UC18 .> UC16 : <<extend>>

@enduml