package libs

import (
	"fmt"
	"log"
	"runtime"
	"time"
)

type Logger struct {
	level    uint32
	showTime bool
}

var reset = "\033[0m"
var red = "\033[31m"
var green = "\033[32m"
var yellow = "\033[33m"
var blue = "\033[34m"
var purple = "\033[35m"
var cyan = "\033[36m"
var gray = "\033[37m"
var white = "\033[97m"

func NewLogger(level uint32, showTime, showColor bool) *Logger {
	if runtime.GOOS == "windows" || !showColor {
		reset = ""
		red = ""
		green = ""
		yellow = ""
		blue = ""
		purple = ""
		cyan = ""
		gray = ""
		white = ""
	}
	return &Logger{
		level:    level,
		showTime: showTime,
	}
}

const timeFormatString = "2006-01-02|15:04:05"

func (l *Logger) LogDebug(function, message string, args ...interface{}) {
	if l.level < 3 {
		return
	}

	timeString := ""
	if l.showTime {
		timeString = fmt.Sprintf("[%s]: ", time.Now().Format(timeFormatString))
	}
	fmt.Printf("%s%s[DBG] %s: %s%s\n", cyan, timeString, function, fmt.Sprintf(message, args...), reset)
}

func (l *Logger) LogInfo(function, message string, args ...interface{}) {
	if l.level < 2 {
		return
	}

	timeString := ""
	if l.showTime {
		timeString = fmt.Sprintf("[%s]: ", time.Now().Format(timeFormatString))
	}
	fmt.Printf("%s%s[NFO] %s: %s%s\n", green, timeString, function, fmt.Sprintf(message, args...), reset)
}

func (l *Logger) LogError(function, message string, args ...interface{}) {
	if l.level < 1 {
		return
	}
	timeString := ""
	if l.showTime {
		timeString = fmt.Sprintf("[%s]: ", time.Now().Format(timeFormatString))
	}
	fmt.Printf("%s%s[ERR] %s: %s%s\n", red, timeString, function, fmt.Sprintf(message, args...), reset)
}

func (l *Logger) LogFatal(function, message string, args ...interface{}) {
	timeString := ""
	if l.showTime {
		timeString = fmt.Sprintf("[%s]: ", time.Now().Format(timeFormatString))
	}
	log.Fatalf("%s%s[FAT] %s: %s%s\n", purple, timeString, function, fmt.Sprintf(message, args...), reset)
}
