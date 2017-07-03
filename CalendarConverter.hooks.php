<?php

class CalendarConverterHooks {
    public static function onParserFirstCallInit(&$parser) {
        $parser->setFunctionHook("lunar2solar", "CalendarConverter::lunar2solar");
        $parser->setFunctionHook("solar2lunar", "CalendarConverter::solar2lunar");
        return true;
    }

    public static function onScribuntoExternalLibraries($engine, &$extraLibraries) {
        $extraLibraries["mw.ext.calendarconverter"] = "CalendarConverterLua";
        return true;
    }

    public static function timeconvert($parser, $time = "", $zoneName = "", $format = "") {
        try {
            $errors = array();
            if (empty($time)) {
                $time = "now";
                $errors[] = wfMessage("timeconvert-notime", $time)->parse();
            }
            if (empty($zoneName)) {
                $zoneName = "Etc/GMT";
                $errors[] = wfMessage("timeconvert-nozone", $zoneName)->parse();
            }
            if (empty($format)) {
                $format = DateTime::ISO8601;
            }

            $dt = new DateTime($time);
            $dt->setTimezone(new DateTimeZone($zoneName));
            $formattedTime = $dt->format($format);

            if (!empty($errors)) {
                global $wgLang;
                return "(" . $wgLang->commaList($errors) . ") " . $formattedTime;
            }
            return $formattedTime;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
