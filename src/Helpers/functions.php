<?php
if(!function_exists('character'))
{
    function character() {
        return \Auth::user()->character;
    }
}
