# Admin-and-User-UI-to-work-with-database

Used PDO to work with database in PhpMyAdmin.

Created 3 HTML pages to work with database:
- Menu to choose between Admin and User UI
- Admin UI
- User UI

Admin can:
- Upload CSV file into database
- Upload single term into database
- Modify terms description in database
- Delete term from database

User can:
- Search for term (key letters are allowed) in chosen language (Slovak, English)
- View description of the term
- Translate term and description

Database name: glosar

Tables:
- words (id,title)
- translations (id, language_id, word_id, title, description)
- languages (id, title)


![tables](https://user-images.githubusercontent.com/79150859/159305479-093d25b3-3009-45ed-940e-29bf6f092a82.png)
