package seeder

import (
	"github.com/BF-Moritz/forum/go/types"
	"github.com/BF-Moritz/forum/go/vars"
)

const insertCommentsSQL string = `
INSERT INTO forum.comments (post_id, user_id, text, created_at) 
VALUES (?, ?, ?, ?)
`

func (s Service) SeedComments(posts []types.PostType) (err error) {
	vars.Logger.LogInfo("SeedComments()", "start seeding comments...")
	var counter uint32

	// insert comments
	for _, post := range posts {
		for _, comment := range post.Comments {
			_, err = vars.Conn.Exec(insertCommentsSQL, post.ID, comment.UserID, comment.Text, comment.CreatedAt)
			if err != nil {
				vars.Logger.LogError("SeedPosts()", "failed to insert post [%+v] (%s)", post, err)
				return
			}
			counter++
		}
	}

	vars.Logger.LogInfo("SeedComments()", "finished seeding comments (%d)...", counter)

	return
}
