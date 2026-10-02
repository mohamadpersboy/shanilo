<?php
function change_language($from,$to)
{
    $page_route_name = session()->pull('previous-route');
    $page_route_name = trim($page_route_name);
    $page_route_name = str_replace(".".$from.".", ".".$to.".", $page_route_name);

    switch ($page_route_name) {
        case "front.".$to.".project-category.show":
            $result = "front.".$to.".project-category.index";
            break;
        case "front.".$to.".project.show":
            $result = "front.".$to.".project-category.index";
            break;
        case "front.".$to.".clinical-solution.show":
            $result = "front.".$to.".clinical-solution.index";
            break;
        case "front.".$to.".support.show":
            $result = "front.".$to.".home.index";
            break;
        case "front.".$to.".article.show":
            $result = "front.".$to.".article.index";
            break;
        case "front.".$to.".news.show":
            $result = "front.".$to.".news.index";
            break;
        default:
            $result = $page_route_name;
    }
    return route($result);
}
