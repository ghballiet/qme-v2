create table users (
  id int primary key auto_increment,
  name varchar(250),
  surname varchar(250),
  email varchar(500),
  password varchar(500)
);

create table qmodels (
  id int primary key auto_increment,
  name varchar(250),
  description longtext,
  private boolean,
  user_id int
);