package main

import (
	"database/sql"
	"log"
	"time"

	"github.com/BF-Moritz/forum/go/enums"
	"github.com/BF-Moritz/forum/go/libs"
	"github.com/BF-Moritz/forum/go/services/seeder"
	"github.com/BF-Moritz/forum/go/services/tables"
	"github.com/BF-Moritz/forum/go/types"
	"github.com/BF-Moritz/forum/go/vars"
	_ "github.com/go-sql-driver/mysql"
	"gopkg.in/alecthomas/kingpin.v2"
)

var (
	verboseLevel = kingpin.Flag("verbose", "the level of verbosity (0-3)").Default("1").Short('v').Uint32()
)

func main() {
	kingpin.Parse()
	if *verboseLevel > 3 {
		log.Fatalf("verbose is out of range (0-3), got \"%d\"", *verboseLevel)
	}

	vars.Logger = libs.NewLogger(*verboseLevel, true, true)

	var err error
	var userIDs map[int64]time.Time
	var threads []enums.ThreadInfoType
	var posts []types.PostType

	vars.Conn, err = sql.Open("mysql", "root:@tcp(localhost:3306)/forum")
	if err != nil {
		vars.Logger.LogFatal("main()", "failed to open mysql connection (%s)", err)
		return
	}

	defer vars.Conn.Close()

	tableService := tables.NewService()
	err = tableService.ClearTables()
	if err != nil {
		vars.Logger.LogFatal("main()", "failed to clear tables (%s)", err)
		return
	}
	err = tableService.CreateTables()
	if err != nil {
		vars.Logger.LogFatal("main()", "failed to create tables (%s)", err)
		return
	}

	seederService := seeder.NewService()
	userIDs, err = seederService.SeedUsers()
	if err != nil {
		vars.Logger.LogFatal("main()", "failed to seed users (%s)", err)
		return
	}
	threads, err = seederService.SeedThreads()
	if err != nil {
		vars.Logger.LogFatal("main()", "failed to seed threads (%s)", err)
		return
	}

	posts, err = seederService.SeedPosts(userIDs, threads)
	if err != nil {
		vars.Logger.LogFatal("main()", "failed to seed posts (%s)", err)
		return
	}

	err = seederService.SeedComments(posts)
	if err != nil {
		vars.Logger.LogFatal("main()", "failed to seed comments (%s)", err)
		return
	}

	err = seederService.SeedFriends(userIDs)
	if err != nil {
		vars.Logger.LogFatal("main()", "failed to seed friends (%s)", err)
		return
	}
}
