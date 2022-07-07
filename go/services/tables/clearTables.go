package tables

import (
	"fmt"

	"github.com/BF-Moritz/forum/go/vars"
)

func (s Service) ClearTables() (err error) {
	vars.Logger.LogInfo("ClearTables()", "start clearing tables...")

	rows, err := vars.Conn.Query("SELECT table_name FROM information_schema.tables WHERE table_schema = \"forum\";")
	if err != nil {
		vars.Logger.LogError("ClearTables()", "failed to get list of all tables (%s)", err)
		return err
	}

	var tablesToClean []string = []string{
		"messages", "friends", "private_threads_users", "comments", "posts", "threads", "sessions", "users",
	}

	for rows.Next() {
		var name string
		err = rows.Scan(&name)
		if err != nil {
			vars.Logger.LogError("ClearTables()", "name scan failed (%s)", err)
			return err
		}

		tablesToClean = append(tablesToClean, name)
	}

	for _, table := range tablesToClean {
		_, err := vars.Conn.Exec(fmt.Sprintf("DROP TABLE IF EXISTS forum.%s;", table))
		if err != nil {
			vars.Logger.LogError("ClearTables()", "failed to drop table '%s' (%s)", table, err)
			return err
		}
	}

	vars.Logger.LogInfo("ClearTables()", "finished clearing tables...")

	return nil
}
