package enums

import (
	"github.com/BF-Moritz/forum/go/vars"
)

type ThreadTopic int

const (
	Game ThreadTopic = iota
	Toplist
	// Hardware
	// TODO make more topics
)

type ThreadDescType struct {
	Title       string
	Description string
}

var topicToThreadType map[ThreadTopic]ThreadDescType = map[ThreadTopic]ThreadDescType{
	Game:    {Title: "Spiele", Description: "Hier wird sich über alle möglichen Spiele unterhalten."},
	Toplist: {Title: "Toplisten", Description: "Hier stellen User ihre Toplisten zu allen möglichen Spielen vor."},
	// Hardware: {Title: "Hardware", Description: "Hier könnt ihr euch über alles, was mit Hardware zu tun hat, unterhalten. Egal ob Grafikkarten, CPUs, oder doch die neue Konsolengeneration."},
}

var ThreadList []ThreadTopic = []ThreadTopic{Game, Toplist}

func (t ThreadTopic) GetTitle() string {
	if _, ok := topicToThreadType[t]; !ok {
		vars.Logger.LogError("GetTitle()", "topic %d has no title", t)
		return ""
	}
	return topicToThreadType[t].Title
}

func (t ThreadTopic) GetDescription() string {
	if _, ok := topicToThreadType[t]; !ok {
		vars.Logger.LogError("GetDescription()", "topic %d has no description", t)
		return ""
	}
	return topicToThreadType[t].Description
}

type ThreadInfoType struct {
	ID    int64
	Topic ThreadTopic
}
