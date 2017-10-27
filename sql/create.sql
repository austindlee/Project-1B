CREATE TABLE Movie(id int, title varchar(100), year int, rating varchar(10), company varchar(50),
                   -- Each movie is identified by a unique id
                   PRIMARY KEY (id)) ENGINE = INNODB;

CREATE TABLE Actor(id int, last varchar(20), first varchar(20), sex varchar (6), dob date, dod date,
                   -- Each actor is identified by a unique id
                   PRIMARY KEY (id)) ENGINE = INNODB;

CREATE TABLE Sales(mid int, ticketsSold int, totalIncome int,
                   -- A check is done to ensure the amount of tickets sold and total income is non negative
                  CHECK(ticketsSold >= 0 AND totalIncome >= 0)) ENGINE = INNODB;

CREATE TABLE Director(id int, last varchar(20), first varchar(20), dob date, dod date,
                      -- Each director is identified by a unique id
                      PRIMARY KEY (id),
                      -- Checks to see if the birthday of a director is less than his death day
                      CHECK(dob < dod)) ENGINE = INNODB;

CREATE TABLE MovieGenre(mid int, genre varchar(20),
                        -- Ensures that every entry refernces a movie by the movie id
                       FOREIGN KEY (mid) references Movie(id)) ENGINE = INNODB;

CREATE TABLE MovieDirector(mid int, did int,
                           -- Every entry references a director by the director id
                          FOREIGN KEY (did) references Director(id)) ENGINE = INNODB;

CREATE TABLE MovieActor(mid int, aid int, role varchar(50),
                        -- Every entry references a movie by movie id
                       FOREIGN KEY (mid) references Movie(id),
                        -- Every entry references an actor by actor id
                       FOREIGN KEY (aid) references Actor(id)) ENGINE = INNODB;

CREATE TABLE MovieRating(mid int, imdb int, rot int,
                         -- Checks to ensure that IMDB ratings are between 0 and 10
                         -- and Rotten Tomato Ratings are between 0 and 100
                        CHECK(imdb >= 0 AND imdb <= 10 AND rot >= 0 AND rot <= 100),
                         -- Every entry references a movied by the movie id
                        FOREIGN KEY (mid) references Movie(id)) ENGINE = INNODB;

CREATE TABLE Review(name varchar(20), time timestamp, mid int, rating int, comment varchar(500),
                   -- Every entry refernces a movie by the movie id
                   FOREIGN KEY (mid) references Movie(id)) ENGINE = INNODB;

CREATE TABLE MaxPersonID(id int) ENGINE = INNODB;

CREATE TABLE MaxMovieID(id int) ENGINE = INNODB;
