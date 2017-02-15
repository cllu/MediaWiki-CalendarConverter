local convert = {}
local php

function convert.setupInterface(options)
   -- Remove setup function.
   convert.setupInterface = nil

   -- Copy the PHP callbacks to a local variable, and remove the global one.
   php = mw_interface
   mw_interface = nil

   -- Do any other setup here.
   convert.solar2lunar = php.solar2lunar
   convert.lunar2solar = php.lunar2solar

   -- Install into the mw global.
   mw = mw or {}
   mw.ext = mw.ext or {}
   mw.ext.calendarconverter = convert

   -- Indicate that we're loaded.
   package.loaded["mw.ext.calendarconverter"] = convert
end

return convert
