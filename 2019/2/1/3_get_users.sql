SELECT u.*
FROM users AS u
LEFT JOIN favorites AS f ON u.id = f.user_id
WHERE f.post_id = 1
LIMIT 20
OFFSET 0