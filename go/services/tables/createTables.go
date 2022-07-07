package tables

import (
	"github.com/BF-Moritz/forum/go/vars"
)

const createUsersSQL string = `
CREATE TABLE forum.users (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	username VARCHAR(45) NOT NULL,
	email VARCHAR(255) NOT NULL,
  	password VARCHAR(255) NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  	PRIMARY KEY (id),
  	UNIQUE INDEX username_UNIQUE (username),
  	UNIQUE INDEX email_UNIQUE (email)
);
`

const createSessionsSQL string = `
CREATE TABLE forum.sessions (
  	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  	user_id INT UNSIGNED NOT NULL,
  	token VARCHAR(255) NOT NULL,
  	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  	PRIMARY KEY (id),
  	FOREIGN KEY (user_id) REFERENCES forum.users(id)
);`

const createThreadsSQL string = `
CREATE TABLE forum.threads (
  	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  	title VARCHAR(255) NOT NULL,
  	description VARCHAR(1024) NOT NULL,
  	PRIMARY KEY (id)
);`

const createPostsSQL string = `
CREATE TABLE forum.posts (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	thread_id INT UNSIGNED NOT NULL,
	user_id INT UNSIGNED NOT NULL,
	title VARCHAR(128) NOT NULL,
	text VARCHAR(1024) NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  	PRIMARY KEY (id),
	FOREIGN KEY (thread_id) REFERENCES forum.threads(id),
	FOREIGN KEY (user_id) REFERENCES forum.users(id)
);`

const createCommentsSQL string = `
CREATE TABLE forum.comments (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	post_id INT UNSIGNED NOT NULL,
	user_id INT UNSIGNED NOT NULL,
	text VARCHAR(255) NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  	PRIMARY KEY (id),
	FOREIGN KEY (post_id) REFERENCES forum.posts(id),
	FOREIGN KEY (user_id) REFERENCES forum.users(id)
);`

const createFriendsSQL string = `
CREATE TABLE forum.friends (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	user_one_id INT UNSIGNED NOT NULL,
	user_two_id INT UNSIGNED NOT NULL,
	is_accepted BOOLEAN NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  	PRIMARY KEY (id),
	FOREIGN KEY (user_one_id) REFERENCES forum.users(id),
	FOREIGN KEY (user_two_id) REFERENCES forum.users(id)
);`

func (s Service) CreateTables() (err error) {
	vars.Logger.LogInfo("CreateTables()", "start creating tables...")
	// create users
	_, err = vars.Conn.Exec(createUsersSQL)
	if err != nil {
		vars.Logger.LogError("CreateTables()", "failed to create users table (%s)", err)
		return err
	}

	_, err = vars.Conn.Exec(createSessionsSQL)
	if err != nil {
		vars.Logger.LogError("CreateTables()", "failed to create sessions table (%s)", err)
		return err
	}

	// create threads
	_, err = vars.Conn.Exec(createThreadsSQL)
	if err != nil {
		vars.Logger.LogError("CreateTables()", "failed to create treads table (%s)", err)
		return err
	}

	// create posts
	_, err = vars.Conn.Exec(createPostsSQL)
	if err != nil {
		vars.Logger.LogError("CreateTables()", "failed to create posts table (%s)", err)
		return err
	}

	// create comments
	_, err = vars.Conn.Exec(createCommentsSQL)
	if err != nil {
		vars.Logger.LogError("CreateTables()", "failed to create comments table (%s)", err)
		return err
	}

	// create friends
	_, err = vars.Conn.Exec(createFriendsSQL)
	if err != nil {
		vars.Logger.LogError("CreateTables()", "failed to create friends table (%s)", err)
		return err
	}

	vars.Logger.LogInfo("CreateTables()", "finished creating tables...")

	return nil
}
