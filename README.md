### Installing

```
git clone git@github.com:FaZeRs/naurislinde.com.git
```

```
docker-compose up -d --build
```

```
docker-compose exec php composer start
```


The application will be available on http://localhost:8000

#### API Links

Verb | Path | NamedRoute | Controller | Action | Middleware
--- | --- | --- | --- | --- | ---
POST | /api/login | auth.login | \App\Http\Controllers\Api\LoginController | login | guest
POST | /api/register | auth.register | \App\Http\Controllers\Api\RegisterController | register | guest
GET | /api/details | auth.details | \App\Http\Controllers\Api\UserController | details | auth
GET | /api/logout | auth.logout | \App\Http\Controllers\Api\UserController | logout | auth
GET | /api/notes | notes.index | \App\Http\Controllers\Api\NoteController | index | auth
GET | /api/notes/public | notes.public | \App\Http\Controllers\Api\NoteController | getPublic | auth
POST | /api/notes | notes.store | \App\Http\Controllers\Api\NoteController | store | auth
GET | /api/notes/{note} | notes.show | \App\Http\Controllers\Api\NoteController | show | auth
PUT | /api/notes/{note} | notes.update | \App\Http\Controllers\Api\NoteController | update | auth
DELETE | /api/notes/{note} | notes.destroy | \App\Http\Controllers\Api\NoteController | destroy | auth
GET | /api/notes/{note}/comments | comments.index | \App\Http\Controllers\Api\CommentController | index | auth
POST | /api/notes/{note}/comments | comments.store | \App\Http\Controllers\Api\CommentController | store | auth
PUT | /api/notes/{note}/comments/{comment} | comments.update | \App\Http\Controllers\Api\CommentController | update | auth
DELETE | /api/notes/{note}/comments/{comment} | comments.destroy | \App\Http\Controllers\Api\CommentController | destroy | auth
