<?php
class UI
{
}
class UIMENU
{
    static function BUTTONS($href, $src, $text)
    {
        return "<a class='btn btn-light btn-menu-principal fw700' href='$href'>"
            . "<img src='$src' class='img-fluid d-block' style='max-height: 110px;'>"
            . $text
            . "</a>";
    }
}
