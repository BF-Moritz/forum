# forum

## Datenbanken

-   users (id, username, email, password, is_deleted, created_at)
-   threads (id, title, description, is_private, is_closed, is_deleted, created_at)
-   posts (id, title, text, author, is_closed, is_deleted, created_at, updated_at)
-   comments (id, user_id, text, is_deleted, created_at, updated_at)
-   posts_comments (id, comment_id, post_id)
-   rollen (id, name)
-   private_threads_users (id, thread_id, user_id)
