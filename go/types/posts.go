package types

import (
	"time"

	"github.com/BF-Moritz/forum/go/enums"
)

type PostType struct {
	Thread      enums.ThreadInfoType
	ID          int64
	UserID      int64
	Title       string
	Description string
	CreatedAt   time.Time
	Comments    []CommentType
}

type CommentType struct {
	UserID    int64
	Text      string
	CreatedAt time.Time
}
