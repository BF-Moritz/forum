package seeder

import (
	"math/rand"
	"time"

	"github.com/BF-Moritz/forum/go/consts"
	"github.com/BF-Moritz/forum/go/vars"
)

const insertFriendSQL string = `
INSERT INTO forum.friends (user_one_id, user_two_id, is_accepted) 
VALUES (?, ?, ?)
`

func (s Service) SeedFriends(userIDs map[int64]time.Time) (err error) {
	vars.Logger.LogInfo("SeedFriends()", "start seeding friends...")

	var allUsers []int64 = make([]int64, 0, len(userIDs))
	for user := range userIDs {
		allUsers = append(allUsers, user)
	}

	var friendsMap map[int64][]int64 = make(map[int64][]int64)

	for _, userID := range allUsers {
		var numFriends int = int(rand.Uint32() % consts.MaxFriends)

		friendsMap[userID] = make([]int64, 0, numFriends)

		for i := 0; i < numFriends; i++ {
			friend := allUsers[rand.Int()%len(userIDs)]
			hasFriend := friend == userID
			if friendFriends, ok := friendsMap[friend]; ok {
				for _, friendFriend := range friendFriends {
					if friendFriend == userID {
						hasFriend = true
						break
					}
				}
			}
			if !hasFriend {
				friendsMap[userID] = append(friendsMap[userID], friend)
			} else {

			}
		}
	}

	var numOfFriends uint32 = 0
	for userID, friends := range friendsMap {
		for _, friend := range friends {

			_, err = vars.Conn.Exec(insertFriendSQL, userID, friend, rand.Int()%10 > 2)
			if err != nil {
				vars.Logger.LogError("SeedFriends()", "failed to insert friend (%s)", err)
				return err
			}
			numOfFriends++
		}
	}

	vars.Logger.LogInfo("SeedPosts()", "finished seeding friends (%d)...", numOfFriends)

	return
}
