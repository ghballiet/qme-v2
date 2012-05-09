CREATE TABLE entity (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT,
  kind TEXT,
  location INTEGER,
  model INTEGER
);
CREATE TABLE fact (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  start INTEGER,
  type TEXT,
  end INTEGER,
  model INTEGER
);
CREATE TABLE link (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  start INTEGER,
  type TEXT,
  end INTEGER,
  model INTEGER
);
CREATE TABLE model ( id integer primary key autoincrement, name text, description text);
CREATE TABLE note_entity (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  content TEXT
);
CREATE TABLE note_link (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  content TEXT
);
CREATE TABLE owns ( model_id INT, user_id INT );
CREATE TABLE placement (
  entity INTEGER,
  x INTEGER,
  y INTEGER,
  width INTEGER,
  height INTEGER
);
CREATE TABLE user (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT,
  surname TEXT,
  email TEXT,
  password TEXT
, isAdmin int);
CREATE VIEW view_entities AS
  SELECT
    e1.id AS id,
    e1.name AS name,
    e1.kind AS kind,
    e1.location AS locationID,
    e2.name AS locationName,
    e1.model AS model
  FROM
    entity e1, entity e2
  WHERE
    e1.location = e2.id

  UNION

  SELECT
    e.id AS id,
    e.name AS name,
    e.kind AS kind,
    e.location AS locationID,
    '' AS locationName,
    e.model AS model
  FROM
    entity e
  WHERE
    e.location = 0

  ORDER BY
    location, kind, name;
CREATE VIEW view_links AS
  SELECT
    l.id AS id,	
    e1.id AS startID,
    e1.name AS startName,
    e1.locationID AS startLocationID,
    e1.locationName AS startLocationName,
    e1.kind AS startKind,
    l.type AS type,
    e2.id AS endID,
    e2.name AS endName,
    e2.locationID AS endLocationID,
    e2.locationName AS endLocationName,
    e2.kind AS endKind,
    l.model AS model
  FROM
    view_entities e1,
    view_entities e2,
    link l
  WHERE
    e1.id = l.start AND
    e2.id = l.end
  ORDER BY
    l.id, e1.name, e2.name;
