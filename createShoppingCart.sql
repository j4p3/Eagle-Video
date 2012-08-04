create table shoppingCart (
sessionID int,
custID int,
movID int,

primary key (sessionID),
foreign key (custID) references customer2,
foreign key (movID) references movie
)
