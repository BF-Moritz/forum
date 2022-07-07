package seeder

import (
	"database/sql"
	"fmt"
	"math/rand"
	"time"

	"github.com/BF-Moritz/forum/go/consts"
	"github.com/BF-Moritz/forum/go/vars"
)

const insertUserSQL string = `
INSERT INTO forum.users (username, email, password, created_at) 
VALUES (?, ?, ?, ?)
`

func (s Service) SeedUsers() (userIDs map[int64]time.Time, err error) {
	vars.Logger.LogInfo("SeedUsers()", "start seeding users...")

	var userMap map[string]struct{} = make(map[string]struct{})
	userIDs = make(map[int64]time.Time)

	for len(userMap) < int(consts.UserNumber) {
		var name string = fmt.Sprintf("%s%d", consts.Names[rand.Uint32()%uint32(len(consts.Names))], rand.Uint32()%10000)
		if _, ok := userMap[name]; !ok {
			userMap[name] = struct{}{}
		}
	}

	var res sql.Result
	var id int64
	var createdAt time.Time
	for name := range userMap {
		createdAt = time.Now().Add(-1 * time.Duration(63072000+(rand.Uint32()%315360000)) * time.Second)
		res, err = vars.Conn.Exec(insertUserSQL, name, fmt.Sprintf("%s@%s", name, consts.Urls[rand.Uint32()%uint32(len(consts.Urls))]), fmt.Sprintf("%s%05d", name, rand.Uint32()), createdAt)
		if err != nil {
			vars.Logger.LogError("SeedUsers()", "failed to insert user (%s)", err)
			return userIDs, err
		}

		id, err = res.LastInsertId()
		if err != nil {
			vars.Logger.LogError("SeedUsers()", "failed to get last inserted userID (%s)", err)
			return userIDs, err
		}
		userIDs[id] = createdAt
	}

	vars.Logger.LogInfo("SeedUsers()", "finished seeding users (%d)...", len(userIDs))

	return userIDs, nil
}
