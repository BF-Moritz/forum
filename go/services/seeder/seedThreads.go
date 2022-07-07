package seeder

import (
	"database/sql"

	"github.com/BF-Moritz/forum/go/enums"
	"github.com/BF-Moritz/forum/go/types"
	"github.com/BF-Moritz/forum/go/vars"
)

const insertThreadSQL string = `
INSERT INTO forum.threads (title, description) 
VALUES (?, ?)
`

func (s Service) SeedThreads() (threadIDs []enums.ThreadInfoType, err error) {
	vars.Logger.LogInfo("SeedThreads()", "start seeding threads...")
	threadIDs = make([]enums.ThreadInfoType, 0, len(enums.ThreadList))

	// insert threads
	var res sql.Result
	var id int64
	var thread types.ThreadType

	for _, t := range enums.ThreadList {
		thread = types.ThreadType{
			Title:       t.GetTitle(),
			Description: t.GetDescription(),
		}
		res, err = vars.Conn.Exec(insertThreadSQL, thread.Title, thread.Description)
		if err != nil {
			vars.Logger.LogError("SeedThreads()", "failed to insert thread [%+v] (%s)", thread, err)
			return
		}

		id, err = res.LastInsertId()
		if err != nil {
			vars.Logger.LogError("SeedThreads()", "failed to get last inserted threadID (%s)", err)
			return
		}
		threadIDs = append(threadIDs, enums.ThreadInfoType{
			ID:    id,
			Topic: t,
		})
	}

	vars.Logger.LogInfo("SeedThreads()", "finished seeding threads (%d)...", len(threadIDs))

	return
}
