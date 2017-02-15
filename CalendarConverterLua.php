<?php

class CalendarConverterLua extends Scribunto_LuaLibraryBase
{
    public function register()
    {
        $lib = array(
            "lunar2solar" => array($this, "lunar2solar"),
            "solar2lunar" => array($this, "solar2lunar"),
        );
        $this->getEngine()->registerInterface( __DIR__ . "/CalendarConverter.lua", $lib);
    }

    public function lunar2solar($year, $month, $day, $isleap=false)
    {
        $lunar = new Lunar();
        $lunar->isleap = $isleap;
        $lunar->lunarYear = $year;
        $lunar->lunarMonth = $month;
        $lunar->lunarDay = $day;
        $solar = LunarSolarConverter::LunarToSolar($lunar);
        return array($solar->solarYear, $solar->solarMonth, $solar->solarDay);
    }

    public function solar2lunar($year, $month, $day)
    {
        $solar = new Solar();
        $solar->solarYear = $year;
        $solar->solarMonth = $month;
        $solar->solarDay = $day;
        $lunar = LunarSolarConverter::SolarToLunar($solar);
        return array($lunar->lunarYear, $lunar->lunarMonth, $lunar->lunarDay, $lunar->isleap);
    }
}

?>
