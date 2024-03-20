<?php
if (!function_exists('onUpdateCurrentTimestamp')) {
    function onUpdateCurrentTimestamp()
    {
        return DB::connection()->getDriverName() !== 'sqlite'
            ? DB::raw('CURRENT_TIMESTAMP')
            : null;
    }
}
?>