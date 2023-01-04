-- The users TABLE--

CREATE TABLE users (
  id INT not null auto_increment primary key,
  users varchar(255) UNIQUE NOT NULL,
  nickname varchar(255),
  password VARCHAR(255),
  image_path VARCHAR(255), 
  created_at DATETIME CURRENT_TIMESTAMP DEFAULT_GENERATED,
  last_login DATETIME,
  activated tinyint(1) default(0),
  email VARCHAR(255) NOT NULL UNIQUE,
  privil tinyint(1) default(0),
  rese_token VARCHAR(255),
  ban_time datetime,
  ban_duraion varchar(20));

  -- The posts Table--

  CREATE TABLE posts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER UNIQUE,
    usersname VARCHAR(255) UNIQUE,
    title VARCHAR(255) NOT NULL UNIQUE,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP DEFAULT_GENERATED,
    updated_at datetime ,
    content TEXT NOT NULL,
    approved tinyint(1) default(0)
  )