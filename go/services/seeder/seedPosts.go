package seeder

import (
	"database/sql"
	"math/rand"
	"time"

	"github.com/BF-Moritz/forum/go/consts"
	"github.com/BF-Moritz/forum/go/enums"
	"github.com/BF-Moritz/forum/go/types"
	"github.com/BF-Moritz/forum/go/utils"
	"github.com/BF-Moritz/forum/go/vars"
)

const insertPostSQL string = `
INSERT INTO forum.posts (thread_id, user_id, title, text, created_at) 
VALUES (?, ?, ?, ?, ?)
`

func (s Service) SeedPosts(users map[int64]time.Time, threadIDs []enums.ThreadInfoType) (posts []types.PostType, err error) {
	vars.Logger.LogInfo("SeedPosts()", "start seeding posts...")

	// insert threads
	var res sql.Result
	var id int64
	var threadID enums.ThreadInfoType
	var userID int64
	var post types.PostType

	var userIDs []int64 = make([]int64, 0, len(users))
	for user := range users {
		userIDs = append(userIDs, user)
	}

	posts = make([]types.PostType, 0, consts.PostNumber)

	for i := uint32(0); i < consts.PostNumber; i++ {
		threadID = threadIDs[rand.Int()%len(threadIDs)]

		userID = userIDs[rand.Int()%len(userIDs)]
		post = utils.GeneratePost(userID, threadID.Topic, users, userIDs)

		res, err = vars.Conn.Exec(insertPostSQL, threadID.ID, userID, post.Title, post.Description, post.CreatedAt)
		if err != nil {
			vars.Logger.LogError("SeedPosts()", "failed to insert post [%+v] (%s)", post, err)
			return
		}

		id, err = res.LastInsertId()
		if err != nil {
			vars.Logger.LogError("SeedPosts()", "failed to get last inserted threadID (%s)", err)
			return
		}
		post.ID = id

		posts = append(posts, post)
	}

	vars.Logger.LogInfo("SeedPosts()", "finished seeding posts (%d)...", len(posts))

	return
}
