package utils

import (
	"fmt"
	"math/rand"
	"strings"
	"time"

	"github.com/BF-Moritz/forum/go/consts"
	"github.com/BF-Moritz/forum/go/enums"
	"github.com/BF-Moritz/forum/go/types"
)

func GeneratePost(userID int64, topic enums.ThreadTopic, users map[int64]time.Time, allUsers []int64) (post types.PostType) {
	post = types.PostType{
		UserID:    userID,
		CreatedAt: users[userID].Add(time.Second * time.Duration(rand.Uint32()%31536000)),
	}
	if topic == enums.Game {
		game := consts.Games[rand.Uint32()%uint32(len(consts.Games))]
		title, description := generateGamePost(game)
		post.Title = title
		post.Description = description
		post.Comments = generateGameComments(game, post.CreatedAt, allUsers)
	} else if topic == enums.Toplist {
		topListLength := consts.TopListLengths[rand.Uint32()%uint32(len(consts.TopListLengths))]
		var gamesMap map[string]struct{} = make(map[string]struct{}, 0)

		for len(gamesMap) < topListLength {
			gamesMap[consts.Games[rand.Uint32()%uint32(len(consts.Games))]] = struct{}{}
		}

		games := make([]string, 0, len(gamesMap))
		for game := range gamesMap {
			games = append(games, game)
		}

		title, description := generateTopList(games)
		post.Title = title
		post.Description = description
		post.Comments = generateTopListComments(post.CreatedAt, allUsers)
	}
	return
}

func generateGamePost(game string) (title, description string) {
	switch rand.Uint32() % 5 {
	case 0:
		title = fmt.Sprintf("Was haltet ihr von %s?", game)
		description = fmt.Sprintf("Was haltet ihr vom Spiel %s? Sieht eigentlich ganz interessant aus.", game)
	case 1:
		title = fmt.Sprintf("Würdet ihr %s empfehlen?", game)
		description = fmt.Sprintf("In interessiere mich ja für solche Spiele, aber würdet ihr %s empfehlen?", game)
	case 2:
		title = fmt.Sprintf("Mitspieler für %s gesucht.", game)
		description = fmt.Sprintf("Wir sind eine Gruppe von %d Spielern, die gerne %s spielen. Wir treffen uns immer abends auf unserem Discord Server. Falls ihr interesse habt, meldet euch gerne bei mir!", rand.Uint32()%5+2, game)
	case 3:
		title = fmt.Sprintf("Ich suche Mitspieler für %s.", game)
		description = fmt.Sprintf("Ich spiele %s aktuell leider alleine. Deswegen suche ich ein paar Mitspieler. Skill ist egal, hauptsache wir haben Spaß.", game)
	case 4:
		title = fmt.Sprintf("Lohnt sich %s?", game)
		description = fmt.Sprintf("Ich hatte vor, mir %s zu kaufen. Lohnt sich das zum aktuellen Preis?", game)
	}
	return
}

var gameComments []string = []string{
	"Finde ich gut",
	"Jup",
	"Nee",
	"Würde ich nicht machen",
	"Auf keinen fall!",
	"Warum?",
	"Keine Ahnung",
	"Sry, da kann ich dir echt nicht weiterhelfen",
	"Nö",
	"Nöö",
	"Ja, gerne",
	"Jaaa",
	"Klar",
	"Klaro",
	"Warum nicht",
	"Musst mal schauen",
}

func generateGameComments(game string, createdAt time.Time, allUsers []int64) (comments []types.CommentType) {
	var num uint32 = (rand.Uint32() % (consts.MaxCommentPerThread - consts.MinCommentPerThread)) + consts.MinCommentPerThread
	comments = make([]types.CommentType, 0, num)

	for i := 0; i < int(num); i++ {
		comments = append(comments, types.CommentType{
			UserID:    allUsers[rand.Uint32()%uint32(len(allUsers))],
			Text:      gameComments[rand.Uint32()%uint32(len(gameComments))],
			CreatedAt: createdAt.Add(time.Second * time.Duration(rand.Uint32()%31536000)),
		})
	}

	return
}

func generateTopList(games []string) (title, description string) {
	if len(games) == 1 {
		switch rand.Uint32() % 2 {
		case 0:
			title = "Mein Top Spiel aller Zeiten!"
			description = fmt.Sprintf("Bestes Spiel ist und bleibt %s!", games[0])
		case 1:
			title = fmt.Sprintf("%s ist das beste Spiel!", games[0])
			description = fmt.Sprintf("Ich finde, %s ist das beste Spiel! Was haltet ihr davon?", games[0])
		}
	} else {
		switch rand.Uint32() % 2 {
		case 0:
			title = fmt.Sprintf("Meine Top %d Spiele!", len(games))
			description = fmt.Sprintf("%s!", strings.Join(games, ", <br>"))
		case 1:
			title = fmt.Sprintf("Top %d Spiele!", len(games))
			description = fmt.Sprintf("%s!", strings.Join(games, ", <br>"))
		}
	}
	return
}

var topListComments []string = []string{
	"Finde ich gut",
	"Finde ich nicht gut",
	"Jup",
	"Nee",
	"Würde ich nicht so machen",
	"Auf keinen fall!",
	"Warum?",
	"Nö",
	"Nöö",
	"Jaaa",
	"War echt nicht soo gut",
	"War echt nicht so gut",
	"Würde ich jetzt aber nicht so sehn",
}

func generateTopListComments(createdAt time.Time, allUsers []int64) (comments []types.CommentType) {
	var num uint32 = (rand.Uint32() % (consts.MaxCommentPerThread - consts.MinCommentPerThread)) + consts.MinCommentPerThread
	comments = make([]types.CommentType, 0, num)

	for i := 0; i < int(num); i++ {
		comments = append(comments, types.CommentType{
			UserID:    allUsers[rand.Uint32()%uint32(len(allUsers))],
			Text:      topListComments[rand.Uint32()%uint32(len(topListComments))],
			CreatedAt: createdAt.Add(time.Second * time.Duration(rand.Uint32()%31536000)),
		})
	}

	return
}
