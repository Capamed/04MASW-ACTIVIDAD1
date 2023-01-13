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

class UIHTML
{
    static function HEADER($view)
    {

        $PHP1 = '';
        $PHP2 = '';
        $PHP3 = '';

        // $d2 = new DateTime();
        // $random = $d2->format('YmdHisu');

        $PHP1 .= "<link rel='stylesheet' href='{$view->path}/assets/css/menu.css?v={$view->random}' />";
        $PHP1 .= "<link rel='stylesheet' href='{$view->path}/assets/css/core.css?v={$view->random}' />";

        $PHP2 .= "$view->breadcrumb";

        $PHP3 .= "<div id='divBackground'><img src='{$view->path_img}simbolo-de-la-medicina.png'></div>";

        $HTML = file_get_contents($view->path_header, true);
        $HTML = str_replace("{{URL}}", $view->path, $HTML);
        $HTML = str_replace("<!--PHP1-->", $PHP1, $HTML);
        $HTML = str_replace("<!--PHP2-->", $PHP2, $HTML);
        $HTML = str_replace("<!--PHP3-->", $PHP3, $HTML);

        echo $HTML;
    }

    static function FOOTER($view)
    {
        // $d2 = new DateTime();
        // $random = $d2->format('YmdHisu');

        $HTML = file_get_contents($view->path_footer, true);
        $HTML = str_replace("{{URL}}", $view->path, $HTML);
        $HTML = str_replace("{{RANDOM}}", $view->random, $HTML);
        echo $HTML;
    }
}
