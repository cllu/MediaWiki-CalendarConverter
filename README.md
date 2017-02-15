# MediaWiki CalendarConverter

A MediaWiki extension that provides a parser function and Scribunto Lua library to convert a date between different calendars. Currently supports convertions between Lunar and Solar (Gregorian) calendars (dates between year 1900 and 2100).

## Scribunto Lua Library

LunarSolarConvert provides a [Scribunto](http://www.mediawiki.org/wiki/Extension:Scribunto) library, `mw.ext.calendarconverter`. Examples:

    local lunar2solar = mw.ext.calendarconverter.lunar2solar
    local solar2lunar = mw.ext.calendarconverter.solar2lunar
    solar2lunar(2014, 1, 1) => [2013, 12, 1]

