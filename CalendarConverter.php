<?php

$wgExtensionCredits["parserhook"][] = array(
   "path" => __FILE__,
   "name" => "CalendarConverter",
   "description" => "Provides a parser function and Scribunto Lua library to convert a date between different calendars",
   "author" => "Chunliang Lyu",
   "url" => "http://github.com/cllu/MediaWiki-CalendarConverter"
);

class CalendarConverter 
{
    public static function onParserFirstCallInit(&$parser)
    {
        $parser->setFunctionHook("lunar2solar", "CalendarConverter::lunar2solar");
        $parser->setFunctionHook("solar2lunar", "CalendarConverter::solar2lunar");
        return true;
    }

    public static function onScribuntoExternalLibraries($engine, &$extraLibraries)
    {
        $extraLibraries["mw.ext.calendarconverter"] = "CalendarConverterLua";
        return true;
    }

    public static function timeconvert($parser, $time="", $zoneName="", $format="")
    {
        try
        {
            $errors = array();
            if (empty($time))
            {
                $time = "now";
                $errors[] = wfMessage("timeconvert-notime", $time)->parse();
            }
            if (empty($zoneName))
            {
                $zoneName = "Etc/GMT";
                $errors[] = wfMessage("timeconvert-nozone", $zoneName)->parse();
            }
            if (empty($format))
            {
                $format = DateTime::ISO8601;
            }

            $dt = new DateTime($time);
            $dt->setTimezone(new DateTimeZone($zoneName));
            $formattedTime = $dt->format($format);

            if (!empty($errors))
            {
                global $wgLang;
                return "(" . $wgLang->commaList($errors) . ") " . $formattedTime;
            }
            return $formattedTime;
        }
        catch (Exception $e)
        {
            return $e->getMessage();
        }
    }

    private function __construct() {}
}

$wgHooks["ParserFirstCallInit"][] = "CalendarConverter::onParserFirstCallInit";
$wgHooks["ScribuntoExternalLibraries"][] = "CalendarConverter::onScribuntoExternalLibraries";
$wgAutoloadClasses["CalendarConverterLua"] = __DIR__ . "/CalendarConverterLua.php";
$wgAutoloadClasses["Lunar"] = __DIR__ . "/LunarSolarConverter.class.php";
$wgAutoloadClasses["Solar"] = __DIR__ . "/LunarSolarConverter.class.php";
$wgAutoloadClasses["LunarSolarConverter"] = __DIR__ . "/LunarSolarConverter.class.php";
$wgExtensionMessagesFiles["CalendarConverter"] = __DIR__ . "/CalendarConverter.i18n.php";

?>
