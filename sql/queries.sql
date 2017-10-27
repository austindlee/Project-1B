-- This query returns the first and last names with a single space in
-- between of all the actors in the movie Death to Smoochy.
SELECT CONCAT(A.first, ' ', A.last)
FROM Actor A, Movie M, MovieActor MA
WHERE M.title = 'Death to Smoochy' AND M.id = MA.mid AND A.id = MA.aid;

-- This query returns the count of all the directors who directed at
-- 4 movies.
SELECT COUNT(*) DirectorCount
FROM (
    SELECT did,
    COUNT(*) dCount
    FROM MovieDirector
    GROUP BY did
    HAVING COUNT(*) > 3) AS TOTAL;

-- The query returns the count of all the movies with a 99 Rotten Tomatos
-- rating sorted alphabetically by name
SELECT M.title
FROM MovieRating MR, Movie M
WHERE M.id = MR.mid AND MR.rot = 99
ORDER BY M.id;

-- This query returns the names of the top ten highest grossing movies
-- along with the title of the movie and the income in the following
-- format: (Director First Director Last : Title : Total Income)
SELECT CONCAT(D.first, ' ', D.last, ' : ', M.title, ' : ', S.totalIncome)
FROM Movie M, Sales S, Director D, MovieDirector MD
WHERE M.id = S.mid AND S.mid = MD.mid AND MD.mid = D.id
ORDER BY S.totalIncome DESC
LIMIT 10;
