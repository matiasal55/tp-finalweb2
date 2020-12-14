<?php


class includeAllDirectory
{
    public function includeAllFile($parcialDir)
    {
        foreach (glob($parcialDir . '*', GLOB_NOSORT) as $file) {

            include_once $file;
        }
    }
}