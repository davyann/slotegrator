/* задача: 1 */
SELECT
    CASE
        WHEN g.grade < 8 THEN 'low'
        ELSE s.name
        END AS name,
    g.grade,
    s.marks
FROM
    students s
        JOIN
    grade g ON s.marks BETWEEN g.min_mark AND g.max_mark
ORDER BY
    g.grade DESC,
    CASE
        WHEN g.grade BETWEEN 8 AND 10 THEN s.name
        WHEN g.grade < 8 THEN s.marks * -1
        ELSE s.marks
        END;

/* Задача 2:
Ответ: можно сохранить grade напрямую в таблице students, чтобы избежать частых джойнов по полю marks.
Grade вычисляется заранее — при вставке или обновлении записи.

Поле ссылается на значения из таблицы grade, но отказываемся от внешнего ключа (foreign key),
так как он увеличивает нагрузку при массовых вставках и может замедлять производительность.
*/

ALTER TABLE students ADD COLUMN grade INT;
/* Создаём отдельный индекс, так как это поле также может использоваться в условиях запросов.*/
CREATE INDEX idx_students_grade ON students(grade);
